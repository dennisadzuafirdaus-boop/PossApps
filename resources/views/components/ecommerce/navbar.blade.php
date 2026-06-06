<!-- Modern E-Commerce Navbar -->
<nav id="mainNavbar" class="navbar-sticky bg-white transition-shadow duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('store.home') }}" class="flex items-center">
                    <img src="{{ asset('logopossapps.png') }}" alt="POS Fashion" class="h-10 w-auto">
                    <span class="ml-2 text-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                        POS Fashion
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('store.home') }}" class="nav-link-custom text-gray-700 hover:text-purple-600 font-medium transition">
                    <i class="fas fa-home mr-1 text-purple-500"></i> Home
                </a>
                <a href="{{ route('store.shop') }}" class="nav-link-custom text-gray-700 hover:text-purple-600 font-medium transition">
                    <i class="fas fa-store mr-1 text-indigo-500"></i> Shop
                </a>
                <a href="{{ route('store.pria') }}" class="nav-link-custom text-gray-700 hover:text-purple-600 font-medium transition">
                    <i class="fas fa-male mr-1 text-blue-500"></i> Pria
                </a>
                <a href="{{ route('store.wanita') }}" class="nav-link-custom text-gray-700 hover:text-purple-600 font-medium transition">
                    <i class="fas fa-female mr-1 text-pink-500"></i> Wanita
                </a>
                <a href="{{ route('store.promo') }}" class="nav-link-custom text-gray-700 hover:text-purple-600 font-medium transition relative">
                    <i class="fas fa-tags mr-1 text-red-500"></i> Promo
                    <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full animate-pulse">HOT</span>
                </a>
            </div>

            <!-- Search Bar Desktop -->
            <div class="hidden md:flex items-center">
                <div class="relative">
                    <input type="text" 
                           placeholder="Cari produk..." 
                           class="search-input w-56 pl-10 pr-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-300">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Right Icons -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Cart -->
                <a href="{{ route('store.cart') }}" class="relative p-2 rounded-full hover:bg-blue-50 transition btn-hover">
                    <i class="fas fa-shopping-cart text-blue-500 text-xl"></i>
                    <span id="cart-badge" class="cart-badge absolute -top-1 -right-1 bg-blue-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full" style="display: {{ ($cartCount ?? 0) > 0 ? 'flex' : 'none' }}">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>

                <!-- Customer User -->
                @auth('customer')
                    <div class="relative group">
                        <button class="p-2 rounded-full hover:bg-green-50 transition btn-hover">
                            <i class="fas fa-user text-green-500 text-xl"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right scale-95 group-hover:scale-100">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="font-semibold text-gray-800">{{ auth('customer')->user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ auth('customer')->user()->email }}</p>
                            </div>
                            <a href="{{ route('store.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                <i class="fas fa-user-circle mr-2 text-purple-500"></i> Profile
                            </a>
                            <a href="{{ route('store.orders') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                <i class="fas fa-shopping-bag mr-2 text-indigo-500"></i> Pesanan Saya
                            </a>
                            <a href="{{ route('store.wishlist') }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                                <i class="fas fa-heart mr-2 text-red-500"></i> Wishlist
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form action="{{ route('customer.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('customer.login') }}" class="p-2 rounded-full hover:bg-green-50 transition btn-hover">
                        <i class="fas fa-user text-green-500 text-xl"></i>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex md:hidden items-center space-x-2">
                <button id="searchToggle" class="p-2 rounded-full hover:bg-gray-100 transition">
                    <i class="fas fa-search text-gray-500 text-xl"></i>
                </button>
                <a href="{{ route('store.cart') }}" class="relative p-2 rounded-full hover:bg-blue-50 transition">
                    <i class="fas fa-shopping-cart text-blue-500 text-xl"></i>
                    <span id="cart-badge-mobile" class="cart-badge absolute -top-1 -right-1 bg-blue-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full" style="display: {{ ($cartCount ?? 0) > 0 ? 'flex' : 'none' }}">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>
                <button id="mobileMenuBtn" class="p-2 rounded-full hover:bg-gray-100 transition">
                    <i class="fas fa-bars text-gray-700 text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Search Box -->
        <div id="searchBox" class="hidden pb-4">
            <div class="relative">
                <input type="text" 
                       placeholder="Cari produk..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

<!-- Mobile Menu Sidebar -->
<div id="mobileMenu" class="mobile-menu fixed top-0 left-0 h-full w-72 bg-white z-50 shadow-xl">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <div class="flex items-center">
                <img src="{{ asset('logopossapps.png') }}" alt="POS Fashion" class="h-8 w-auto">
                <span class="ml-2 text-lg font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    POS Fashion
                </span>
            </div>
            <button id="mobileMenuClose" class="p-2 rounded-full hover:bg-gray-100 transition">
                <i class="fas fa-times text-gray-500 text-xl"></i>
            </button>
        </div>

        <!-- Customer Info (if logged in) -->
        @auth('customer')
            <div class="p-4 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-indigo-50">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr(auth('customer')->user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-gray-800">{{ auth('customer')->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth('customer')->user()->email }}</p>
                    </div>
                </div>
            </div>
        @endauth

        <!-- Menu Items -->
        <div class="flex-1 overflow-y-auto py-4">
            <a href="{{ route('store.home') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                <i class="fas fa-home w-6 text-purple-500"></i>
                <span class="ml-3 font-medium">Home</span>
            </a>
            <a href="{{ route('store.shop') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                <i class="fas fa-store w-6 text-indigo-500"></i>
                <span class="ml-3 font-medium">Shop</span>
            </a>
            <a href="{{ route('store.pria') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                <i class="fas fa-male w-6 text-blue-500"></i>
                <span class="ml-3 font-medium">Pria</span>
            </a>
            <a href="{{ route('store.wanita') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                <i class="fas fa-female w-6 text-pink-500"></i>
                <span class="ml-3 font-medium">Wanita</span>
            </a>
            <a href="{{ route('store.promo') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                <i class="fas fa-tags w-6 text-red-500"></i>
                <span class="ml-3 font-medium">Promo</span>
                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">HOT</span>
            </a>

            @auth('customer')
                <div class="border-t border-gray-100 my-2"></div>
                <a href="{{ route('store.profile') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                    <i class="fas fa-user-circle w-6 text-purple-500"></i>
                    <span class="ml-3 font-medium">Profile</span>
                </a>
                <a href="{{ route('store.orders') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                    <i class="fas fa-shopping-bag w-6 text-indigo-500"></i>
                    <span class="ml-3 font-medium">Pesanan Saya</span>
                </a>
                <a href="{{ route('store.wishlist') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition">
                    <i class="fas fa-heart w-6 text-red-500"></i>
                    <span class="ml-3 font-medium">Wishlist</span>
                </a>
            @endauth
        </div>

        <!-- Footer -->
        <div class="p-4 border-t border-gray-100">
            @auth('customer')
                <form action="{{ route('customer.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('customer.login') }}" class="w-full flex items-center justify-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:opacity-90 transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login
                </a>
            @endauth
        </div>
    </div>
</div>
