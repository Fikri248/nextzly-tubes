<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
// route login (TIDAK pakai middleware)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.attempt');

// route yang butuh login admin
Route::middleware('admin.auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Halo, ini halaman Dashboard admin (dummy).';
    })->name('admin.dashboard');

Route::middleware('admin.auth')->post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

});

