<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendapatanExport;
use App\Exports\TransaksiExport;
use App\Exports\KategoriExport;

class ReportController extends Controller
{
    /**
     * Show laporan dashboard
     */
    public function index()
    {
        $bulanIni = Carbon::now();
        $namaBulan = $bulanIni->locale('id')->translatedFormat('F Y');

        // Data summary
        $totalPendapatan = Transaction::where('status', 'success')
            ->sum('total_harga');
        $pajak = $totalPendapatan * 0.11;
        $totalDenganPajak = $totalPendapatan + $pajak;

        // Data bulanan
        $pendapatanBulanIni = Transaction::where('status', 'success')
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->sum('total_harga');

        // Detail transaksi (Top 15)
        $transaksi = Transaction::select(
                'transactions.id',
                'products.nama_produk',
                'transactions.quantity',
                'transactions.total_harga',
                'transactions.created_at',
                'transactions.status'
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.status', 'success')
            ->orderBy('transactions.created_at', 'desc')
            ->limit(15)
            ->get();

        return view('admin.reports.index', compact(
            'namaBulan',
            'totalPendapatan',
            'pajak',
            'totalDenganPajak',
            'pendapatanBulanIni',
            'transaksi'
        ));
    }

    /**
     * Export PDF - Laporan Pendapatan
     */
    public function exportPendapatanPDF()
    {
        $bulanIni = Carbon::now();
        $namaBulan = $bulanIni->locale('id')->translatedFormat('F Y');
        $timestamp = Carbon::now()->format('Ymd_His');

        // Data summary
        $totalPendapatan = Transaction::where('status', 'success')
            ->sum('total_harga');
        $pajak = $totalPendapatan * 0.11;
        $totalDenganPajak = $totalPendapatan + $pajak;

        // Data bulanan
        $pendapatanBulanIni = Transaction::where('status', 'success')
            ->whereMonth('created_at', $bulanIni->month)
            ->whereYear('created_at', $bulanIni->year)
            ->sum('total_harga');

        // Data transaksi detail
        $transaksi = Transaction::select(
                'transactions.id',
                'products.nama_produk',
                'transactions.quantity',
                'transactions.total_harga',
                'transactions.created_at',
                'transactions.status'
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.status', 'success')
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        // Data per produk (top 10)
        $penjualanPerProduk = Transaction::select(
                'products.nama_produk',
                DB::raw('SUM(transactions.quantity) as total_terjual'),
                DB::raw('SUM(transactions.total_harga) as total_pendapatan')
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.status', 'success')
            ->groupBy('products.id', 'products.nama_produk')
            ->orderByDesc('total_pendapatan')
            ->limit(10)
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf.pendapatan', compact(
            'namaBulan',
            'totalPendapatan',
            'pajak',
            'totalDenganPajak',
            'pendapatanBulanIni',
            'transaksi',
            'penjualanPerProduk'
        ))
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'dpi' => 150,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download('Nextzly_Laporan_Pendapatan_' . str_replace(' ', '_', $namaBulan) . '_' . $timestamp . '.pdf');
    }

    /**
     * Export PDF - Laporan Transaksi Lengkap
     */
    public function exportTransaksiPDF(Request $request)
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->toDateString());
        $timestamp = Carbon::now()->format('Ymd_His');

        $transaksi = Transaction::select(
                'transactions.id',
                'products.nama_produk',
                'transactions.quantity',
                'transactions.total_harga',
                'transactions.created_at',
                'transactions.status'
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->whereBetween('transactions.created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->where('transactions.status', 'success')
            ->orderBy('transactions.created_at', 'desc')
            ->get();

        $totalPendapatan = $transaksi->sum('total_harga');
        $pajak = $totalPendapatan * 0.11;

        $pdf = Pdf::loadView('admin.reports.pdf.transaksi', compact(
            'transaksi',
            'startDate',
            'endDate',
            'totalPendapatan',
            'pajak'
        ))
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'dpi' => 150,
            'isHtml5ParserEnabled' => true,
        ]);

        return $pdf->download('Nextzly_Laporan_Transaksi_' . $startDate . '_to_' . $endDate . '_' . $timestamp . '.pdf');
    }

    /**
     * Export PDF - Laporan Per Kategori
     */
    public function exportKategoriPDF()
    {
        $bulanIni = Carbon::now();
        $namaBulan = $bulanIni->locale('id')->translatedFormat('F Y');
        $timestamp = Carbon::now()->format('Ymd_His');

        $kategoriData = Transaction::select(
                'categories.nama_kategori',
                DB::raw('SUM(transactions.quantity) as total_terjual'),
                DB::raw('SUM(transactions.total_harga) as total_pendapatan'),
                DB::raw('COUNT(DISTINCT transactions.id) as jumlah_transaksi')
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('transactions.status', 'success')
            ->whereMonth('transactions.created_at', $bulanIni->month)
            ->whereYear('transactions.created_at', $bulanIni->year)
            ->groupBy('categories.id', 'categories.nama_kategori')
            ->orderByDesc('total_pendapatan')
            ->get();

        $totalPendapatan = $kategoriData->sum('total_pendapatan');
        $pajak = $totalPendapatan * 0.11;

        $pdf = Pdf::loadView('admin.reports.pdf.kategori', compact(
            'namaBulan',
            'kategoriData',
            'totalPendapatan',
            'pajak'
        ))
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'dpi' => 150,
            'isHtml5ParserEnabled' => true,
        ]);

        return $pdf->download('Nextzly_Laporan_Kategori_' . str_replace(' ', '_', $namaBulan) . '_' . $timestamp . '.pdf');
    }

    /**
     * Export Excel - Laporan Pendapatan
     */
    public function exportPendapatanExcel()
    {
        $bulanIni = Carbon::now();
        $namaBulan = $bulanIni->locale('id')->translatedFormat('F Y');
        $timestamp = Carbon::now()->format('Ymd_His');

        return Excel::download(
            new PendapatanExport(),
            'Nextzly_Laporan_Pendapatan_' . str_replace(' ', '_', $namaBulan) . '_' . $timestamp . '.xlsx'
        );
    }

    /**
     * Export Excel - Laporan Transaksi
     */
    public function exportTransaksiExcel(Request $request)
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->toDateString());
        $timestamp = Carbon::now()->format('Ymd_His');

        return Excel::download(
            new TransaksiExport($startDate, $endDate),
            'Nextzly_Laporan_Transaksi_' . $startDate . '_to_' . $endDate . '_' . $timestamp . '.xlsx'
        );
    }

    /**
     * Export Excel - Laporan Kategori
     */
    public function exportKategoriExcel()
    {
        $bulanIni = Carbon::now();
        $namaBulan = $bulanIni->locale('id')->translatedFormat('F Y');
        $timestamp = Carbon::now()->format('Ymd_His');

        return Excel::download(
            new KategoriExport(),
            'Nextzly_Laporan_Kategori_' . str_replace(' ', '_', $namaBulan) . '_' . $timestamp . '.xlsx'
        );
    }
}
