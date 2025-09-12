<?php

namespace App\Providers;

use App\Services\CartService;
use App\Services\CurrencyService;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
    }
}
