<?php

use App\Http\Controllers\admin\ProductController;

Route::view('admin', 'admin.examples.blank');

Route::resource('products', ProductController::class);