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

        // ===== DATA UNTUK CHART (Task 2.3) =====
        // Ambil data penjualan per produk (hanya transaksi success)
        $salesPerProduct = Transaction::select(
                'product_id',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(total_harga) as total_revenue')
            )
            ->where('status', 'success')
            ->groupBy('product_id')
            ->with('product:id,nama_produk')
            ->orderByDesc('total_sold')
            ->limit(10) // Top 10 produk terlaris
            ->get();

        // Format data untuk Chart.js
        $chartLabels = $salesPerProduct->map(function ($item) {
            return $item->product->nama_produk ?? 'Unknown';
        })->toArray();

        $chartData = $salesPerProduct->map(function ($item) {
            return (int) $item->total_sold;
        })->toArray();

        $chartRevenue = $salesPerProduct->map(function ($item) {
            return (float) $item->total_revenue;
        })->toArray();

        return view('admin.dashboard', compact(
            'totalAkunTersedia',
            'totalAkunTerjual',
            'totalAplikasi',
            'totalPendapatan',
            'pajak',
            'pendapatanDenganPajak',
            'chartLabels',
            'chartData',
            'chartRevenue'
        ));
    }
}
