<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;

// ========================================
// PUBLIC ROUTES
// ========================================

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('homepage');

// Product Detail
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// ========================================
// ADMIN AUTHENTICATION (PUBLIC)
// ========================================

// Login Form
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login');

// Login Process
Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.attempt');

// ========================================
// ADMIN PANEL (PROTECTED)
// ========================================

Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Categories CRUD
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Reports & Export PDF
    Route::prefix('reports')->name('reports.')->group(function () {
        // Index - Tampilan Laporan
        Route::get('/', [ReportController::class, 'index'])
            ->name('index');

        // Export PDF - Laporan Pendapatan
        Route::get('/export-pendapatan', [ReportController::class, 'exportPendapatanPDF'])
            ->name('export-pendapatan');

        // Export PDF - Laporan Transaksi (dengan filter tanggal)
        Route::get('/export-transaksi', [ReportController::class, 'exportTransaksiPDF'])
            ->name('export-transaksi');

        // Export PDF - Laporan Per Kategori
        Route::get('/export-kategori', [ReportController::class, 'exportKategoriPDF'])
            ->name('export-kategori');
    });

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('logout');
});


