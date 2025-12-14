<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Akun Tersedia (sum stok dari semua produk aktif)
        $totalAkunTersedia = Product::where('status', 'tersedia')->sum('stok');

        // Total Akun Terjual (sum quantity dari transaksi success) - ALL TIME
        $totalAkunTerjual = Transaction::where('status', 'success')->sum('quantity');

        // Total Semua Aplikasi (jumlah produk)
        $totalAplikasi = Product::count();

        // ========================================
        // PENDAPATAN KESELURUHAN (ALL TIME)
        // ========================================
        $totalPendapatan = Transaction::where('status', 'success')->sum('total_harga');
        $pajak = $totalPendapatan * 0.11;
        $pendapatanDenganPajak = $totalPendapatan + $pajak;

        // ========================================
        // PENDAPATAN BULAN INI (untuk Card 4)
        // ========================================
        $bulanIni = Carbon::now();
        $namaBulan = $bulanIni->translatedFormat('F Y');

        $pendapatanBulanIni = Transaction::where('status', 'success')
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->sum('total_harga');

        $pajakBulanIni = $pendapatanBulanIni * 0.11;
        $totalPendapatanBulanIni = $pendapatanBulanIni + $pajakBulanIni;

        // ========================================
        // DATA CHART - Penjualan & Pendapatan per Aplikasi (BULAN INI)
        // ========================================
        $chartRawData = Transaction::select(
                'product_id',
                DB::raw('SUM(quantity) as total_terjual'),
                DB::raw('SUM(total_harga) as total_pendapatan')
            )
            ->where('status', 'success')
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->groupBy('product_id')
            ->with('product:id,nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        // Siapkan data untuk chart
        $chartLabels = $chartRawData->pluck('product.nama_produk')->toArray();
        $chartData = $chartRawData->pluck('total_terjual')->toArray();
        $chartRevenue = $chartRawData->pluck('total_pendapatan')->toArray();

        return view('admin.dashboard', compact(
            'totalAkunTersedia',
            'totalAkunTerjual',
            'totalAplikasi',
            // All time
            'totalPendapatan',
            'pajak',
            'pendapatanDenganPajak',
            // Bulan ini
            'namaBulan',
            'totalPendapatanBulanIni',
            // Chart
            'chartLabels',
            'chartData',
            'chartRevenue'
        ));
    }
}
