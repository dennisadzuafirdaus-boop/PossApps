<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Kategori;

class ProductApiController extends Controller
{
    /**
     * Get all active products
     */
    public function index(Request $request)
    {
        $query = Product::with('kategori')
            ->where('is_active', true)
            ->where('stok', '>', 0);

        // Filter by kategori
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        $products = $query->orderBy('nama_produk')->get();

        return response()->json([
            'success' => true,
            'data' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'nama_produk' => $product->nama_produk,
                    'sku' => $product->sku,
                    'harga_jual' => $product->harga_jual,
                    'stok' => $product->stok,
                    'kategori' => $product->kategori->nama_kategori ?? '-',
                    'image' => $product->image ? asset('storage/' . $product->image) : null,
                ];
            })
        ]);
    }

    /**
     * Get product detail
     */
    public function show($id)
    {
        $product = Product::with('kategori')
            ->where('is_active', true)
            ->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'nama_produk' => $product->nama_produk,
                'sku' => $product->sku,
                'harga_jual' => $product->harga_jual,
                'stok' => $product->stok,
                'kategori' => $product->kategori->nama_kategori ?? '-',
                'image' => $product->image ? asset('storage/' . $product->image) : null,
            ]
        ]);
    }

    /**
     * Get all kategori
     */
    public function kategori()
    {
        $kategoris = Kategori::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => $kategoris
        ]);
    }
}
