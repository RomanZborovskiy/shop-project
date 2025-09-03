<?php

use App\Http\admin\Controllers\AttributeController;
use App\Http\admin\Controllers\CategoryController;
use App\Http\admin\Controllers\DashboardController;
use App\Http\admin\Controllers\LeadController;
use App\Http\admin\Controllers\MailingController;
use App\Http\admin\Controllers\OrderController;
use App\Http\admin\Controllers\PostController;
use App\Http\admin\Controllers\ProductController;
use App\Http\admin\Controllers\ProfileController;
use App\Http\admin\Controllers\RoleController;
use App\Http\admin\Controllers\UserController;
use App\Http\admin\Controllers\VariableController;
use App\Http\Auth\ForgotPasswordController;
use App\Http\Auth\LoginController;
use App\Http\Auth\RegisterController;
use App\Http\Auth\ResetPasswordController;
use PHPUnit\TextUI\Configuration\VariableCollection;


Route::prefix('admin')->middleware(['auth','admin.panel'])->group(function () {
    Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard.index');

    Route::resource('products',ProductController::class)->except('show');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::post('products/{product}/add-attribute', [ProductController::class, 'storeAttribute'])->name('products.storeAttribute');

    Route::resource('posts',PostController::class)->except('show');
    Route::resource('categories',CategoryController::class)->except('show');
    Route::post('/categories/order', [CategoryController::class, 'order'])->name('categories.order');

    Route::resource('attributes',AttributeController::class)->except('show');
    Route::resource('orders', OrderController::class)->except('show');

    Route::prefix('leads')->group(function () {
        Route::get('/', [LeadController::class,'index'])->name('leads.index');
        Route::resource('mailings', MailingController::class)->except('show');
    });

    Route::get('roles',[RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{user}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::patch('/roles/{user}/update', [RoleController::class, 'update'])->name('roles.update');


    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/confirm-password', [ProfileController::class, 'showPasswordForm'])->name('profile.confirm.password.form');
    Route::post('/profile/confirm-password', [ProfileController::class, 'confirmPassword'])->name('profile.confirm.password');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('variables', VariableController::class)->except('show');

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

});


// Route::get('/categories/categories-tree', [ProductController::class, 'categoriesTree'])
//     ->name('lte3.categories.tree');

//     Route::prefix('categories')->group(function () {
//     Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
//     Route::post('/save', [CategoryController::class, 'save'])->name('admin.categories.save');
// });
Route::name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::post('categories/order', [CategoryController::class, 'order'])->name('categories.order');
});


Route::prefix('admin')->name('admin')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});