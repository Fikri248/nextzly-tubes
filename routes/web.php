<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Detail Produk
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
