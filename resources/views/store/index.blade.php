@extends('layouts.ecommerce')

@section('title', 'POS Fashion - Fashion Store Pria & Wanita')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-purple-600 via-indigo-600 to-purple-700 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-300 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <span class="inline-block px-4 py-1 bg-white/20 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-fire mr-2"></i>NEW COLLECTION 2026
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Temukan Gaya
                    <span class="block text-yellow-300">Terbaikmu</span>
                </h1>
                <p class="text-lg md:text-xl text-white/90 mb-8 max-w-lg">
                    Koleksi fashion terbaru untuk pria dan wanita dengan kualitas premium dan harga terjangkau.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('store.shop') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-600 rounded-full font-semibold hover:bg-yellow-300 hover:text-purple-700 transition transform hover:scale-105 shadow-lg">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        Belanja Sekarang
                    </a>
                    <a href="#collections" class="inline-flex items-center px-6 py-3 border-2 border-white text-white rounded-full font-semibold hover:bg-white hover:text-purple-600 transition">
                        <i class="fas fa-eye mr-2"></i>
                        Lihat Koleksi
                    </a>
                </div>
            </div>
            <div class="hidden md:flex justify-center">
                <div class="relative">
                    <div class="w-80 h-80 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-tshirt text-9xl text-white/80"></i>
                    </div>
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                        <span class="text-purple-900 font-bold text-sm">50% OFF</span>
                    </div>
                    <div class="absolute -bottom-2 -left-2 w-16 h-16 bg-pink-400 rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Kategori Populer</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan berbagai kategori fashion terbaik untuk melengkapi gaya Anda</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('store.pria') }}" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-lg hover:shadow-xl transition transform hover:-translate-y-2">
                <div class="relative z-10">
                    <i class="fas fa-male text-4xl mb-4 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold mb-1">Pria</h3>
                    <p class="text-sm text-white/80">150+ Produk</p>
                </div>
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-8 -mt-8"></div>
            </a>
            <a href="{{ route('store.wanita') }}" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 p-6 text-white shadow-lg hover:shadow-xl transition transform hover:-translate-y-2">
                <div class="relative z-10">
                    <i class="fas fa-female text-4xl mb-4 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold mb-1">Wanita</h3>
                    <p class="text-sm text-white/80">200+ Produk</p>
                </div>
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-8 -mt-8"></div>
            </a>
            <a href="{{ route('store.shop') }}" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 p-6 text-white shadow-lg hover:shadow-xl transition transform hover:-translate-y-2">
                <div class="relative z-10">
                    <i class="fas fa-gem text-4xl mb-4 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold mb-1">Aksesoris</h3>
                    <p class="text-sm text-white/80">80+ Produk</p>
                </div>
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-8 -mt-8"></div>
            </a>
            <a href="{{ route('store.promo') }}" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-red-500 to-red-600 p-6 text-white shadow-lg hover:shadow-xl transition transform hover:-translate-y-2">
                <div class="relative z-10">
                    <i class="fas fa-tags text-4xl mb-4 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold mb-1">Promo</h3>
                    <p class="text-sm text-white/80">Diskon s/d 70%</p>
                </div>
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -mr-8 -mt-8"></div>
                <span class="absolute top-2 right-2 bg-yellow-400 text-xs text-red-900 px-2 py-1 rounded-full font-bold">HOT</span>
            </a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section id="collections" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Produk Terbaru</h2>
                <p class="text-gray-600 mt-2">Koleksi fashion terbaru untuk Anda</p>
            </div>
            <a href="{{ route('store.shop') }}" class="hidden md:inline-flex items-center text-purple-600 hover:text-purple-700 font-medium">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products ?? [] as $product)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden group hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="relative overflow-hidden">
                        <a href="{{ route('store.show', $product->id) }}">
                            @if($product->image)
                                <img src="/product_images/{{ $product->image }}" alt="{{ $product->nama_produk }}" class="w-full h-48 md:h-56 object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-48 md:h-56 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                        </a>
                        @if($product->stok <= 5 && $product->stok > 0)
                            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium">Stok Terbatas</span>
                        @elseif($product->stok <= 0)
                            <span class="absolute top-2 left-2 bg-gray-500 text-white text-xs px-2 py-1 rounded-full font-medium">Habis</span>
                        @endif
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                            <button onclick="event.preventDefault(); addToCartHome({{ $product->id }})" class="p-3 bg-white rounded-full text-purple-600 hover:bg-purple-600 hover:text-white transition">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            <button class="p-3 bg-white rounded-full text-red-500 hover:bg-red-500 hover:text-white transition">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    <a href="{{ route('store.show', $product->id) }}">
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-1 truncate">{{ $product->nama_produk }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $product->kategori->nama_kategori ?? '-' }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-purple-600">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                                <div class="flex items-center text-amber-400 text-sm">
                                    <i class="fas fa-star"></i>
                                    <span class="ml-1 text-gray-600">4.5</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                @php
                    $demoProducts = [
                        ['nama' => 'Kemeja Pria Premium', 'kategori' => 'Pria', 'harga' => 250000],
                        ['nama' => 'Dress Wanita Elegant', 'kategori' => 'Wanita', 'harga' => 350000],
                        ['nama' => 'Celana Jeans Slim Fit', 'kategori' => 'Pria', 'harga' => 280000],
                        ['nama' => 'Blouse Wanita Modern', 'kategori' => 'Wanita', 'harga' => 180000],
                    ];
                @endphp
                @foreach($demoProducts as $demo)
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden group hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            <div class="w-full h-48 md:h-56 bg-gradient-to-br from-purple-200 to-indigo-200 flex items-center justify-center">
                                <i class="fas fa-tshirt text-purple-400 text-5xl"></i>
                            </div>
                            <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-medium">New</span>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                                <button class="p-3 bg-white rounded-full text-purple-600 hover:bg-purple-600 hover:text-white transition">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <button class="p-3 bg-white rounded-full text-red-500 hover:bg-red-500 hover:text-white transition">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $demo['nama'] }}</h3>
                            <p class="text-sm text-gray-500 mb-2">{{ $demo['kategori'] }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-purple-600">Rp {{ number_format($demo['harga'], 0, ',', '.') }}</span>
                                <div class="flex items-center text-amber-400 text-sm">
                                    <i class="fas fa-star"></i>
                                    <span class="ml-1 text-gray-600">4.5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>

        <div class="text-center mt-10 md:hidden">
            <a href="{{ route('store.shop') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-full font-medium hover:bg-purple-700 transition">
                Lihat Semua Produk <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Promo Banner -->
<section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-white text-center md:text-left">
                <span class="inline-block px-4 py-1 bg-white/20 rounded-full text-sm font-medium mb-4">
                    <i class="fas fa-gift mr-2"></i>PROMO SPESIAL
                </span>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Diskon hingga 50%</h2>
                <p class="text-white/80 mb-6 max-w-lg">Dapatkan penawaran terbaik untuk koleksi fashion terbaru. Promo berlaku hingga akhir bulan ini!</p>
                <a href="{{ route('store.promo') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-600 rounded-full font-semibold hover:bg-yellow-300 transition">
                    <i class="fas fa-tags mr-2"></i>
                    Lihat Promo
                </a>
            </div>
            <div class="relative">
                <div class="w-48 h-48 md:w-64 md:h-64 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-percentage text-6xl md:text-8xl text-white"></i>
                </div>
                <div class="absolute -top-4 -right-4 w-16 h-16 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                    <span class="text-purple-900 font-bold">50%</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center group">
                <div class="w-16 h-16 mx-auto bg-purple-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-purple-200 transition">
                    <i class="fas fa-truck text-2xl text-purple-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Gratis Ongkir</h3>
                <p class="text-sm text-gray-500">Untuk pembelian di atas Rp 200.000</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-200 transition">
                    <i class="fas fa-shield-alt text-2xl text-blue-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Pembayaran Aman</h3>
                <p class="text-sm text-gray-500">100% transaksi dijamin aman</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-green-200 transition">
                    <i class="fas fa-undo text-2xl text-green-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Mudah Dikembalikan</h3>
                <p class="text-sm text-gray-500">7 hari garansi pengembalian</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 mx-auto bg-amber-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-amber-200 transition">
                    <i class="fas fa-headset text-2xl text-amber-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">Support 24/7</h3>
                <p class="text-sm text-gray-500">Layanan pelanggan siap membantu</p>
            </div>
        </div>
    </div>
</section>

<script>
function addToCartHome(productId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            updateCartBadge(data.cart_count);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

function updateCartBadge(count) {
    const badge = document.getElementById('cart-badge');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'inline' : 'none';
    }
}
</script>
@endsection
