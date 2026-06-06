<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with('items.product');

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by date
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhere('customer_name', 'like', '%' . $search . '%')
                  ->orWhere('customer_email', 'like', '%' . $search . '%');
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'completed' => Order::where('status', 'completed')->count(),
        ];

        return view('order.index', compact('orders', 'stats'));
    }

    /**
     * Display order detail
     */
    public function show($id)
    {
        $order = Order::with(['items.product', 'confirmer'])->findOrFail($id);

        return view('order.show', compact('order'));
    }

    /**
     * Confirm order
     */
    public function confirm($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);

            if ($order->status !== 'pending') {
                return back()->with('error', 'Order sudah dikonfirmasi sebelumnya');
            }

            // Check stock availability
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if (!$product || $product->stok < $item->qty) {
                    return back()->with('error', "Stok produk {$item->product_name} tidak mencukupi");
                }
            }

            // Reduce stock
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                $stokSebelum = $product->stok;
                $stokSesudah = $stokSebelum - $item->qty;

                $product->update(['stok' => $stokSesudah]);

                // Log stock
                StockLog::create([
                    'product_id' => $product->id,
                    'tanggal' => now()->toDateString(),
                    'nomor_transaksi' => $order->order_number,
                    'tipe' => 'keluar',
                    'qty' => $item->qty,
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $stokSesudah,
                    'user_id' => auth()->id(),
                    'keterangan' => 'Penjualan online - ' . $order->customer_name,
                ]);

                // Activity log
                ActivityLog::create([
                    'log_type' => 'transaksi',
                    'user_id' => auth()->id(),
                    'model_type' => 'Order',
                    'model_id' => $order->id,
                    'pesan' => auth()->user()->name . ' mengkonfirmasi order ' . $order->order_number . ' dari ' . $order->customer_name,
                    'data_baru' => [
                        'order_number' => $order->order_number,
                        'customer' => $order->customer_name,
                        'total' => $order->total,
                    ],
                ]);
            }

            // Update order status
            $order->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'confirmed_by' => auth()->id(),
            ]);

            DB::commit();
            toast()->success('Order berhasil dikonfirmasi');
            return redirect()->route('order.index');

        } catch (\Exception $e) {
            DB::rollBack();
            toast()->error('Terjadi kesalahan: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;

        // If cancelling, return stock
        if ($request->status === 'cancelled' && $order->status === 'confirmed') {
            DB::beginTransaction();
            try {
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    $stokSebelum = $product->stok;
                    $stokSesudah = $stokSebelum + $item->qty;

                    $product->update(['stok' => $stokSesudah]);

                    StockLog::create([
                        'product_id' => $product->id,
                        'tanggal' => now()->toDateString(),
                        'nomor_transaksi' => $order->order_number . '-CANCEL',
                        'tipe' => 'masuk',
                        'qty' => $item->qty,
                        'stok_sebelum' => $stokSebelum,
                        'stok_sesudah' => $stokSesudah,
                        'user_id' => auth()->id(),
                        'keterangan' => 'Pembatalan order - ' . $order->customer_name,
                    ]);
                }

                $order->update(['status' => $request->status]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                toast()->error('Terjadi kesalahan: ' . $e->getMessage());
                return back();
            }
        } else {
            $order->update(['status' => $request->status]);
        }

        toast()->success('Status order berhasil diupdate');
        return back();
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $request->payment_status]);

        toast()->success('Status pembayaran berhasil diupdate');
        return back();
    }

    /**
     * Print order
     */
    public function print($id)
    {
        $order = Order::with(['items.product', 'confirmer'])->findOrFail($id);

        return view('order.print', compact('order'));
    }
}
