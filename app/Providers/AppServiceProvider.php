<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share cart count with navbar
        View::composer('components.ecommerce.navbar', function ($view) {
            $cartCount = 0;
            
            if (auth('customer')->check()) {
                $cartCount = Cart::where('customer_id', auth('customer')->id())->sum('quantity');
            } else {
                $cartCount = Cart::where('session_id', session()->getId())->sum('quantity');
            }
            
            $view->with('cartCount', $cartCount);
        });
    }
}
