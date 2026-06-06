@extends('layouts.ecommerce')

@section('title', 'Wishlist - POS Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        <i class="fas fa-heart text-red-500 mr-2"></i>
        Wishlist Saya
    </h1>

    <!-- Empty Wishlist -->
    <div class="text-center py-16">
        <div class="w-32 h-32 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-heart text-gray-300 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Wishlist Kosong</h2>
        <p class="text-gray-500 mb-6">Anda belum menambahkan produk ke wishlist. Simpan produk favorit Anda!</p>
        <a href="{{ route('store.shop') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full font-semibold hover:opacity-90 transition">
            <i class="fas fa-shopping-bag mr-2"></i>
            Jelajahi Produk
        </a>
    </div>

    <!-- Wishlist Grid (Demo - hidden) -->
    <div class="hidden grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @php
            $wishlist = [
                ['nama' => 'Kemeja Pria Premium', 'harga' => 250000],
                ['nama' => 'Dress Wanita Elegant', 'harga' => 350000],
            ];
        @endphp

        @foreach($wishlist as $item)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden group hover:shadow-xl transition">
                <div class="relative overflow-hidden">
                    <div class="w-full h-48 bg-gradient-to-br from-purple-200 to-indigo-200 flex items-center justify-center">
                        <i class="fas fa-tshirt text-purple-400 text-5xl"></i>
                    </div>
                    <button class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition shadow">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-1">{{ $item['nama'] }}</h3>
                    <span class="text-lg font-bold text-purple-600">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                    <button class="w-full mt-3 py-2 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition">
                        <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
