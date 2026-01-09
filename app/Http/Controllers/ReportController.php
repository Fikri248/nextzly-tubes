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
    public function index(Request $request)
    {
        $report = $this->buildSalesReport($request, 15);

        $namaBulan = $report['period']['label'];
        $totalPendapatan = $report['summary']['total_pendapatan'];
        $pajak = $report['summary']['pajak'];
        $totalDenganPajak = $report['summary']['total_dengan_pajak'];
        $pendapatanBulanIni = $report['summary']['total_pendapatan'];
        $transaksi = $report['transactions'];

        return view('admin.reports.index', compact(
            'namaBulan',
            'totalPendapatan',
            'pajak',
            'totalDenganPajak',
            'pendapatanBulanIni',
            'transaksi',
            'report'
        ));
    }

    /**
     * Export PDF - Laporan Pendapatan
     */
    public function exportPendapatanPDF(Request $request)
    {
        $report = $this->buildSalesReport($request);
        $namaBulan = $report['period']['label'];
        $timestamp = Carbon::now()->format('Ymd_His');

        $totalPendapatan = $report['summary']['total_pendapatan'];
        $pajak = $report['summary']['pajak'];
        $totalDenganPajak = $report['summary']['total_dengan_pajak'];
        $pendapatanBulanIni = $report['summary']['total_pendapatan'];
        $transaksi = $report['transactions'];
        $penjualanPerProduk = $report['top_products']['by_revenue'];

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
    public function exportKategoriPDF(Request $request)
    {
        $period = $this->resolveReportPeriod($request);
        $namaBulan = $period['label'];
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
            ->whereBetween('transactions.created_at', [$period['start'], $period['end']])
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
    public function exportPendapatanExcel(Request $request)
    {
        $period = $this->resolveReportPeriod($request);
        $namaBulan = $period['label'];
        $timestamp = Carbon::now()->format('Ymd_His');

        return Excel::download(
            new PendapatanExport($period['start_date'], $period['end_date'], $period['label']),
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
    public function exportKategoriExcel(Request $request)
    {
        $period = $this->resolveReportPeriod($request);
        $namaBulan = $period['label'];
        $timestamp = Carbon::now()->format('Ymd_His');

        return Excel::download(
            new KategoriExport($period['start_date'], $period['end_date'], $period['label']),
            'Nextzly_Laporan_Kategori_' . str_replace(' ', '_', $namaBulan) . '_' . $timestamp . '.xlsx'
        );
    }

    private function resolveReportPeriod(Request $request): array
    {
        $preset = $request->query('preset');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $month = $request->query('month');
        $year = $request->query('year');

        if ($preset) {
            $baseDate = Carbon::now();
            switch ($preset) {
                case 'day':
                    $start = $baseDate->copy()->startOfDay();
                    $end = $baseDate->copy()->endOfDay();
                    $label = $baseDate->locale('id')->translatedFormat('d F Y');
                    break;
                case 'week':
                    $start = $baseDate->copy()->startOfWeek();
                    $end = $baseDate->copy()->endOfWeek();
                    $label = 'Minggu Ini (' . $start->locale('id')->translatedFormat('d M') . ' - ' . $end->locale('id')->translatedFormat('d M Y') . ')';
                    break;
                case 'month':
                    $start = $baseDate->copy()->startOfMonth();
                    $end = $baseDate->copy()->endOfMonth();
                    $label = $baseDate->locale('id')->translatedFormat('F Y');
                    break;
                case 'year':
                    $start = $baseDate->copy()->startOfYear();
                    $end = $baseDate->copy()->endOfYear();
                    $label = $baseDate->locale('id')->translatedFormat('Y');
                    break;
                case 'all':
                default:
                    $minDate = Transaction::where('status', 'success')->min('created_at');
                    $maxDate = Transaction::where('status', 'success')->max('created_at');
                    $start = $minDate ? Carbon::parse($minDate)->startOfDay() : Carbon::now()->startOfDay();
                    $end = $maxDate ? Carbon::parse($maxDate)->endOfDay() : Carbon::now()->endOfDay();
                    $label = 'Semua Periode';
                    break;
            }

            return [
                'start' => $start,
                'end' => $end,
                'label' => $label,
                'start_date' => $start->toDateString(),
                'end_date' => $end->toDateString(),
            ];
        }

        if ($startDate || $endDate) {
            $start = Carbon::parse($startDate ?? Carbon::now()->startOfMonth()->toDateString())->startOfDay();
            $end = Carbon::parse($endDate ?? Carbon::now()->toDateString())->endOfDay();
            $label = $start->locale('id')->translatedFormat('d M Y') . ' - ' . $end->locale('id')->translatedFormat('d M Y');
        } elseif ($month || $year) {
            $baseDate = Carbon::createFromDate($year ?: Carbon::now()->year, $month ?: Carbon::now()->month, 1);
            $start = $baseDate->copy()->startOfMonth();
            $end = $baseDate->copy()->endOfMonth();
            $label = $baseDate->locale('id')->translatedFormat('F Y');
        } else {
            $minDate = Transaction::where('status', 'success')->min('created_at');
            $maxDate = Transaction::where('status', 'success')->max('created_at');
            $start = $minDate ? Carbon::parse($minDate)->startOfDay() : Carbon::now()->startOfDay();
            $end = $maxDate ? Carbon::parse($maxDate)->endOfDay() : Carbon::now()->endOfDay();
            $label = 'Semua Periode';
        }

        return [
            'start' => $start,
            'end' => $end,
            'label' => $label,
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
        ];
    }

    private function buildSalesReport(Request $request, ?int $limitTransactions = null): array
    {
        $period = $this->resolveReportPeriod($request);

        $baseQuery = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$period['start'], $period['end']]);

        $totalPendapatan = (clone $baseQuery)->sum('total_harga');
        $pajak = $totalPendapatan * 0.11;

        $transactionsQuery = Transaction::select(
                'transactions.id',
                'products.nama_produk',
                'transactions.quantity',
                'transactions.total_harga',
                'transactions.created_at',
                'transactions.status'
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.status', 'success')
            ->whereBetween('transactions.created_at', [$period['start'], $period['end']])
            ->orderBy('transactions.created_at', 'desc');

        if ($limitTransactions) {
            $transactionsQuery->limit($limitTransactions);
        }

        $topByRevenue = Transaction::select(
                'products.nama_produk',
                DB::raw('SUM(transactions.quantity) as total_terjual'),
                DB::raw('SUM(transactions.total_harga) as total_pendapatan'),
                DB::raw('COUNT(transactions.id) as jumlah_transaksi')
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.status', 'success')
            ->whereBetween('transactions.created_at', [$period['start'], $period['end']])
            ->groupBy('products.id', 'products.nama_produk')
            ->orderByDesc('total_pendapatan')
            ->limit(10)
            ->get();

        $topByCount = Transaction::select(
                'products.nama_produk',
                DB::raw('COUNT(transactions.id) as jumlah_transaksi'),
                DB::raw('SUM(transactions.total_harga) as total_pendapatan')
            )
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.status', 'success')
            ->whereBetween('transactions.created_at', [$period['start'], $period['end']])
            ->groupBy('products.id', 'products.nama_produk')
            ->orderByDesc('jumlah_transaksi')
            ->limit(10)
            ->get();

        return [
            'period' => $period,
            'summary' => [
                'total_pendapatan' => $totalPendapatan,
                'pajak' => $pajak,
                'pendapatan_bersih' => $totalPendapatan - $pajak,
                'total_dengan_pajak' => $totalPendapatan + $pajak,
                'jumlah_transaksi' => (clone $baseQuery)->count(),
            ],
            'transactions' => $transactionsQuery->get(),
            'top_products' => [
                'by_revenue' => $topByRevenue,
                'by_count' => $topByCount,
            ],
        ];
    }
}

