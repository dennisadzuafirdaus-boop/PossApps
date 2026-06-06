@extends('layouts.ecommerce')

@section('title', 'Keranjang Belanja - POS Fashion')

@section('content')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        <i class="fas fa-shopping-cart text-purple-600 mr-2"></i>
        Keranjang Belanja
    </h1>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-white rounded-2xl shadow-md p-4 flex gap-4" id="cart-item-{{ $item->id }}">
                        <!-- Product Image -->
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                            @if($item->product->image)
                                <img src="/product_images/{{ $item->product->image }}" alt="{{ $item->product->nama_produk }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-tshirt text-purple-400 text-3xl"></i>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800">{{ $item->product->nama_produk }}</h3>
                            <p class="text-sm text-gray-500">{{ $item->product->kategori->nama_kategori ?? '-' }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-bold text-purple-600">Rp {{ number_format($item->product->harga_jual, 0, ',', '.') }}</span>
                                <div class="flex items-center gap-2">
                                    <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-8 h-8 bg-gray-100 rounded-full hover:bg-gray-200 transition">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="w-8 text-center" id="qty-{{ $item->id }}">{{ $item->quantity }}</span>
                                    <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-8 h-8 bg-gray-100 rounded-full hover:bg-gray-200 transition">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-right mt-2">
                                <span class="text-sm text-gray-500">Subtotal: </span>
                                <span class="font-semibold text-purple-600" id="subtotal-{{ $item->id }}">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <!-- Delete Button -->
                        <button onclick="removeItem({{ $item->id }})" class="text-gray-400 hover:text-red-500 transition self-start">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Customer Details Form -->
            @if(!auth('customer')->check())
            <div class="lg:col-span-1">
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-4">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-circle text-blue-600 mr-2"></i>Data Penerima
                    </h3>
                    <div class="space-y-3">
                        <input type="text" id="first_name" placeholder="Nama Depan"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 text-sm" required>
                        <input type="text" id="last_name" placeholder="Nama Belakang"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 text-sm">
                        <input type="email" id="email" placeholder="Email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 text-sm" required>
                        <input type="tel" id="phone" placeholder="No HP (08...)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 text-sm" required>
                    </div>
                </div>
            </div>
            @else
            <div class="lg:col-span-1">
                @php
                    $userPhone = auth('customer')->user()->phone;
                @endphp

                @if($userPhone)
                <!-- Data lengkap -->
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-4">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>Data Anda
                    </h3>
                    <input type="hidden" id="first_name" value="{{ auth('customer')->user()->name ?? '' }}">
                    <input type="hidden" id="last_name" value="">
                    <input type="hidden" id="email" value="{{ auth('customer')->user()->email ?? '' }}">
                    <input type="hidden" id="phone" value="{{ $userPhone }}">
                    <div class="space-y-2">
                        <p class="text-sm text-gray-700"><strong>Nama:</strong> {{ auth('customer')->user()->name ?? '-' }}</p>
                        <p class="text-sm text-gray-700"><strong>Email:</strong> {{ auth('customer')->user()->email ?? '-' }}</p>
                        <p class="text-sm text-gray-700"><strong>No HP:</strong> {{ $userPhone }}</p>
                    </div>
                </div>
                @else
                <!-- Data tidak lengkap - minta input phone -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 mb-4">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-yellow-600 mr-2"></i>Lengkapi Data
                    </h3>
                    <input type="hidden" id="first_name" value="{{ auth('customer')->user()->name ?? '' }}">
                    <input type="hidden" id="last_name" value="">
                    <input type="hidden" id="email" value="{{ auth('customer')->user()->email ?? '' }}">
                    <div class="space-y-3">
                        <p class="text-sm text-gray-700"><strong>Nama:</strong> {{ auth('customer')->user()->name ?? '-' }}</p>
                        <p class="text-sm text-gray-700"><strong>Email:</strong> {{ auth('customer')->user()->email ?? '-' }}</p>
                        <div>
                            <label class="text-sm text-gray-700 block mb-1"><strong>No HP (Wajib isi):</strong></label>
                            <input type="tel" id="phone" placeholder="No HP (08...)"
                                class="w-full px-4 py-2 border border-yellow-300 rounded-lg focus:outline-none focus:border-purple-500 text-sm" required>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                    <h3 class="font-semibold text-gray-800 mb-4 text-lg">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }} item)</span>
                            <span class="font-medium" id="cart-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium text-green-600">Gratis</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3">
                            <div class="flex justify-between">
                                <span class="font-semibold text-gray-800">Total</span>
                                <span class="font-bold text-purple-600 text-lg" id="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="mt-4">
                        <label class="text-sm text-gray-600 mb-2 block">Kode Promo</label>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Masukkan kode" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500">
                            <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                                Terapkan
                            </button>
                        </div>
                    </div>

                    <button type="button" onclick="startCheckout()" id="checkout-btn"
                        class="w-full mt-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full font-semibold hover:opacity-90 transition shadow-lg">
                        <i class="fas fa-lock mr-2"></i>
                        Checkout
                    </button>

                    <p class="text-center text-xs text-gray-500 mt-4">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Pembayaran 100% aman
                    </p>

                    <a href="{{ route('store.shop') }}" class="block text-center text-sm text-purple-600 hover:text-purple-700 mt-4">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart State -->
        <div class="text-center py-16">
            <div class="w-32 h-32 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-shopping-cart text-gray-300 text-5xl"></i>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Keranjang Anda Kosong</h2>
            <p class="text-gray-500 mb-6">Ayo mulai belanja dan temukan produk fashion favorit Anda!</p>
            <a href="{{ route('store.shop') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full font-semibold hover:opacity-90 transition">
                <i class="fas fa-shopping-bag mr-2"></i>
                Mulai Belanja
            </a>
        </div>
    @endif
</div>

<script>
function updateQuantity(cartId, quantity) {
    if (quantity < 1) {
        removeItem(cartId);
        return;
    }

    fetch(`/cart/update/${cartId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`qty-${cartId}`).textContent = quantity;
            document.getElementById(`subtotal-${cartId}`).textContent = formatRupiah(data.subtotal);
            document.getElementById('cart-subtotal').textContent = formatRupiah(data.total);
            document.getElementById('cart-total').textContent = formatRupiah(data.total);
            updateCartBadge(data.cart_count);
        } else {
            alert(data.message);
        }
    });
}

function removeItem(cartId) {
    if (!confirm('Hapus item dari keranjang?')) return;

    fetch(`/cart/remove/${cartId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`cart-item-${cartId}`).remove();
            document.getElementById('cart-subtotal').textContent = formatRupiah(data.total);
            document.getElementById('cart-total').textContent = formatRupiah(data.total);
            updateCartBadge(data.cart_count);
            
            if (data.cart_count === 0) {
                location.reload();
            }
        }
    });
}

function formatRupiah(number) {
    return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function updateCartBadge(count) {
    const badge = document.getElementById('cart-badge');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'inline' : 'none';
    }
}
</script>
<script>
// 🎯 FUNGSI CHECKOUT DENGAN MIDTRANS
function startCheckout() {
    console.clear();
    console.log('🚀 === CHECKOUT STARTED ===');

    // 1️⃣ AMBIL DATA TOTAL
    const cartTotalElement = document.getElementById('cart-total');
    if (!cartTotalElement) {
        console.error('❌ Element #cart-total tidak ditemukan!');
        alert('❌ Error: Cart total element not found');
        return;
    }

    const totalText = cartTotalElement.textContent;
    console.log('💰 Total text:', totalText);
    const total = parseInt(totalText.replace(/[^0-9]/g, ''));
    console.log('💰 Total (numeric):', total);

    // 2️⃣ AMBIL DATA CUSTOMER
    const firstNameElement = document.getElementById('first_name');
    const emailElement = document.getElementById('email');
    const phoneElement = document.getElementById('phone');
    const lastNameElement = document.getElementById('last_name');

    console.log('📋 Form Elements Check:');
    console.log('- first_name:', firstNameElement ? '✅ Found' : '❌ NOT found');
    console.log('- last_name:', lastNameElement ? '✅ Found' : '❌ NOT found');
    console.log('- email:', emailElement ? '✅ Found' : '❌ NOT found');
    console.log('- phone:', phoneElement ? '✅ Found' : '❌ NOT found');

    const firstName = firstNameElement?.value || '';
    const lastName = lastNameElement?.value || '';
    const email = emailElement?.value || '';
    const phone = phoneElement?.value || '';

    console.log('📝 Form Values:', { firstName, lastName, email, phone, total });

    // 3️⃣ VALIDASI DATA
    if (!firstName || !email || !phone) {
        console.error('❌ Validation failed - missing required fields');
        alert('⚠️ Mohon isi data: Nama, Email, dan No HP!');
        return;
    }

    if (!email.includes('@')) {
        console.error('❌ Invalid email format');
        alert('⚠️ Email tidak valid!');
        return;
    }

    if (!phone.match(/^(\+62|0)[0-9]{9,12}$/)) {
        console.error('❌ Invalid phone format');
        alert('⚠️ No HP harus dimulai dengan 0/+62 dan minimal 10 digit!');
        return;
    }

    // 4️⃣ DISABLE TOMBOL & TAMPILKAN LOADING
    const btn = document.getElementById('checkout-btn');
    if (!btn) {
        console.error('❌ Checkout button not found!');
        alert('❌ Error: Checkout button not found');
        return;
    }

    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

    console.log('📤 Mengirim data ke server...');
    console.log('🌐 Endpoint: /transaksi/payment/create');

    // 5️⃣ KIRIM KE BACKEND
    fetch('/transaksi/payment/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
            first_name: firstName,
            last_name: lastName,
            email: email,
            phone: phone,
            total: total
        })
    })
    .then(response => {
        console.log('📥 Response received - Status:', response.status);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.json();
    })
    .then(data => {
        console.log('📦 Data dari server:', data);

        if (data.status === 'success' && data.snap_token) {
            console.log('✅ Snap token diterima!');
            console.log('🔑 Token:', data.snap_token.substring(0, 50) + '...');

            // Cek apakah snap library sudah loaded
            if (typeof snap === 'undefined') {
                console.error('❌ Midtrans snap library tidak loaded!');
                alert('❌ Error: Midtrans library not loaded. Refresh halaman.');
                btn.disabled = false;
                btn.innerHTML = originalText;
                return;
            }

            console.log('✨ Membuka Midtrans popup...');

            // 6️⃣ TRIGGER MIDTRANS POPUP 🎯
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    console.log('✨ PEMBAYARAN BERHASIL!', result);
                    alert('✅ Pembayaran berhasil! Terima kasih telah berbelanja.');
                    setTimeout(() => {
                        window.location.href = '/store/orders';
                    }, 1000);
                },
                onPending: function(result) {
                    console.log('⏳ Pembayaran pending...', result);
                    alert('⏳ Pembayaran sedang diproses...');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                },
                onError: function(result) {
                    console.error('❌ Pembayaran gagal!', result);
                    alert('❌ Pembayaran gagal. Silakan coba lagi.');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                },
                onClose: function() {
                    console.log('❌ User menutup popup');
                    alert('❌ Anda menutup popup pembayaran. Silakan coba lagi.');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        } else {
            console.error('❌ Error dari server:', data.message);
            alert('❌ Error: ' + (data.message || 'Gagal membuat transaksi'));
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('❌ Network error:', error);
        console.error('Stack:', error.stack);
        alert('❌ Terjadi kesalahan koneksi: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}
</script>
@endsection
