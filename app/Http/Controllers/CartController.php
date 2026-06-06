<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum('subtotal');

        return view('store.cart', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Check stock
        if ($product->stok < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak tersedia'
            ], 400);
        }

        $quantity = $request->quantity ?? 1;

        // Check if product already in cart
        $existingCart = $this->findCartItem($productId);

        if ($existingCart) {
            // Update quantity
            $newQuantity = $existingCart->quantity + $quantity;

            if ($newQuantity > $product->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah melebihi stok yang tersedia'
                ], 400);
            }

            $existingCart->update(['quantity' => $newQuantity]);

            return response()->json([
                'success' => true,
                'message' => 'Jumlah produk di keranjang diperbarui',
                'cart_count' => $this->getCartCount()
            ]);
        }

        // Create new cart item
        if ($quantity > $product->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi stok yang tersedia'
            ], 400);
        }

        Cart::create([
            'customer_id' => auth('customer')->id(),
            'session_id' => session()->getId(),
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => $this->getCartCount()
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $cartItem = $this->findCartItemById($id);

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $quantity = $request->quantity;

        if ($quantity < 1) {
            return $this->remove($id);
        }

        if ($quantity > $cartItem->product->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi stok yang tersedia'
            ], 400);
        }

        $cartItem->update(['quantity' => $quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Keranjang diperbarui',
            'subtotal' => $cartItem->subtotal,
            'total' => $this->getCartItems()->sum('subtotal'),
            'cart_count' => $this->getCartCount()
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cartItem = $this->findCartItemById($id);

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item dihapus dari keranjang',
            'total' => $this->getCartItems()->sum('subtotal'),
            'cart_count' => $this->getCartCount()
        ]);
    }

    /**
     * Clear all items from cart
     */
    public function clear()
    {
        $this->getCartItems()->each->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang dikosongkan',
            'cart_count' => 0
        ]);
    }

    /**
     * Get cart count
     */
    public function count()
    {
        return response()->json([
            'count' => $this->getCartCount()
        ]);
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
     * Find cart item by product ID
     */
    private function findCartItem($productId)
    {
        $query = Cart::where('product_id', $productId);

        if (auth('customer')->check()) {
            $query->where('customer_id', auth('customer')->id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->first();
    }

    /**
     * Find cart item by ID
     */
    private function findCartItemById($id)
    {
        $query = Cart::where('id', $id);

        if (auth('customer')->check()) {
            $query->where('customer_id', auth('customer')->id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->first();
    }

    /**
     * Get total items count in cart
     */
    private function getCartCount()
    {
        return $this->getCartItems()->sum('quantity');
    }
}
