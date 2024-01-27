<?php

namespace App\Providers;

use App\Interfaces\OutletInterface;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartProductAddOns;
use App\Observers\CartItemObserver;
use App\Observers\CartObserver;
use App\Observers\CartProductAddOnObserver;
use App\Service\OutletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OutletInterface::class,OutletService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Cart::observe(CartObserver::class);
        CartItem::observe(CartItemObserver::class);
//        CartProductAddOns::observe(CartProductAddOnObserver::class);
    }
}
