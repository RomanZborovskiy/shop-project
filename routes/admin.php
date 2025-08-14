<?php

use App\Http\admin\Controllers\AttributeController;
use App\Http\admin\Controllers\CategoryController;
use App\Http\admin\Controllers\OrderController;
use App\Http\admin\Controllers\PostController;
use App\Http\admin\Controllers\ProductController;
use App\Http\admin\Controllers\ProfileController;
use App\Http\admin\Controllers\RoleController;
use App\Http\admin\Controllers\UserController;



Route::view('admin', 'admin.examples.blank');

Route::middleware('auth')->prefix('admin')->group(function () {

    Route::resource('products',ProductController::class)->except('show');
    Route::post('products/{product}/add-attribute', [ProductController::class, 'storeAttribute'])->name('products.storeAttribute');
    Route::resource('posts',PostController::class)->except('show');
    Route::resource('categories',CategoryController::class)->except('show');
    Route::post('/categories/move', [CategoryController::class, 'move'])->name('categories.move');
    Route::resource('attributes',AttributeController::class)->except('show');
    Route::resource('orders', OrderController::class)->except('show');

    Route::get('roles',[RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{user}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::patch('/roles/{user}/update', [RoleController::class, 'update'])->name('roles.update');


    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/confirm-password', [ProfileController::class, 'showPasswordForm'])->name('profile.confirm.password.form');
    Route::post('/profile/confirm-password', [ProfileController::class, 'confirmPassword'])->name('profile.confirm.password');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


