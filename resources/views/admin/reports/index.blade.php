@extends('layouts.admin')

@section('title', 'Laporan')
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
                    <p class="text-xs text-slate-500 mt-1">Ringkasan pendapatan bulan ini</p>
                </div>
                <i class="bi bi-cash-coin text-2xl text-emerald-500"></i>
            </div>
            <a href="{{ route('admin.reports.export-pendapatan') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-all w-full justify-center">
                <i class="bi bi-download"></i>
                Export PDF
            </a>
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
            <button onclick="showTransaksiModal()"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold transition-all w-full justify-center">
                <i class="bi bi-download"></i>
                Export PDF
            </button>
        </div>

        {{-- Laporan Kategori --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">Laporan Kategori</h3>
                    <p class="text-xs text-slate-500 mt-1">Analisis penjualan per kategori</p>
                </div>
                <i class="bi bi-bookmark text-2xl text-violet-500"></i>
            </div>
            <a href="{{ route('admin.reports.export-kategori') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-violet-500 hover:bg-violet-600 text-white text-sm font-semibold transition-all w-full justify-center">
                <i class="bi bi-download"></i>
                Export PDF
            </a>
        </div>
    </div>

    {{-- DATA PREVIEW --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h2 class="font-semibold text-slate-800">Preview Data</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-sky-50 rounded-xl p-4 border border-sky-100">
                    <p class="text-xs text-slate-500 mb-1">Pendapatan Bulan Ini</p>
                    <p class="text-xl font-bold text-sky-600">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                    <p class="text-xs text-slate-500 mb-1">Total Pendapatan</p>
                    <p class="text-xl font-bold text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                <div class="bg-amber-50 rounded-xl p-4 border border-amber-100">
                    <p class="text-xs text-slate-500 mb-1">Dengan Pajak 11%</p>
                    <p class="text-xl font-bold text-amber-600">Rp {{ number_format($totalDenganPajak, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Table Transaksi --}}
            <h3 class="text-sm font-semibold text-slate-800 mb-3">Transaksi Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-4 py-2 text-left font-semibold text-slate-600">ID</th>
                            <th class="px-4 py-2 text-left font-semibold text-slate-600">Produk</th>
                            <th class="px-4 py-2 text-center font-semibold text-slate-600">Qty</th>
                            <th class="px-4 py-2 text-right font-semibold text-slate-600">Total</th>
                            <th class="px-4 py-2 text-center font-semibold text-slate-600">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($transaksi as $trx)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2">#{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-4 py-2">{{ $trx->nama_produk }}</td>
                            <td class="px-4 py-2 text-center">{{ $trx->quantity }}</td>
                            <td class="px-4 py-2 text-right"><strong>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</strong></td>
                            <td class="px-4 py-2 text-center text-xs text-slate-500">{{ $trx->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL FILTER TRANSAKSI --}}
    <div id="transaksi-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeTransaksiModal()"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md mx-4">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-100">
                    <h3 class="font-semibold text-slate-800">Filter Laporan Transaksi</h3>
                </div>
                <form action="{{ route('admin.reports.export-transaksi') }}" method="GET" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ now()->startOfMonth()->toDateString() }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ now()->toDateString() }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-all transition-all">
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <button type="button" onclick="closeTransaksiModal()"
                            class="flex-1 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium transition-all">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-download"></i> Export PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const transaksiModal = document.getElementById('transaksi-modal');

    function showTransaksiModal() {
        transaksiModal.classList.remove('hidden');
    }

    function closeTransaksiModal() {
        transaksiModal.classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeTransaksiModal();
    });
</script>
@endpush
