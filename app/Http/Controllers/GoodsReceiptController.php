<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\ActivityLog;

class GoodsReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goodsReceipts = GoodsReceipt::with(['supplier', 'user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Statistik hari ini
        $today = now()->toDateString();
        $statsToday = [
            'total_transaksi' => GoodsReceipt::whereDate('tanggal', $today)->count(),
            'total_produk' => GoodsReceiptItem::whereHas('goodsReceipt', function($q) use ($today) {
                $q->whereDate('tanggal', $today);
            })->count(),
            'total_qty' => GoodsReceipt::whereDate('tanggal', $today)->sum('total_qty'),
        ];

        // Notifikasi stok menipis
        $stokMenipis = Product::stokMenipis()->get();

        return view('goods-receipt.index', compact('goodsReceipts', 'statsToday', 'stokMenipis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kodePenerimaan = GoodsReceipt::generateKodePenerimaan();
        $suppliers = Supplier::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $stokMenipis = Product::stokMenipis()->get();

        return view('goods-receipt.create', compact('kodePenerimaan', 'suppliers', 'products', 'stokMenipis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'tanggal' => 'required|date',
            'nomor_invoice_supplier' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'dokumen' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
        ], [
            'items.required' => 'Minimal harus ada 1 produk yang ditambahkan',
            'items.*.qty.min' => 'Qty minimal 1',
            'items.*.harga_beli.min' => 'Harga beli tidak boleh negatif',
        ]);

        DB::beginTransaction();
        try {
            // Upload dokumen
            $dokumenPath = null;
            if ($request->hasFile('dokumen')) {
                $dokumenPath = $request->file('dokumen')->store('goods-receipts', 'public');
            }

            // Simpan header
            $goodsReceipt = GoodsReceipt::create([
                'kode_penerimaan' => GoodsReceipt::generateKodePenerimaan(),
                'supplier_id' => $request->supplier_id,
                'tanggal' => $request->tanggal,
                'user_id' => auth()->id(),
                'nomor_invoice_supplier' => $request->nomor_invoice_supplier,
                'keterangan' => $request->keterangan,
                'dokumen' => $dokumenPath,
                'status' => 'completed',
            ]);

            $totalItem = 0;
            $totalQty = 0;

            // Simpan detail items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $stokSebelum = $product->stok;
                $stokSesudah = $stokSebelum + $item['qty'];

                // Buat detail item
                GoodsReceiptItem::create([
                    'goods_receipt_id' => $goodsReceipt->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'harga_beli' => $item['harga_beli'],
                    'keterangan' => $item['keterangan'] ?? null,
                ]);

                // Update stok produk
                $product->update(['stok' => $stokSesudah]);

                // Catat di stock log
                StockLog::create([
                    'product_id' => $item['product_id'],
                    'tanggal' => $request->tanggal,
                    'nomor_transaksi' => $goodsReceipt->kode_penerimaan,
                    'tipe' => 'masuk',
                    'qty' => $item['qty'],
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'user_id' => auth()->id(),
                    'keterangan' => 'Penerimaan barang dari supplier',
                ]);

                // Catat di activity log
                ActivityLog::create([
                    'log_type' => 'stock',
                    'user_id' => auth()->id(),
                    'model_type' => 'Product',
                    'model_id' => $product->id,
                    'pesan' => auth()->user()->name . ' menambahkan stok produk ' . $product->nama_produk . ' sebanyak ' . $item['qty'] . ' pada tanggal ' . date('d M Y', strtotime($request->tanggal)),
                    'data_baru' => [
                        'stok_sebelum' => $stokSebelum,
                        'stok_sesudah' => $stokSesudah,
                        'qty_masuk' => $item['qty'],
                    ],
                ]);

                $totalItem++;
                $totalQty += $item['qty'];
            }

            // Update total di header
            $goodsReceipt->update([
                'total_item' => $totalItem,
                'total_qty' => $totalQty,
            ]);

            DB::commit();
            toast()->success('Transaksi penerimaan barang berhasil disimpan');
            return redirect()->route('transaksi.goods-receipt.index');

        } catch (\Exception $e) {
            DB::rollBack();
            toast()->error('Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $goodsReceipt = GoodsReceipt::with(['supplier', 'user', 'items.product'])
            ->findOrFail($id);

        return view('goods-receipt.show', compact('goodsReceipt'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $goodsReceipt = GoodsReceipt::findOrFail($id);

            // Kembalikan stok
            foreach ($goodsReceipt->items as $item) {
                $product = $item->product;
                $stokBaru = $product->stok - $item->qty;
                
                $product->update(['stok' => max(0, $stokBaru)]);

                // Catat di stock log
                StockLog::create([
                    'product_id' => $product->id,
                    'tanggal' => now()->toDateString(),
                    'nomor_transaksi' => $goodsReceipt->kode_penerimaan . '-CANCEL',
                    'tipe' => 'keluar',
                    'qty' => $item->qty,
                    'stok_sebelum' => $product->stok + $item->qty,
                    'stok_sesudah' => max(0, $stokBaru),
                    'user_id' => auth()->id(),
                    'keterangan' => 'Pembatalan transaksi penerimaan barang',
                ]);
            }

            // Hapus dokumen jika ada
            if ($goodsReceipt->dokumen) {
                Storage::disk('public')->delete($goodsReceipt->dokumen);
            }

            $goodsReceipt->delete();

            DB::commit();
            toast()->success('Transaksi berhasil dihapus dan stok dikembalikan');
            return redirect()->route('transaksi.goods-receipt.index');

        } catch (\Exception $e) {
            DB::rollBack();
            toast()->error('Terjadi kesalahan: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Get product data for Select2
     */
    public function getProduct(Request $request)
    {
        $search = $request->get('search');
        $products = Product::where('is_active', true)
            ->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            })
            ->limit(10)
            ->get(['id', 'nama_produk', 'sku', 'stok', 'harga_beli_pokok']);

        $results = $products->map(function($product) {
            return [
                'id' => $product->id,
                'text' => $product->nama_produk . ' (' . $product->sku . ')',
                'nama_produk' => $product->nama_produk,
                'sku' => $product->sku,
                'stok' => $product->stok,
                'harga_beli' => $product->harga_beli_pokok,
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Get supplier data for Select2
     */
    public function getSupplier(Request $request)
    {
        $search = $request->get('search');
        $suppliers = Supplier::where('is_active', true)
            ->where(function($q) use ($search) {
                $q->where('nama_supplier', 'like', '%' . $search . '%')
                  ->orWhere('kode_supplier', 'like', '%' . $search . '%');
            })
            ->limit(10)
            ->get(['id', 'kode_supplier', 'nama_supplier']);

        $results = $suppliers->map(function($supplier) {
            return [
                'id' => $supplier->id,
                'text' => $supplier->nama_supplier . ' (' . $supplier->kode_supplier . ')',
                'kode_supplier' => $supplier->kode_supplier,
                'nama_supplier' => $supplier->nama_supplier,
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Find product by barcode/SKU
     */
    public function findByBarcode(Request $request)
    {
        $barcode = $request->get('barcode');
        $product = Product::where('sku', $barcode)
            ->orWhere('barcode', $barcode)
            ->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'nama_produk' => $product->nama_produk,
                    'sku' => $product->sku,
                    'stok' => $product->stok,
                    'harga_beli' => $product->harga_beli_pokok,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan'
        ]);
    }

    /**
     * Print goods receipt
     */
    public function print($id)
    {
        $goodsReceipt = GoodsReceipt::with(['supplier', 'user', 'items.product'])
            ->findOrFail($id);

        return view('goods-receipt.print', compact('goodsReceipt'));
    }
}
