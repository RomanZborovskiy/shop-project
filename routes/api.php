<?php

use App\Http\Auth\Api\Controllers\AuthController;
use App\Http\Auth\Api\Controllers\PasswordResetController;
use App\Http\Client\Api\Controllers\CartController;
use App\Http\Client\Api\Controllers\CategoryController;
use App\Http\Client\Api\Controllers\FavoriteController;
use App\Http\Client\Api\Controllers\PageController;
use App\Http\Client\Api\Controllers\ProductController;
use App\Http\Client\Api\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->name('api')->prefix('auth')->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/password/email ', [PasswordResetController::class, 'sendResetLink']);
    Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);
});


Route::middleware(['api', 'auth:sanctum'])->name('api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/page/{template}',[PageController::class,'show'])->name('page.show');

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index']);
        Route::get('{slug}', [ProductController::class, 'show']);
        Route::get('/search', [ProductController::class, 'search']);
        Route::get('/{product}/reviews', [ReviewController::class, 'index']);
        Route::post('/{product}/review', [ReviewController::class, 'store']);
        Route::post('/{product}/favorites', [FavoriteController::class, 'toggle']);
    });

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('{product}/add', [CartController::class, 'add']);
        Route::post('{purchase}/remove', [CartController::class, 'remove']);
        Route::post('checkout', [CartController::class, 'checkout']);
    });

    Route::prefix('my')->group(function (){
        Route::get('/profile', [ProductController::class, 'index']);
        Route::post('/profile', [ProductController::class, 'update']);
        Route::get('/favorites', [FavoriteController::class, 'index']);
    });
});