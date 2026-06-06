<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link">
        <img src="{{ asset('logopossapps.png') }}" alt="POS Logo" class="brand-image" style="opacity: 1; width: 35px; height: 35px; border-radius: 50%;">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=667eea&color=fff&size=35"
                     class="img-circle elevation-2" alt="User Image" style="width: 35px; height: 35px;">
            </div>
            <div class="info">
                <a href="#" class="d-block"><b>{{ auth()->user()->name }}</b>
                    <span class="badge {{ auth()->user()->role == 'admin' ? 'badge-danger' : 'badge-info' }} ml-1" style="font-size: 10px;">
                        {{ strtoupper(auth()->user()->role) }}
                    </span>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach ($routes as $route)
                    @if (!$route['is_dropdown'])
                        <li class="nav-item">
                            <a href="{{ route($route['route_name']) }}" 
                               class="nav-link {{ request()->routeIs($route['route_active']) ? 'active' : '' }}">
                                <i class="nav-icon {{ $route['icon'] }} {{ $route['icon_color'] ?? '' }}"></i>
                                <p>{{ $route['label'] }}</p>
                            </a>
                        </li>
                    @else
                        <li class="nav-item {{ request()->routeIs($route['route_active']) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs($route['route_active']) ? 'active' : '' }}">
                                <i class="nav-icon {{ $route['icon'] }} {{ $route['icon_color'] ?? '' }}"></i>
                                <p>
                                    {{ $route['label'] }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach ($route['dropdown'] as $item)
                                    <li class="nav-item">
                                        <a href="{{ route($item['route_name']) }}" 
                                           class="nav-link {{ request()->routeIs($item['route_active']) ? 'active' : '' }}">
                                            <i class="nav-icon {{ $item['icon'] }} {{ $item['icon_color'] ?? '' }}"></i>
                                            <p>{{ $item['label'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>

<style>
    /* Sidebar Custom Colors */
    .sidebar-dark-primary {
        background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%) !important;
    }

    .sidebar-dark-primary .nav-link {
        color: rgba(255,255,255,0.8) !important;
        border-radius: 10px;
        margin: 3px 10px;
        transition: all 0.3s ease;
    }

    .sidebar-dark-primary .nav-link:hover {
        background: rgba(255,255,255,0.1) !important;
        color: #fff !important;
        transform: translateX(5px);
    }

    .sidebar-dark-primary .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: #fff !important;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .sidebar-dark-primary .nav-treeview .nav-link.active {
        background: rgba(102, 126, 234, 0.3) !important;
        border-left: 3px solid #667eea;
    }

    /* Icon Colors */
    .text-purple { color: #a855f7 !important; }
    .text-orange { color: #f97316 !important; }
    .text-teal { color: #14b8a6 !important; }
    .text-lime { color: #84cc16 !important; }
    .text-cyan { color: #06b6d4 !important; }
    .text-pink { color: #ec4899 !important; }

    /* Keep existing colors */
    .text-info { color: #17a2b8 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-primary { color: #667eea !important; }
    .text-success { color: #28a745 !important; }
    .text-danger { color: #dc3545 !important; }

    /* Dropdown Arrow */
    .sidebar-dark-primary .nav-treeview {
        background: rgba(0,0,0,0.1);
        border-radius: 10px;
        margin: 5px 10px;
        padding: 5px 0;
    }

    .sidebar-dark-primary .nav-treeview .nav-link {
        padding-left: 30px !important;
    }

    /* Brand Link */
    .brand-link {
        padding: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .brand-text {
        font-weight: 600;
        color: #fff !important;
        font-size: 1.1rem;
    }

    /* User Panel */
    .user-panel {
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .user-panel .info a {
        color: #fff !important;
    }
</style>
