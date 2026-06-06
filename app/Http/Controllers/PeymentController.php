<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeymentController extends Controller
{
    public function __construct()
    {
        //konfigurasi Midtrans
        Config::$serverKey     = config('midtrans.server_key');
        Config::$clientKey     = config('midtrans.client_key');
        Config::$isProduction  = config('midtrans.is_production');
        Config::$isSanitized   = config('midtrans.is_sanitized');
        Config::$is3ds         = config('midtrans.is_3ds');
    }

    /**
     * 🎯 CREATE TRANSACTION - Generate Snap Token untuk Midtrans
     */
    public function createTransaction(Request $request)
    {
        Log::info('=== CHECKOUT REQUEST ===');
        Log::info('Request data:', $request->all());

        // 1️⃣ VALIDASI INPUT
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'nullable|string|max:50',
            'email'      => 'required|email|max:100',
            'phone'      => 'required|string|max:20',
            'total'      => 'nullable|numeric|min:0'
        ]);

        Log::info('Validated data:', $validated);

        // 2️⃣ AMBIL TOTAL DARI CART USER
        $cartTotal = $this->getCartTotal($request);

        Log::info('Cart Total:', ['total' => $cartTotal]);

        if ($cartTotal == 0) {
            Log::warning('Cart is empty');
            return response()->json([
                'status' => 'error',
                'message' => 'Keranjang belanja kosong'
            ], 400);
        }

        // 3️⃣ BUAT PARAMETER MIDTRANS
        $customerId = auth('customer')->id() ?? 'guest-' . time();
        $orderId = 'ORDER-' . $customerId . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'      => $orderId,
                'gross_amount'  => $cartTotal,
            ],
            'customer_details' => [
                'first_name'  => $validated['first_name'],
                'last_name'   => $validated['last_name'] ?? '',
                'email'       => $validated['email'],
                'phone'       => $validated['phone'],
            ],
            'item_details' => $this->getItemDetails($request),
        ];

        try {
            // 4️⃣ GENERATE SNAP TOKEN
            $snaptoken = Snap::getSnapToken($params);

            // 5️⃣ RETURN RESPONSE
            return response()->json([
                'status' => 'success',
                'snap_token' => $snaptoken,
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage(), [
                'order_id' => $orderId ?? null
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 📦 AMBIL TOTAL DARI CART
     */
    private function getCartTotal(Request $request)
    {
        try {
            // 1️⃣ Cek jika customer login, ambil dari database
            if (auth('customer')->check()) {
                $customerId = auth('customer')->id();
                Log::info('Customer logged in:', ['customer_id' => $customerId]);

                $total = DB::table('carts')
                    ->join('products', 'carts.product_id', '=', 'products.id')
                    ->where('carts.customer_id', $customerId)
                    ->sum(DB::raw('carts.quantity * products.harga_jual'));

                Log::info('Cart query result:', ['total' => $total]);
                return (int)$total;
            }

            // 2️⃣ Jika tidak login, ambil dari request (dari frontend)
            $totalFromRequest = (int)($request->input('total') ?? 0);
            Log::info('Using total from request:', ['total' => $totalFromRequest]);
            return $totalFromRequest;

        } catch (\Exception $e) {
            Log::error('Error getting cart total:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return 0;
        }
    }

    /**
     * 🛒 AMBIL DETAIL ITEM DARI CART
     */
    private function getItemDetails(Request $request)
    {
        $items = [];

        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();
            $cartItems = DB::table('carts')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->where('carts.customer_id', $customerId)
                ->get(['products.id', 'products.nama_produk', 'products.harga_jual', 'carts.quantity']);

            foreach ($cartItems as $item) {
                $items[] = [
                    'id' => $item->id,
                    'name' => $item->nama_produk,
                    'price' => (int)$item->harga_jual,
                    'quantity' => $item->quantity
                ];
            }
        }

        return $items;
    }

    /**
     * 🔔 WEBHOOK NOTIFICATION DARI MIDTRANS
     */
    public function handleNotification(Request $request)
    {
        $notif = json_decode(file_get_contents('php://input'), true);

        Log::info('Midtrans Notification:', $notif);

        try {
            // Validasi signature
            $serverKey = config('midtrans.server_key');
            $orderId = $notif['order_id'];
            $statusCode = $notif['status_code'];
            $transactionStatus = $notif['transaction_status'];
            $signature = $notif['signature_key'];

            $hash = hash('sha512', $orderId . $statusCode . $notif['gross_amount'] . $serverKey);

            if ($signature !== $hash) {
                Log::warning('Invalid Midtrans signature');
                return response()->json(['error' => 'Invalid signature'], 401);
            }

            // Update status berdasarkan transaction status
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                // ✅ PEMBAYARAN BERHASIL
                $this->updateOrderStatus($orderId, 'paid');
                Log::info('Payment successful for order: ' . $orderId);
            } else if ($transactionStatus == 'pending') {
                // ⏳ PEMBAYARAN PENDING
                $this->updateOrderStatus($orderId, 'pending');
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'cancel' || $transactionStatus == 'expire') {
                // ❌ PEMBAYARAN GAGAL
                $this->updateOrderStatus($orderId, 'failed');
                Log::warning('Payment failed for order: ' . $orderId);
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * 📝 UPDATE STATUS ORDER
     */
    private function updateOrderStatus($orderId, $status)
    {
        // Sesuaikan dengan table dan logic Anda
        // Contoh: Update di table orders / payments
        Log::info("Order $orderId status updated to: $status");
    }

    /**
     * 📋 SHOW PAYMENT DETAIL
     */
    public function show($id)
    {
        // Tampilkan detail pembayaran berdasarkan order ID
        return response()->json([
            'message' => 'Payment detail for order: ' . $id
        ]);
    }
}

