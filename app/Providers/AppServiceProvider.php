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
use Illuminate\Foundation\AliasLoader;
use Illuminate\Database\Eloquent\Relations\Relation;

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

        AliasLoader::getInstance()->alias('Cart', Cart::class);

        Relation::morphMap([
        'attribute' => \App\Models\Attribute::class,
        'brand' => \App\Models\Brand::class,
        'category_attribute'=> \App\Models\CategoryAttribute::class,
        'district' => \App\Models\District::class,
        'favorite' => \App\Models\Favorite::class,
        'lead' => \App\Models\Lead::class,
        'location' => \App\Models\Location::class,
        'mailing' => \App\Models\Mailing::class,
        'order' => \App\Models\Order::class,
        'payment' => \App\Models\Payment::class,
        'post' => \App\Models\Post::class,
        'product' => \App\Models\Product::class,
        'property' => \App\Models\Property::class,
        'property_table' => \App\Models\Propertyable::class,
        'purchase' => \App\Models\Purchase::class,
        'region' => \App\Models\Region::class,
        'review' => \App\Models\Review::class,
        'term' => \App\Models\Term::class,
        'user' => \App\Models\User::class,
        'page' => \App\Models\Page::class,
    ]);
    }
}
