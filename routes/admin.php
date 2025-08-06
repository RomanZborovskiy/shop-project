<?php

use App\Http\admin\Controllers\ProductController;



Route::view('admin', 'admin.examples.blank');

Route::resource('products',ProductController::class)->except('show');
