<?php

namespace App\Providers;

use App\Facades\Cart;
use App\Services\CartService;
use App\Services\FavoriteService;
use App\Services\CurrencyService;
use App\Services\CheckoutService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CurrencyService::class, function ($app) {
            return new CurrencyService();
        });
         $this->app->singleton('cart', function ($app) {
            return new CartService();
        });
        $this->app->singleton('checkout', function ($app) {
            return new CheckoutService();
        });
        $this->app->singleton('payment', function ($app) {
            return new PaymentService();
        });
        $this->app->singleton('favorite', function () {
            return new FavoriteService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($url = env('NGROK_URL')) {
        URL::forceScheme(env('NGROK_SCHEME') ?: 'https');
        URL::forceRootUrl($url);
        }

        View::composer('*', function ($view) {
            $cart = Cart::getCart();
            $view->with('cart', $cart);
        });

        View::composer('*', function ($view) {
            $view->with('cartCount', Cart::getCount());
        });
    }
}
