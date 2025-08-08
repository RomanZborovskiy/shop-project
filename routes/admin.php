<?php

use App\Http\admin\Controllers\AttributeController;
use App\Http\admin\Controllers\CategoryController;
use App\Http\admin\Controllers\PostController;
use App\Http\admin\Controllers\ProductController;
use App\Http\admin\Controllers\UserController;



Route::view('admin', 'admin.examples.blank');

Route::resource('products',ProductController::class)->except('show');
Route::resource('posts',PostController::class)->except('show');
Route::resource('categories',CategoryController::class)->except('show');
Route::resource('attributes',AttributeController::class)->except('show');
Route::resource('users',UserController::class)->except('show');
