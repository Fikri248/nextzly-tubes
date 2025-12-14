<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;

Route::get('/', [HomeController::class, 'index'])->name('homepage');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Route login admin (public)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.attempt');

// Route yang butuh login admin (protected)
Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Categories CRUD
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('logout');
});
