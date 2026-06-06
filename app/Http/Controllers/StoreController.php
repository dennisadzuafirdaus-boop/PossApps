<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Kategori;
use App\Models\Cart;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Home / Landing Page
     */
    public function index()
    {
        $products = Product::with('kategori')
            ->where('stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('store.index', compact('products'));
    }

    /**
     * Shop - Semua Produk
     */
    public function shop(Request $request)
    {
        $query = Product::with('kategori')->where('stok', '>', 0);

        // Filter by kategori
        if ($request->kategori) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', 'like', '%' . $request->kategori . '%');
            });
        }

        // Search
        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sort = $request->sort ?? 'terbaru';
        switch ($sort) {
            case 'terlaris':
                $query->orderBy('stok', 'asc');
                break;
            case 'termurah':
                $query->orderBy('harga_jual', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga_jual', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $kategoris = Kategori::all();

        return view('store.shop', compact('products', 'kategoris'));
    }

    /**
     * Produk Pria
     */
    public function pria(Request $request)
    {
        $query = Product::with('kategori')
            ->where('stok', '>', 0)
            ->whereHas('kategori', function ($q) {
                $q->where('nama_kategori', 'like', '%pria%')
                  ->orWhere('nama_kategori', 'like', '%Pria%');
            });

        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return view('store.shop', [
            'products' => $products,
            'kategoris' => Kategori::all(),
            'title' => 'Koleksi Pria',
            'subtitle' => 'Temukan fashion pria terbaik'
        ]);
    }

    /**
     * Produk Wanita
     */
    public function wanita(Request $request)
    {
        $query = Product::with('kategori')
            ->where('stok', '>', 0)
            ->whereHas('kategori', function ($q) {
                $q->where('nama_kategori', 'like', '%wanita%')
                  ->orWhere('nama_kategori', 'like', '%Wanita%');
            });

        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return view('store.shop', [
            'products' => $products,
            'kategoris' => Kategori::all(),
            'title' => 'Koleksi Wanita',
            'subtitle' => 'Temukan fashion wanita terbaik'
        ]);
    }

    /**
     * Promo Products
     */
    public function promo()
    {
        // Untuk saat ini tampilkan semua produk sebagai demo promo
        // Nanti bisa ditambahkan field promo di tabel products
        $products = Product::with('kategori')
            ->where('stok', '>', 0)
            ->inRandomOrder()
            ->paginate(12);

        return view('store.promo', compact('products'));
    }

    /**
     * Product Detail
     */
    public function show($id)
    {
        $product = Product::with('kategori')->findOrFail($id);
        $relatedProducts = Product::with('kategori')
            ->where('kategori_id', $product->kategori_id)
            ->where('id', '!=', $id)
            ->where('stok', '>', 0)
            ->take(4)
            ->get();

        return view('store.show', compact('product', 'relatedProducts'));
    }

    /**
     * Cart Page
     */
    public function cart()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum('subtotal');

        return view('store.cart', compact('cartItems', 'total'));
    }

    /**
     * Get cart items for current user/session
     */
    private function getCartItems()
    {
        $query = Cart::with('product.kategori');

        if (auth('customer')->check()) {
            $query->where('customer_id', auth('customer')->id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->get();
    }

    /**
     * User Profile
     */
    public function profile()
    {
        return view('store.profile');
    }

    /**
     * User Orders
     */
    public function orders()
    {
        return view('store.orders');
    }

    /**
     * Wishlist
     */
    public function wishlist()
    {
        return view('store.wishlist');
    }
}
