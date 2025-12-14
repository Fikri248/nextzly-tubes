<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Akun Tersedia (sum stok dari produk yang tersedia)
        $totalAkunTersedia = Product::where('status', 'tersedia')->sum('stok');

        // Total Akun Terjual (sum quantity dari transaksi success)
        $totalAkunTerjual = Transaction::where('status', 'success')->sum('quantity');

        // Total Semua Aplikasi (count semua produk)
        $totalAplikasi = Product::count();

        // Total Pendapatan (sum total_harga dari transaksi success)
        $totalPendapatan = Transaction::where('status', 'success')->sum('total_harga');

        // Hitung Pajak 11%
        $pajak = $totalPendapatan * 0.11;

        // Total Pendapatan + Pajak
        $pendapatanDenganPajak = $totalPendapatan + $pajak;

        return view('admin.dashboard', compact(
            'totalAkunTersedia',
            'totalAkunTerjual',
            'totalAplikasi',
            'totalPendapatan',
            'pajak',
            'pendapatanDenganPajak'
        ));
    }
}
