@extends('layouts.ecommerce')

@section('title', 'Pesanan Saya - POS Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        <i class="fas fa-shopping-bag text-purple-600 mr-2"></i>
        Pesanan Saya
    </h1>

    <!-- Order Tabs -->
    <div class="flex overflow-x-auto gap-2 mb-8 pb-2">
        <button class="px-4 py-2 bg-purple-600 text-white rounded-full font-medium whitespace-nowrap">
            Semua
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full font-medium whitespace-nowrap hover:bg-gray-200 transition">
            Menunggu Pembayaran
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full font-medium whitespace-nowrap hover:bg-gray-200 transition">
            Diproses
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full font-medium whitespace-nowrap hover:bg-gray-200 transition">
            Dikirim
        </button>
        <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-full font-medium whitespace-nowrap hover:bg-gray-200 transition">
            Selesai
        </button>
    </div>

    <!-- Empty Orders -->
    <div class="text-center py-16">
        <div class="w-32 h-32 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-box-open text-gray-300 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Belum Ada Pesanan</h2>
        <p class="text-gray-500 mb-6">Anda belum memiliki pesanan. Ayo mulai belanja!</p>
        <a href="{{ route('store.shop') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full font-semibold hover:opacity-90 transition">
            <i class="fas fa-shopping-bag mr-2"></i>
            Belanja Sekarang
        </a>
    </div>

    <!-- Order List (Demo - hidden) -->
    <div class="hidden space-y-4">
        @php
            $orders = [
                ['id' => 'ORD-001', 'date' => '10 Mar 2026', 'status' => 'Dikirim', 'total' => 850000],
                ['id' => 'ORD-002', 'date' => '05 Mar 2026', 'status' => 'Selesai', 'total' => 350000],
            ];
        @endphp

        @foreach($orders as $order)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <span class="font-semibold text-gray-800">{{ $order['id'] }}</span>
                        <span class="text-sm text-gray-500">{{ $order['date'] }}</span>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm font-medium">
                        {{ $order['status'] }}
                    </span>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-200 to-indigo-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-tshirt text-purple-400 text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800">2 Produk</h4>
                            <p class="text-sm text-gray-500">Total: Rp {{ number_format($order['total'], 0, ',', '.') }}</p>
                        </div>
                        <a href="#" class="px-4 py-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition font-medium">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
