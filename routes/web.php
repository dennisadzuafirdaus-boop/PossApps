<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\GoodsReceiptController;
use App\Http\Controllers\StockLogController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PeymentController;

/*
|||--------------------------------------------------------------------------
||| Web Routes
|||--------------------------------------------------------------------------
|||
||| Here is where you can register web routes for your application. These
||| routes are loaded by the RouteServiceProvider and all of them will
||| be assigned the "web" middleware group. Make something great!
|||
*/

// =============================================
// PUBLIC API - Untuk Landing Page E-commerce
// =============================================
Route::prefix('api')->as('api.')->group(function () {
    Route::get('/products', [ProductApiController::class, 'index'])->name('products');
    Route::get('/products/{id}', [ProductApiController::class, 'show'])->name('products.show');
    Route::get('/kategori', [ProductApiController::class, 'kategori'])->name('kategori');
});

// =============================================
// E-COMMERCE STORE - PUBLIC PAGES
// =============================================
Route::prefix('store')->as('store.')->controller(StoreController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/shop', 'shop')->name('shop');
    Route::get('/pria', 'pria')->name('pria');
    Route::get('/wanita', 'wanita')->name('wanita');
    Route::get('/promo', 'promo')->name('promo');
    Route::get('/product/{id}', 'show')->name('show');
    Route::get('/cart', 'cart')->name('cart');
    Route::get('/profile', 'profile')->name('profile');
    Route::get('/orders', 'orders')->name('orders');
    Route::get('/wishlist', 'wishlist')->name('wishlist');
});

// =============================================
// CART ROUTES
// =============================================
Route::prefix('cart')->as('cart.')->controller(CartController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/add/{productId}', 'add')->name('add');
    Route::put('/update/{id}', 'update')->name('update');
    Route::delete('/remove/{id}', 'remove')->name('remove');
    Route::delete('/clear', 'clear')->name('clear');
    Route::get('/count', 'count')->name('count');
});

// =============================================
// PAYMENT ROUTES - CUSTOMER CHECKOUT
// =============================================
Route::prefix('transaksi/payment')->as('transaksi.payment.')->controller(PeymentController::class)->group(function () {
    Route::post('/create', 'createTransaction')->name('create');
    Route::post('/notification', 'handleNotification')->name('notification'); // webhook Midtrans
    Route::get('/{id}', 'show')->name('show');
});

// =============================================
// CUSTOMER AUTHENTICATION
// =============================================
Route::prefix('customer')->as('customer.')->controller(CustomerAuthController::class)->group(function () {
    // Login
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.post');
    
    // Register
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.post');
    
    // Google OAuth
    Route::get('/auth/google', 'redirectToGoogle')->name('google.redirect');
    Route::get('/auth/google/callback', 'handleGoogleCallback')->name('google.callback');
    
    // Logout
    Route::post('/logout', 'logout')->name('logout');
    
    // Profile (require customer auth)
    Route::middleware('auth:customer')->group(function () {
        Route::get('/profile', 'profile')->name('profile.page');
        Route::put('/profile', 'updateProfile')->name('profile.update');
        Route::put('/password', 'updatePassword')->name('password.update');
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'handlelogin'])
        ->name('login.post');
});

Route::middleware('auth')->group(function () {
    // Welcome Transition Page
    Route::get('/welcome', function () {
        return view('auth.welcome-transition');
    })->name('welcome.transition');

    // Dashboard - SEMUA USER
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    // Get Data API - SEMUA USER
    Route::prefix('get-data')->as('get-data.')->group(function () {
        Route::get('/product', [ProductController::class, 'getData'])->name('product');
        Route::get('/cek-stok-product', [ProductController::class, 'cekStok'])->name('cek-stok');
    });

    // =============================================
    // USER MANAGEMENT - HANYA ADMIN
    // =============================================
    Route::middleware('role:admin')->prefix('users')->as('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/reset-password', 'resetPassword')->name('reset-password');
    });

    // Ganti Password & Update Profil - SEMUA USER
    Route::controller(UserController::class)->group(function () {
        Route::post('/ganti-password', 'gantiPassword')->name('users.ganti-password');
        Route::put('/update-profil', 'updateProfil')->name('users.update-profil');
    });

    // =============================================
    // MASTER DATA
    // =============================================
    Route::prefix('master-data')->as('master-data.')->group(function () {
        // Kategori - ADMIN: semua, USER: hanya lihat
        Route::prefix('kategori')->as('kategori.')->controller(KategoriController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::middleware('role:admin')->group(function () {
                Route::post('/', 'store')->name('store');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
        });

        // Product - ADMIN: semua, USER: hanya lihat
        Route::prefix('product')->as('product.')->controller(ProductController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::middleware('role:admin')->group(function () {
                Route::post('/', 'store')->name('store');
                Route::delete('/{id}/destroy', 'destroy')->name('destroy');
            });
        });

        // Supplier - ADMIN: semua, USER: hanya lihat
        Route::prefix('supplier')->as('supplier.')->controller(SupplierController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::middleware('role:admin')->group(function () {
                Route::post('/', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::post('/{id}/toggle-status', 'toggleStatus')->name('toggle-status');
            });
        });
    });

    // =============================================
    // TRANSAKSI - SEMUA USER
    // =============================================
    Route::prefix('transaksi')->as('transaksi.')->group(function () {
        Route::prefix('goods-receipt')->as('goods-receipt.')->controller(GoodsReceiptController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/get-product', 'getProduct')->name('get-product');
            Route::get('/get-supplier', 'getSupplier')->name('get-supplier');
            Route::get('/find-by-barcode', 'findByBarcode')->name('find-by-barcode');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/{id}/print', 'print')->name('print');
            // Hanya admin bisa hapus transaksi
            Route::middleware('role:admin')->group(function () {
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
        });
        //payment dari customer
    });

    // =============================================
    // ORDER MANAGEMENT - SEMUA USER
    // =============================================
    Route::prefix('order')->as('order.')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}/confirm', 'confirm')->name('confirm');
        Route::put('/{id}/status', 'updateStatus')->name('update-status');
        Route::put('/{id}/payment', 'updatePaymentStatus')->name('update-payment');
        Route::get('/{id}/print', 'print')->name('print');
    });

    // =============================================
    // LAPORAN - SEMUA USER
    // =============================================
    Route::prefix('laporan')->as('laporan.')->group(function () {
        Route::prefix('stock-log')->as('stock-log.')->controller(StockLogController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/export-excel', 'exportExcel')->name('export-excel');
            Route::get('/print', 'print')->name('print');
        });

        Route::prefix('activity-log')->as('activity-log.')->controller(ActivityLogController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/export-excel', 'exportExcel')->name('export-excel');
        });
    });

    // =============================================
    // transaction mitrans
    // =============================================
});
