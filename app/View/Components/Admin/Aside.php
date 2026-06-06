<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Product;

class Aside extends Component
{

    /**
     * Get the view / contents that represent the component.
     */
    public $routes;
    public $stokMenipis;

    public function __construct()
    {
        $this->stokMenipis = Product::stokMenipis()->count();
        
        $this->routes = [
            [
                //single link
                "route_name"      => "dashboard.index",
                "route_active"    => "dashboard.*",
                "icon"            => "fas fa-tachometer-alt",
                "icon_color"      => "text-info",
                "label"           => "Dashboard",
                "is_dropdown"     => false
            ],
        ];

        // Menu Data User - Hanya untuk Admin
        if (auth()->user()->role === 'admin') {
            $this->routes[] = [
                "route_name"      => "users.index",
                "route_active"    => "users.*",
                "icon"            => "fas fa-users",
                "icon_color"      => "text-warning",
                "label"           => "Data User",
                "is_dropdown"     => false
            ];
        }

        // Master Data
        $this->routes[] = [
            "label"          => "Master Data",
            "route_active"   => "master-data.*",
            "icon"           => "fas fa-database",
            "icon_color"     => "text-primary",
            "is_dropdown"    => true,
            "dropdown"       => [
                [
                    "label"           => "Kategori",
                    "icon"            => "fas fa-layer-group",
                    "icon_color"      => "text-purple",
                    "route_active"    => "master-data.kategori.*",
                    "route_name"      => "master-data.kategori.index",
                ],
                [
                    "label"           => "Product",
                    "icon"            => "fas fa-box",
                    "icon_color"      => "text-orange",
                    "route_active"    => "master-data.product.*",
                    "route_name"      => "master-data.product.index",
                ],
                [
                    "label"           => "Supplier",
                    "icon"            => "fas fa-truck",
                    "icon_color"      => "text-teal",
                    "route_active"    => "master-data.supplier.*",
                    "route_name"      => "master-data.supplier.index",
                ]
            ]
        ];

        // Transaksi
        $this->routes[] = [
            "label"          => "Transaksi",
            "route_active"   => "transaksi.*",
            "icon"           => "fas fa-exchange-alt",
            "icon_color"     => "text-success",
            "is_dropdown"    => true,
            "dropdown"       => [
                [
                    "label"           => "Penerimaan Barang",
                    "icon"            => "fas fa-truck-loading",
                    "icon_color"      => "text-lime",
                    "route_active"    => "transaksi.goods-receipt.*",
                    "route_name"      => "transaksi.goods-receipt.index",
                ]
            ]
        ];

        // Order Management
        $this->routes[] = [
            "route_name"      => "order.index",
            "route_active"    => "order.*",
            "icon"            => "fas fa-shopping-cart",
            "icon_color"      => "text-pink",
            "label"           => "Order Online",
            "is_dropdown"     => false
        ];

        // Laporan
        $this->routes[] = [
            "label"          => "Laporan",
            "route_active"   => "laporan.*",
            "icon"           => "fas fa-chart-bar",
            "icon_color"     => "text-danger",
            "is_dropdown"    => true,
            "dropdown"       => [
                [
                    "label"           => "Riwayat Stok",
                    "icon"            => "fas fa-history",
                    "icon_color"      => "text-cyan",
                    "route_active"    => "laporan.stock-log.*",
                    "route_name"      => "laporan.stock-log.index",
                ],
                [
                    "label"           => "Activity Log",
                    "icon"            => "fas fa-clipboard-list",
                    "icon_color"      => "text-pink",
                    "route_active"    => "laporan.activity-log.*",
                    "route_name"      => "laporan.activity-log.index",
                ]
            ]
        ];
        
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.aside');
    }
}
