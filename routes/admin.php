<?php

use App\Http\admin\Controllers\AttributeController;
use App\Http\admin\Controllers\CategoryController;
use App\Http\admin\Controllers\PostController;
use App\Http\admin\Controllers\ProductController;
use App\Http\admin\Controllers\UserController;



Route::view('admin', 'admin.examples.blank');

Route::resource('products',ProductController::class)->except('show');
Route::post('products/{product}/add-attribute', [ProductController::class, 'storeAttribute'])->name('products.storeAttribute');
Route::resource('posts',PostController::class)->except('show');
Route::resource('categories',CategoryController::class)->except('show');
Route::resource('attributes',AttributeController::class)->except('show');
//Route::resource('users',UserController::class)->except('show');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');

    Route::get('/profile/confirm-password', [UserController::class, 'showPasswordForm'])->name('profile.confirm.password.form');
    Route::post('/profile/confirm-password', [UserController::class, 'confirmPassword'])->name('profile.confirm.password');

    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
});
