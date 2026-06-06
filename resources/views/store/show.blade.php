@extends('layouts.ecommerce')

@section('title', $product->nama_produk . ' - POS Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('store.home') }}" class="hover:text-purple-600">Home</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li><a href="{{ route('store.shop') }}" class="hover:text-purple-600">Shop</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-gray-800 font-medium">{{ $product->nama_produk }}</li>
        </ol>
    </nav>

    <!-- Product Detail -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
        <!-- Product Image -->
        <div class="space-y-4">
            <div class="relative bg-white rounded-2xl shadow-md overflow-hidden">
                @if($product->image)
                    <img src="/product_images/{{ $product->image }}" alt="{{ $product->nama_produk }}" class="w-full h-96 md:h-[500px] object-cover">
                @else
                    <div class="w-full h-96 md:h-[500px] bg-gradient-to-br from-purple-200 to-indigo-200 flex items-center justify-center">
                        <i class="fas fa-tshirt text-purple-400 text-8xl"></i>
                    </div>
                @endif
                
                @if($product->stok <= 5 && $product->stok > 0)
                    <span class="absolute top-4 left-4 bg-red-500 text-white text-sm px-3 py-1 rounded-full font-medium">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Stok Terbatas
                    </span>
                @elseif($product->stok <= 0)
                    <span class="absolute top-4 left-4 bg-gray-500 text-white text-sm px-3 py-1 rounded-full font-medium">
                        <i class="fas fa-times-circle mr-1"></i> Stok Habis
                    </span>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="space-y-6">
            <!-- Category Badge -->
            @if($product->kategori)
                <span class="inline-block px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-medium">
                    <i class="fas fa-tag mr-1"></i> {{ $product->kategori->nama_kategori }}
                </span>
            @endif

            <!-- Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $product->nama_produk }}</h1>

            <!-- Rating -->
            <div class="flex items-center gap-2">
                <div class="flex text-amber-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span class="text-gray-600">(4.5 / 5) - 128 ulasan</span>
            </div>

            <!-- Price -->
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-4">
                <span class="text-3xl font-bold text-purple-600">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                @if($product->stok > 0)
                    <span class="ml-3 text-green-600 text-sm font-medium">
                        <i class="fas fa-check-circle mr-1"></i> Tersedia
                    </span>
                @endif
            </div>

            <!-- SKU -->
            <div class="text-gray-600">
                <span class="font-medium">SKU:</span> {{ $product->sku ?? '-' }}
            </div>

            <!-- Description -->
            <div>
                <h3 class="font-semibold text-gray-800 mb-2">Deskripsi Produk</h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $product->deskripsi ?? 'Produk fashion berkualitas tinggi dengan bahan premium. Cocok untuk berbagai kesempatan, baik casual maupun formal. Tersedia dalam berbagai ukuran dan warna.' }}
                </p>
            </div>

            <!-- Stock Info -->
            <div class="flex items-center gap-4">
                <span class="text-gray-600">
                    <i class="fas fa-box mr-2"></i> Stok: <strong>{{ $product->stok }}</strong>
                </span>
            </div>

            <!-- Quantity Selector -->
            <div class="flex items-center gap-4">
                <label class="font-medium text-gray-800">Jumlah:</label>
                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 transition" onclick="decreaseQty()">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" id="quantity" value="1" min="1" max="{{ $product->stok }}" class="w-16 text-center border-0 focus:ring-0">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 transition" onclick="increaseQty()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                @if($product->stok > 0)
                    <button onclick="addToCart({{ $product->id }})" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full font-semibold hover:opacity-90 transition shadow-lg">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Tambah ke Keranjang
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center px-6 py-3 border-2 border-purple-600 text-purple-600 rounded-full font-semibold hover:bg-purple-600 hover:text-white transition">
                        <i class="fas fa-bolt mr-2"></i>
                        Beli Sekarang
                    </button>
                @else
                    <button disabled class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-300 text-gray-500 rounded-full font-semibold cursor-not-allowed">
                        <i class="fas fa-times-circle mr-2"></i>
                        Stok Habis
                    </button>
                @endif
                <button class="p-3 border border-gray-200 rounded-full text-gray-500 hover:text-red-500 hover:border-red-500 transition">
                    <i class="fas fa-heart"></i>
                </button>
            </div>

            <!-- Features -->
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-truck text-purple-600"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-800 text-sm">Gratis Ongkir</div>
                        <div class="text-xs text-gray-500">Min. belanja Rp 200rb</div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-green-600"></i>
                    </div>
                    <div>
                        <div class="font-medium text-gray-800 text-sm">Garansi</div>
                        <div class="text-xs text-gray-500">7 hari pengembalian</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <section class="mt-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Produk Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <a href="{{ route('store.show', $related->id) }}" class="bg-white rounded-2xl shadow-md overflow-hidden group hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="relative overflow-hidden">
                            @if($related->image)
                                <img src="/product_images/{{ $related->image }}" alt="{{ $related->nama_produk }}" class="w-full h-40 object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-40 bg-gradient-to-br from-purple-200 to-indigo-200 flex items-center justify-center">
                                    <i class="fas fa-tshirt text-purple-400 text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="font-medium text-gray-800 text-sm truncate">{{ $related->nama_produk }}</h3>
                            <span class="text-sm font-bold text-purple-600">Rp {{ number_format($related->harga_jual, 0, ',', '.') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</div>

<script>
function increaseQty() {
    let qty = document.getElementById('quantity');
    let max = parseInt(qty.getAttribute('max'));
    if (parseInt(qty.value) < max) {
        qty.value = parseInt(qty.value) + 1;
    }
}

function decreaseQty() {
    let qty = document.getElementById('quantity');
    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}

function addToCart(productId) {
    let qty = document.getElementById('quantity').value;
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: parseInt(qty) })
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
