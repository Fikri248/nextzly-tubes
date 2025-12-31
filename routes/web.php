<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;

// ========================================
// PUBLIC ROUTES
// ========================================

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('homepage');

// Product Detail
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Product Order (Customer Form Submit)
Route::post('/product/{id}/order', [ProductController::class, 'storeOrder'])->name('product.order');

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

    // Products CRUD
    Route::resource('products', ProductController::class)->except(['show']);

    // Customers Management
    Route::resource('customers', CustomerController::class)->except(['show']);
    Route::get('/customers/{customer}/transactions', [CustomerController::class, 'transactions'])
        ->name('customers.transactions');

    // Reports & Export
    Route::prefix('reports')->name('reports.')->group(function () {
        // Index - Tampilan Laporan
        Route::get('/', [ReportController::class, 'index'])
            ->name('index');

        // Export PDF
        Route::get('/export-pendapatan-pdf', [ReportController::class, 'exportPendapatanPDF'])
            ->name('export-pendapatan-pdf');

        Route::get('/export-transaksi-pdf', [ReportController::class, 'exportTransaksiPDF'])
            ->name('export-transaksi-pdf');

        Route::get('/export-kategori-pdf', [ReportController::class, 'exportKategoriPDF'])
            ->name('export-kategori-pdf');

        // Export Excel
        Route::get('/export-pendapatan-excel', [ReportController::class, 'exportPendapatanExcel'])
            ->name('export-pendapatan-excel');

        Route::get('/export-transaksi-excel', [ReportController::class, 'exportTransaksiExcel'])
            ->name('export-transaksi-excel');

        Route::get('/export-kategori-excel', [ReportController::class, 'exportKategoriExcel'])
            ->name('export-kategori-excel');
    });

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('logout');
});
