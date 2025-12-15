@extends('layouts.admin')

@section('page-title', 'Laporan & Export')
@section('page-description', 'Kelola dan export laporan pendapatan, transaksi, dan kategori.')

@section('content')
    {{-- EXPORT OPTIONS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        {{-- Laporan Pendapatan --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Laporan Pendapatan</h3>
                    <p class="text-xs text-slate-500 mt-1">Ringkasan pendapatan & top produk</p>
                </div>
                <i class="bi bi-cash-coin text-2xl text-emerald-500"></i>
            </div>
            <div class="space-y-2">
                <a href="{{ route('admin.reports.export-pendapatan-pdf') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition-all w-full justify-center">
                    <i class="bi bi-file-pdf"></i>
                    Export PDF
                </a>
                <a href="{{ route('admin.reports.export-pendapatan-excel') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition-all w-full justify-center">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>
            </div>
        </div>

        {{-- Laporan Transaksi --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Laporan Transaksi</h3>
                    <p class="text-xs text-slate-500 mt-1">Detail transaksi dengan filter tanggal</p>
                </div>
                <i class="bi bi-receipt text-2xl text-sky-500"></i>
            </div>
            <div class="space-y-2">
                <a href="{{ route('admin.reports.export-transaksi-pdf') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition-all w-full justify-center">
                    <i class="bi bi-file-pdf"></i>
                    Export PDF
                </a>
                <a href="{{ route('admin.reports.export-transaksi-excel') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition-all w-full justify-center">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>
            </div>
        </div>

        {{-- Laporan Kategori --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Laporan Kategori</h3>
                    <p class="text-xs text-slate-500 mt-1">Penjualan per kategori bulan ini</p>
                </div>
                <i class="bi bi-grid text-2xl text-violet-500"></i>
            </div>
            <div class="space-y-2">
                <a href="{{ route('admin.reports.export-kategori-pdf') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition-all w-full justify-center">
                    <i class="bi bi-file-pdf"></i>
                    Export PDF
                </a>
                <a href="{{ route('admin.reports.export-kategori-excel') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition-all w-full justify-center">
                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel
                </a>
            </div>
        </div>
    </div>

    {{-- RINGKASAN PENDAPATAN --}}
    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 mb-8 text-white shadow-lg">
        <h2 class="text-lg font-bold mb-4">💰 Ringkasan Pendapatan - {{ $namaBulan }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                <p class="text-sm text-white/80 mb-1">Total Pendapatan</p>
                <p class="text-2xl font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                <p class="text-sm text-white/80 mb-1">Pajak (11%)</p>
                <p class="text-2xl font-bold">Rp {{ number_format($pajak, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                <p class="text-sm text-white/80 mb-1">Total + Pajak</p>
                <p class="text-2xl font-bold">Rp {{ number_format($totalDenganPajak, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- TABEL TRANSAKSI TERBARU --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-800">📋 Transaksi Terbaru (Top 15)</h2>
            <p class="text-sm text-slate-500 mt-1">Daftar transaksi terbaru yang berhasil</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Total Harga</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($transaksi as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                TRX-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $item->nama_produk }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 text-center">{{ $item->quantity }} akun</td>
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900 text-right">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 text-center">
                                {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $item->status === 'success' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <i class="bi bi-inbox text-4xl mb-2 block"></i>
                                <p class="text-sm">Belum ada transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- INFO FOOTER --}}
    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
        <div class="flex items-start gap-3">
            <i class="bi bi-info-circle text-blue-600 text-xl"></i>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">💡 Tips Export Laporan:</p>
                <ul class="list-disc list-inside space-y-1 text-blue-700">
                    <li><strong>Laporan Pendapatan:</strong> Export ringkasan total pendapatan + top 10 produk terlaris</li>
                    <li><strong>Laporan Transaksi:</strong> Export detail semua transaksi dengan filter tanggal</li>
                    <li><strong>Laporan Kategori:</strong> Export penjualan per kategori bulan ini</li>
                    <li>File akan otomatis terdownload dalam format <strong>PDF</strong> atau <strong>Excel (XLSX)</strong></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
