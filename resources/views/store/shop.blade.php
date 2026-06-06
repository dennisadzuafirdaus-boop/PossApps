@extends('layouts.ecommerce')

@section('title', ($title ?? 'Shop') . ' - POS Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $title ?? 'Semua Produk' }}</h1>
        @isset($subtitle)
            <p class="text-gray-600 mt-2">{{ $subtitle }}</p>
        @endisset
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-md p-4 mb-8">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari produk..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Kategori Filter -->
            <div class="md:w-48">
                <select name="kategori" class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition appearance-none bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris ?? [] as $kat)
                        <option value="{{ $kat->nama_kategori }}" {{ request('kategori') == $kat->nama_kategori ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort -->
            <div class="md:w-40">
                <select name="sort" class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition appearance-none bg-white">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="terlaris" {{ request('sort') == 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Termahal</option>
                </select>
            </div>

            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition font-medium">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <a href="{{ route('store.show', $product->id) }}" class="bg-white rounded-2xl shadow-md overflow-hidden group hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="relative overflow-hidden">
                        @if($product->image)
                            <img src="/product_images/{{ $product->image }}" alt="{{ $product->nama_produk }}" class="w-full h-48 md:h-56 object-cover group-hover:scale-110 transition duration-300">
                        @else
                            <div class="w-full h-48 md:h-56 bg-gradient-to-br from-purple-200 to-indigo-200 flex items-center justify-center">
                                <i class="fas fa-tshirt text-purple-400 text-5xl"></i>
                            </div>
                        @endif
                        
                        @if($product->stok <= 5 && $product->stok > 0)
                            <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium">Stok Terbatas</span>
                        @elseif($product->stok <= 0)
                            <span class="absolute top-2 left-2 bg-gray-500 text-white text-xs px-2 py-1 rounded-full font-medium">Habis</span>
                        @endif

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                            <button class="p-3 bg-white rounded-full text-purple-600 hover:bg-purple-600 hover:text-white transition" onclick="event.preventDefault(); addToCart({{ $product->id }})">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                            <button class="p-3 bg-white rounded-full text-red-500 hover:bg-red-500 hover:text-white transition" onclick="event.preventDefault();">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
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
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-box-open text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Produk tidak ditemukan</h3>
            <p class="text-gray-500 mb-6">Coba ubah filter pencarian Anda</p>
            <a href="{{ route('store.shop') }}" class="inline-flex items-center px-6 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition">
                <i class="fas fa-redo mr-2"></i>Reset Filter
            </a>
        </div>
    @endif
</div>

<script>
function addToCart(productId) {
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
