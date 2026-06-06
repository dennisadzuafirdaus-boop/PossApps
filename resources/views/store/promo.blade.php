@extends('layouts.ecommerce')

@section('title', 'Promo - POS Fashion')

@section('content')
<!-- Promo Header -->
<section class="relative bg-gradient-to-r from-red-500 via-pink-500 to-red-600 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-300 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 relative z-10 text-center">
        <span class="inline-block px-4 py-1 bg-white/20 rounded-full text-sm font-medium mb-4 animate-pulse">
            <i class="fas fa-fire mr-2"></i>PENAWARAN TERBATAS
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
            PROMO SPESIAL
        </h1>
        <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
            Dapatkan diskon hingga 50% untuk produk pilihan! Penawaran berlaku selama periode tertentu.
        </p>
        <div class="flex justify-center gap-8 mt-8">
            <div class="text-center">
                <div class="text-4xl font-bold">50%</div>
                <div class="text-sm text-white/80">Diskon Maks</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold">{{ $products->total() }}</div>
                <div class="text-sm text-white/80">Produk Promo</div>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden group hover:shadow-xl transition transform hover:-translate-y-1 relative">
                <!-- Discount Badge -->
                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold z-10 animate-pulse">
                    -{{ rand(20, 50) }}%
                </span>

                <div class="relative overflow-hidden">
                    @if($product->image)
                        <img src="/product_images/{{ $product->image }}" alt="{{ $product->nama_produk }}" class="w-full h-48 md:h-56 object-cover group-hover:scale-110 transition duration-300">
                    @else
                        <div class="w-full h-48 md:h-56 bg-gradient-to-br from-red-200 to-pink-200 flex items-center justify-center">
                            <i class="fas fa-tshirt text-red-400 text-5xl"></i>
                        </div>
                    @endif

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
                    <h3 class="font-semibold text-gray-800 mb-1 truncate">{{ $product->nama_produk }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $product->kategori->nama_kategori ?? '-' }}</p>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-lg font-bold text-red-600">Rp {{ number_format($product->harga_jual * 0.7, 0, ',', '.') }}</span>
                        <span class="text-sm text-gray-400 line-through">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-green-600 font-medium">Hemat 30%</span>
                        <div class="flex items-center text-amber-400 text-sm">
                            <i class="fas fa-star"></i>
                            <span class="ml-1 text-gray-600">4.5</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-box-open text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum ada promo</h3>
                <p class="text-gray-500">Cek kembali nanti untuk penawaran menarik!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
