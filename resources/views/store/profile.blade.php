@extends('layouts.ecommerce')

@section('title', 'Profil Saya - POS Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        <i class="fas fa-user-circle text-purple-600 mr-2"></i>
        Profil Saya
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-md p-6 text-center">
                <div class="w-24 h-24 mx-auto bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full flex items-center justify-center text-white text-3xl font-bold mb-4">
                    {{ strtoupper(substr(auth('customer')->user()->name ?? 'U', 0, 1)) }}
                </div>
                <h3 class="font-semibold text-gray-800 text-lg">{{ auth('customer')->user()->name ?? 'Customer' }}</h3>
                <p class="text-gray-500 text-sm">{{ auth('customer')->user()->email ?? 'customer@email.com' }}</p>
                
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-purple-600">0</div>
                            <div class="text-xs text-gray-500">Pesanan</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-purple-600">0</div>
                            <div class="text-xs text-gray-500">Wishlist</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-purple-600">0</div>
                            <div class="text-xs text-gray-500">Ulasan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-2xl shadow-md mt-6 overflow-hidden">
                <a href="{{ route('store.orders') }}" class="flex items-center px-6 py-4 hover:bg-gray-50 transition">
                    <i class="fas fa-shopping-bag text-purple-600 w-6"></i>
                    <span class="ml-3 text-gray-800">Pesanan Saya</span>
                    <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
                </a>
                <a href="{{ route('store.wishlist') }}" class="flex items-center px-6 py-4 hover:bg-gray-50 transition border-t border-gray-100">
                    <i class="fas fa-heart text-red-500 w-6"></i>
                    <span class="ml-3 text-gray-800">Wishlist</span>
                    <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
                </a>
                <a href="#" class="flex items-center px-6 py-4 hover:bg-gray-50 transition border-t border-gray-100">
                    <i class="fas fa-map-marker-alt text-blue-500 w-6"></i>
                    <span class="ml-3 text-gray-800">Alamat</span>
                    <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
                </a>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="font-semibold text-gray-800 mb-6 text-lg">Edit Profil</h3>
                
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" value="{{ auth('customer')->user()->name ?? '' }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" value="{{ auth('customer')->user()->email ?? '' }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                            <input type="tel" placeholder="Masukkan nomor telepon" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                            <input type="date" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                        <textarea rows="3" placeholder="Masukkan alamat lengkap" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200"></textarea>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg font-medium hover:opacity-90 transition">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                        <button type="button" class="px-6 py-2 border border-gray-200 text-gray-600 rounded-lg font-medium hover:bg-gray-50 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-2xl shadow-md p-6 mt-6">
                <h3 class="font-semibold text-gray-800 mb-6 text-lg">Ganti Password</h3>
                
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                    </div>

                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg font-medium hover:opacity-90 transition">
                        <i class="fas fa-key mr-2"></i> Ganti Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
