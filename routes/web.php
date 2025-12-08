<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.attempt');
Route::get('/admin/dashboard', function () {
    return 'Halo, ini halaman Dashboard admin (dummy).';
})->name('admin.dashboard');

