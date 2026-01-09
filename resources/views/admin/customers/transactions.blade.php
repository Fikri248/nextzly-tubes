@extends('layouts.admin')

@section('title', 'Riwayat Transaksi - ' . $customer->name)
@section('page-title', 'Riwayat Transaksi')
@section('page-description', 'Riwayat transaksi pelanggan ' . $customer->name)

@section('content')
    {{-- BACK BUTTON + CUSTOMER INFO --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.customers.index') }}"
               class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition-colors">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center text-emerald-600 font-bold text-lg">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">{{ $customer->name }}</h2>
                    <p class="text-xs text-slate-500">
                        <i class="bi bi-whatsapp"></i> {{ $customer->phone }}
                        @if($customer->email)
                            <span class="mx-1">•</span> <i class="bi bi-envelope"></i> {{ $customer->email }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-all shadow-lg shadow-emerald-500/30">
                <i class="bi bi-whatsapp"></i>
                Hubungi
            </a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center">
                    <i class="bi bi-receipt text-sky-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Total Transaksi</p>
                    <p class="text-lg font-bold text-slate-800">{{ $transactions->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <i class="bi bi-check-circle text-emerald-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Lunas</p>
                    <p class="text-lg font-bold text-slate-800">{{ $transactions->whereIn('status', ['paid', 'success'])->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center">
                    <i class="bi bi-clock text-amber-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Pending</p>
                    <p class="text-lg font-bold text-slate-800">{{ $transactions->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Order ID</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Produk</th>
                        <th class="px-6 py-4 text-right font-semibold text-slate-600">Total</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-600">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs text-slate-600 bg-slate-100 px-2 py-1 rounded">{{ $transaction->order_id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($transaction->product && $transaction->product->logo)
                                <img src="{{ asset('logo/' . $transaction->product->logo) }}"
                                     alt="{{ $transaction->product->nama_produk ?? 'Produk' }}"
                                     class="w-10 h-10 rounded-lg object-cover">
                                @else
                                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                    <i class="bi bi-box"></i>
                                </div>
                                @endif
                                <span class="font-medium text-slate-800">
                                    {{ $transaction->product->nama_produk ?? 'Produk Dihapus' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-slate-800">
                            Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'paid' => 'bg-emerald-100 text-emerald-700',
                                    'success' => 'bg-emerald-100 text-emerald-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'expired' => 'bg-slate-100 text-slate-500',
                                    'failed' => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'paid' => 'Lunas',
                                    'success' => 'Success',
                                    'cancelled' => 'Dibatalkan',
                                    'expired' => 'Kadaluarsa',
                                    'failed' => 'Gagal',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$transaction->status] ?? 'bg-slate-100 text-slate-500' }}">
                                {{ $statusLabels[$transaction->status] ?? ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            {{ $transaction->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-xs">
                            {{ $transaction->status_note ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <i class="bi bi-receipt text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada transaksi</p>
                                <p class="text-slate-400 text-xs">Pelanggan ini belum melakukan transaksi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
@endsection
