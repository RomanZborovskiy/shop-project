<?php

use App\Http\Client\Controllers\CartController;
use App\Http\Client\Controllers\CategoryController;
use App\Http\Client\Controllers\CheckoutController;
use App\Http\Client\Controllers\CurrencyController;
use App\Http\Client\Controllers\FavoriteController;
use App\Http\Client\Controllers\PageController;
use App\Http\Client\Controllers\PaymentController;
use App\Http\Client\Controllers\PostController;
use App\Http\Client\Controllers\ProductController;
use App\Http\Auth\ForgotPasswordController;
use App\Http\Auth\LoginController;
use App\Http\Auth\RegisterController;
use App\Http\Auth\ResetPasswordController;
use App\Http\Client\Controllers\ProfileController;
use App\Http\Client\Controllers\ReviewController;
use App\Http\Client\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('client.pages.home');
})->name('user.dashboard');


Route::name('client.')->group(function () {
    Route::get('/', function () {
        return view('client.pages.home');
    })->name('dashboard');

    Route::get('/posts', [PostController::class,'index'])->name('posts.index');
    Route::get('/posts/{post:slug}', [PostController::class,'show'])->name('posts.show');

    Route::get('/catalog', [CategoryController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{category:slug}', [CategoryController::class, 'show'])->name('catalog.show');

    Route::get('/shop',[ProductController::class,'index'])->name('shop.index');
    Route::get('/shop/{product:slug}',[ProductController::class,'show'])->name('shop.show');
    Route::get('/search',[ProductController::class,'searchByName'])->name('shop.search');

    Route::post('/shop/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('/currency/change', [CurrencyController::class, 'change'])->name('currency.change');

    Route::get('/page/{template}', [PageController::class, 'show'])->name('page.show');
});

Route::name('client.')->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/confirm-password', [ProfileController::class, 'showPasswordForm'])->name('profile.confirm.password.form');
    Route::post('/profile/confirm-password', [ProfileController::class, 'confirmPassword'])->name('profile.confirm.password');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/orders',[UserOrderController::class,'index'])->name('profile.orders.index');
    Route::get('/profile/orders/{order}',[UserOrderController::class,'show'])->name('profile.orders.show');
    Route::get('profile/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{purchase}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{purchase}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index'); 
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/settlements', [CheckoutController::class, 'suggest'])->name('checkout.settlements');

Route::get('/payment/redirect/{order}', [PaymentController::class, 'redirectToGateway'])->name('payment.gateway');
Route::post('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
Route::match(['get', 'post'], '/payment/response', [PaymentController::class, 'handleResponse'])->name('payment.response');




Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


require __DIR__ . '/admin.php';