@extends('layouts.admin')

@section('title', 'Daftar Transaksi')
@section('page-title', 'Daftar Transaksi')
@section('page-description', 'Kelola semua transaksi pelanggan')

@section('content')
    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center">
                    <i class="bi bi-receipt text-slate-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Total</p>
                    <p class="text-lg font-bold text-slate-800">{{ $stats['total'] }}</p>
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
                    <p class="text-lg font-bold text-amber-600">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center">
                    <i class="bi bi-pie-chart text-sky-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Sebagian</p>
                    <p class="text-lg font-bold text-sky-600">{{ $stats['partial'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <i class="bi bi-check-circle text-emerald-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Success</p>
                    <p class="text-lg font-bold text-emerald-600">{{ $stats['success'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                    <i class="bi bi-x-circle text-red-600"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Gagal</p>
                    <p class="text-lg font-bold text-red-600">{{ $stats['failed'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center">
                    <i class="bi bi-slash-circle text-slate-500"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Dibatalkan</p>
                    <p class="text-lg font-bold text-slate-500">{{ $stats['cancelled'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6">
        <div class="p-4 border-b border-slate-100">
            <form id="filterForm" action="{{ route('admin.transactions.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                {{-- Search --}}
                <div class="relative flex-1">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari order ID, nama, email, atau no. telepon..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-sm transition-all"
                           onkeydown="if(event.key==='Enter'){this.form.submit();}">
                </div>

                <div class="flex flex-wrap gap-2">
                    {{-- Custom Dropdown Tahun --}}
                    <div class="relative" data-dropdown="year">
                        <input type="hidden" name="year" id="yearInput" value="{{ request('year') }}">
                        <button type="button"
                                onclick="toggleDropdown('year')"
                                class="h-[42px] px-4 rounded-xl border border-slate-200 bg-white text-sm flex items-center gap-2 hover:border-sky-300 hover:bg-sky-50/50 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 transition-all min-w-[140px]">
                            <div class="w-7 h-7 rounded-lg bg-sky-100 flex items-center justify-center">
                                <i class="bi bi-calendar-event text-sky-600 text-xs"></i>
                            </div>
                            <span id="yearLabel" class="text-slate-700 font-medium">{{ request('year') ?: 'Semua Tahun' }}</span>
                            <i id="yearArrow" class="bi bi-chevron-down text-slate-400 text-xs ml-auto transition-transform duration-200"></i>
                        </button>
                        <div id="yearMenu"
                             class="absolute top-full left-0 mt-2 bg-white rounded-xl border border-slate-200 shadow-xl z-50 overflow-hidden opacity-0 invisible translate-y-2 transition-all duration-200 min-w-[160px]">
                            <div class="p-2">
                                <button type="button"
                                        onclick="selectYear('')"
                                        class="w-full px-3 py-2.5 rounded-lg text-left text-sm flex items-center gap-3 hover:bg-slate-50 transition-colors {{ !request('year') ? 'bg-sky-50 text-sky-700' : 'text-slate-600' }}">
                                    <div class="w-6 h-6 rounded-md {{ !request('year') ? 'bg-sky-100' : 'bg-slate-100' }} flex items-center justify-center">
                                        <i class="bi bi-calendar3 text-xs {{ !request('year') ? 'text-sky-600' : 'text-slate-500' }}"></i>
                                    </div>
                                    <span class="font-medium">Semua Tahun</span>
                                    @if(!request('year'))
                                    <i class="bi bi-check-lg text-sky-500 ml-auto"></i>
                                    @endif
                                </button>
                                @for($y = date('Y') + 1; $y >= date('Y') - 5; $y--)
                                <button type="button"
                                        onclick="selectYear('{{ $y }}')"
                                        class="w-full px-3 py-2.5 rounded-lg text-left text-sm flex items-center gap-3 hover:bg-slate-50 transition-colors {{ request('year') == $y ? 'bg-sky-50 text-sky-700' : 'text-slate-600' }}">
                                    <div class="w-6 h-6 rounded-md {{ request('year') == $y ? 'bg-sky-100' : 'bg-slate-100' }} flex items-center justify-center">
                                        <span class="text-xs font-bold {{ request('year') == $y ? 'text-sky-600' : 'text-slate-500' }}">{{ substr($y, 2) }}</span>
                                    </div>
                                    <span class="font-medium">{{ $y }}</span>
                                    @if(request('year') == $y)
                                    <i class="bi bi-check-lg text-sky-500 ml-auto"></i>
                                    @endif
                                </button>
                                @endfor
                            </div>
                        </div>
                    </div>

                    {{-- Custom Dropdown Bulan --}}
                    @php
                        $months = [
                            1 => ['name' => 'Januari', 'short' => 'Jan'],
                            2 => ['name' => 'Februari', 'short' => 'Feb'],
                            3 => ['name' => 'Maret', 'short' => 'Mar'],
                            4 => ['name' => 'April', 'short' => 'Apr'],
                            5 => ['name' => 'Mei', 'short' => 'Mei'],
                            6 => ['name' => 'Juni', 'short' => 'Jun'],
                            7 => ['name' => 'Juli', 'short' => 'Jul'],
                            8 => ['name' => 'Agustus', 'short' => 'Agu'],
                            9 => ['name' => 'September', 'short' => 'Sep'],
                            10 => ['name' => 'Oktober', 'short' => 'Okt'],
                            11 => ['name' => 'November', 'short' => 'Nov'],
                            12 => ['name' => 'Desember', 'short' => 'Des'],
                        ];
                        $selectedMonth = request('month') ? $months[request('month')]['name'] : 'Semua Bulan';
                    @endphp
                    <div class="relative" data-dropdown="month">
                        <input type="hidden" name="month" id="monthInput" value="{{ request('month') }}">
                        <button type="button"
                                onclick="toggleDropdown('month')"
                                class="h-[42px] px-4 rounded-xl border border-slate-200 bg-white text-sm flex items-center gap-2 hover:border-emerald-300 hover:bg-emerald-50/50 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all min-w-[160px]">
                            <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center">
                                <i class="bi bi-calendar-month text-emerald-600 text-xs"></i>
                            </div>
                            <span id="monthLabel" class="text-slate-700 font-medium">{{ $selectedMonth }}</span>
                            <i id="monthArrow" class="bi bi-chevron-down text-slate-400 text-xs ml-auto transition-transform duration-200"></i>
                        </button>
                        <div id="monthMenu"
                             class="absolute top-full left-0 mt-2 bg-white rounded-xl border border-slate-200 shadow-xl z-50 overflow-hidden opacity-0 invisible translate-y-2 transition-all duration-200 w-[280px]">
                            <div class="p-2">
                                <button type="button"
                                        onclick="selectMonth('', 'Semua Bulan')"
                                        class="w-full px-3 py-2.5 rounded-lg text-left text-sm flex items-center gap-3 hover:bg-slate-50 transition-colors mb-2 {{ !request('month') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600' }}">
                                    <div class="w-6 h-6 rounded-md {{ !request('month') ? 'bg-emerald-100' : 'bg-slate-100' }} flex items-center justify-center">
                                        <i class="bi bi-calendar3 text-xs {{ !request('month') ? 'text-emerald-600' : 'text-slate-500' }}"></i>
                                    </div>
                                    <span class="font-medium">Semua Bulan</span>
                                    @if(!request('month'))
                                    <i class="bi bi-check-lg text-emerald-500 ml-auto"></i>
                                    @endif
                                </button>
                                <div class="grid grid-cols-3 gap-1">
                                    @foreach($months as $num => $month)
                                    <button type="button"
                                            onclick="selectMonth('{{ $num }}', '{{ $month['name'] }}')"
                                            class="px-3 py-2.5 rounded-lg text-sm font-medium text-center hover:bg-emerald-50 transition-colors {{ request('month') == $num ? 'bg-emerald-100 text-emerald-700' : 'text-slate-600 hover:text-emerald-600' }}">
                                        {{ $month['short'] }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Custom Dropdown Status --}}
                    @php
                        $statusConfig = [
                            '' => ['label' => 'Semua Status', 'color' => 'slate', 'icon' => 'bi-funnel'],
                            'pending' => ['label' => 'Pending', 'color' => 'amber', 'icon' => 'bi-clock'],
                            'partial' => ['label' => 'Dibayar Sebagian', 'color' => 'sky', 'icon' => 'bi-pie-chart'],
                            'success' => ['label' => 'Success', 'color' => 'emerald', 'icon' => 'bi-check-circle'],
                            'failed' => ['label' => 'Gagal', 'color' => 'red', 'icon' => 'bi-x-circle'],
                            'cancelled' => ['label' => 'Dibatalkan', 'color' => 'slate', 'icon' => 'bi-slash-circle'],
                        ];
                        $currentStatus = request('status') ?? '';
                        $currentConfig = $statusConfig[$currentStatus];
                    @endphp
                    <div class="relative" data-dropdown="status">
                        <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">
                        <button type="button"
                                onclick="toggleDropdown('status')"
                                class="h-[42px] px-4 rounded-xl border border-slate-200 bg-white text-sm flex items-center gap-2 hover:border-violet-300 hover:bg-violet-50/50 focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all min-w-[160px]">
                            <div class="w-7 h-7 rounded-lg bg-violet-100 flex items-center justify-center">
                                <i class="bi {{ $currentConfig['icon'] }} text-violet-600 text-xs"></i>
                            </div>
                            <span id="statusLabel" class="text-slate-700 font-medium">{{ $currentConfig['label'] }}</span>
                            <i id="statusArrow" class="bi bi-chevron-down text-slate-400 text-xs ml-auto transition-transform duration-200"></i>
                        </button>
                        <div id="statusMenu"
                             class="absolute top-full right-0 mt-2 bg-white rounded-xl border border-slate-200 shadow-xl z-50 overflow-hidden opacity-0 invisible translate-y-2 transition-all duration-200 min-w-[180px]">
                            <div class="p-2">
                                @foreach($statusConfig as $value => $config)
                                @php
                                    $colorClasses = [
                                        'slate' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'active' => 'bg-slate-50'],
                                        'amber' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'active' => 'bg-amber-50'],
                                        'sky' => ['bg' => 'bg-sky-100', 'text' => 'text-sky-600', 'active' => 'bg-sky-50'],
                                        'emerald' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'active' => 'bg-emerald-50'],
                                        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'active' => 'bg-red-50'],
                                    ];
                                    $colors = $colorClasses[$config['color']];
                                    $isActive = $currentStatus === $value;
                                @endphp
                                <button type="button"
                                        onclick="selectStatus('{{ $value }}', '{{ $config['label'] }}', '{{ $config['icon'] }}')"
                                        class="w-full px-3 py-2.5 rounded-lg text-left text-sm flex items-center gap-3 hover:{{ $colors['active'] }} transition-colors {{ $isActive ? $colors['active'] : '' }}">
                                    <div class="w-6 h-6 rounded-md {{ $colors['bg'] }} flex items-center justify-center">
                                        <i class="bi {{ $config['icon'] }} text-xs {{ $colors['text'] }}"></i>
                                    </div>
                                    <span class="font-medium {{ $isActive ? $colors['text'] : 'text-slate-600' }}">{{ $config['label'] }}</span>
                                    @if($isActive)
                                    <i class="bi bi-check-lg {{ $colors['text'] }} ml-auto"></i>
                                    @endif
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Reset Filter --}}
                    @if(request('search') || request('status') || request('year') || request('month'))
                    <a href="{{ route('admin.transactions.index') }}"
                       class="h-[42px] px-4 rounded-xl bg-slate-100 hover:bg-red-100 text-slate-500 hover:text-red-600 text-sm font-semibold transition-all flex items-center gap-2"
                       title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Order ID</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Pelanggan</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Produk</th>
                        <th class="px-6 py-4 text-right font-semibold text-slate-600">Total</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-600">Status</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Tanggal</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs text-slate-600 bg-slate-100 px-2 py-1 rounded">
                                {{ $transaction->order_id }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-sky-600 font-bold text-xs">
                                    {{ strtoupper(substr($transaction->customer->name ?? 'X', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">{{ $transaction->customer->name ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">{{ $transaction->customer->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($transaction->product && $transaction->product->logo)
                                <img src="{{ asset('logo/' . $transaction->product->logo) }}"
                                     alt="{{ $transaction->product->nama_produk ?? 'Produk' }}"
                                     class="w-9 h-9 rounded-lg object-cover">
                                @else
                                <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                    <i class="bi bi-box"></i>
                                </div>
                                @endif
                                <span class="font-medium text-slate-700">
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
                                    'partial' => 'bg-sky-100 text-sky-700',
                                    'success' => 'bg-emerald-100 text-emerald-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                    'cancelled' => 'bg-slate-100 text-slate-500',
                                ];
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'partial' => 'Dibayar Sebagian',
                                    'success' => 'Success',
                                    'failed' => 'Gagal',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$transaction->status] ?? 'bg-slate-100 text-slate-500' }}">
                                {{ $statusLabels[$transaction->status] ?? ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            <p>{{ $transaction->created_at->format('d M Y') }}</p>
                            <p class="text-slate-400">{{ $transaction->created_at->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1">
                                @if(in_array($transaction->status, ['pending', 'partial'], true))
                                <button onclick="openStatusModal('{{ $transaction->id }}', '{{ $transaction->order_id }}')"
                                        class="w-8 h-8 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-600 flex items-center justify-center transition-colors"
                                        title="Update Status">
                                    <i class="bi bi-check2-square text-sm"></i>
                                </button>
                                @endif
                                <button onclick="openDeleteModal('{{ $transaction->id }}', '{{ $transaction->order_id }}')"
                                        class="w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 text-red-600 flex items-center justify-center transition-colors"
                                        title="Hapus">
                                    <i class="bi bi-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <i class="bi bi-receipt text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada transaksi</p>
                                @if(request('search') || request('status') || request('year') || request('month'))
                                <p class="text-slate-400 text-xs">Coba ubah filter atau kata kunci pencarian</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

    {{-- MODAL: UPDATE STATUS --}}
    <div id="statusModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeStatusModal()"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mx-4 transform transition-all">
                <div class="px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-500">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="bi bi-arrow-repeat"></i>
                        Update Status Transaksi
                    </h3>
                    <p class="text-emerald-100 text-sm mt-1">Order ID: <span id="statusOrderId" class="font-mono font-semibold"></span></p>
                </div>
                <div class="p-6">
                    <p class="text-slate-600 text-sm mb-4">Pilih status baru untuk transaksi ini:</p>
                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" id="selectedStatus">
                        <div class="mb-3">
                            <label class="block text-xs font-semibold text-slate-600 mb-2">Catatan (Opsional)</label>
                            <textarea name="status_note" rows="2"
                                      class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm resize-none"
                                      placeholder="Contoh: DP 50% sudah masuk"></textarea>
                        </div>
                        <div class="grid grid-cols-1 gap-3">
                            <button type="button" onclick="selectStatusOption('partial')"
                                    class="status-option flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-sky-500 hover:bg-sky-50 transition-all group"
                                    data-status="partial">
                                <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 group-hover:bg-sky-500 group-hover:text-white transition-colors">
                                    <i class="bi bi-pie-chart-fill"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold text-slate-800">Dibayar Sebagian</p>
                                    <p class="text-xs text-slate-500">Pembayaran belum lunas</p>
                                </div>
                            </button>
                            <button type="button" onclick="selectStatusOption('success')"
                                    class="status-option flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-emerald-500 hover:bg-emerald-50 transition-all group"
                                    data-status="success">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold text-slate-800">Success</p>
                                    <p class="text-xs text-slate-500">Pembayaran berhasil dikonfirmasi</p>
                                </div>
                            </button>
                            <button type="button" onclick="selectStatusOption('failed')"
                                    class="status-option flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-red-500 hover:bg-red-50 transition-all group"
                                    data-status="failed">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 group-hover:bg-red-500 group-hover:text-white transition-colors">
                                    <i class="bi bi-x-circle-fill"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold text-slate-800">Gagal</p>
                                    <p class="text-xs text-slate-500">Pembayaran gagal atau tidak valid</p>
                                </div>
                            </button>
                            <button type="button" onclick="selectStatusOption('cancelled')"
                                    class="status-option flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-slate-400 hover:bg-slate-50 transition-all group"
                                    data-status="cancelled">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-slate-500 group-hover:text-white transition-colors">
                                    <i class="bi bi-slash-circle-fill"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold text-slate-800">Batalkan</p>
                                    <p class="text-xs text-slate-500">Transaksi dibatalkan</p>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button onclick="closeStatusModal()"
                            class="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-200 font-medium transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: DELETE CONFIRMATION --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mx-4 transform transition-all">
                <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-rose-500">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="bi bi-exclamation-triangle"></i>
                        Hapus Transaksi
                    </h3>
                </div>
                <div class="p-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-trash text-3xl text-red-500"></i>
                    </div>
                    <p class="text-slate-600 mb-2">Yakin ingin menghapus transaksi ini?</p>
                    <p class="font-mono text-sm bg-slate-100 px-3 py-1.5 rounded-lg inline-block text-slate-700" id="deleteOrderId"></p>
                    <p class="text-xs text-slate-400 mt-3">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-center gap-3">
                    <button onclick="closeDeleteModal()"
                            class="px-6 py-2.5 rounded-xl text-slate-600 hover:bg-slate-200 font-medium transition-colors">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-6 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition-colors">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .status-option.selected {
        border-color: #10b981 !important;
        background-color: #ecfdf5 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // ==========================================
    // CUSTOM DROPDOWNS
    // ==========================================
    let activeDropdown = null;

    function toggleDropdown(name) {
        const menu = document.getElementById(name + 'Menu');
        const arrow = document.getElementById(name + 'Arrow');

        if (activeDropdown && activeDropdown !== name) {
            closeDropdown(activeDropdown);
        }

        const isOpen = menu.classList.contains('opacity-100');

        if (isOpen) {
            closeDropdown(name);
        } else {
            menu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
            menu.classList.add('opacity-100', 'visible', 'translate-y-0');
            arrow.classList.add('rotate-180');
            activeDropdown = name;
        }
    }

    function closeDropdown(name) {
        const menu = document.getElementById(name + 'Menu');
        const arrow = document.getElementById(name + 'Arrow');

        if (menu && arrow) {
            menu.classList.add('opacity-0', 'invisible', 'translate-y-2');
            menu.classList.remove('opacity-100', 'visible', 'translate-y-0');
            arrow.classList.remove('rotate-180');
        }

        if (activeDropdown === name) {
            activeDropdown = null;
        }
    }

    function closeAllDropdowns() {
        ['year', 'month', 'status'].forEach(name => closeDropdown(name));
    }

    function selectYear(value) {
        document.getElementById('yearInput').value = value;
        document.getElementById('yearLabel').textContent = value || 'Semua Tahun';
        closeAllDropdowns();
        document.getElementById('filterForm').submit();
    }

    function selectMonth(value, label) {
        document.getElementById('monthInput').value = value;
        document.getElementById('monthLabel').textContent = label;
        closeAllDropdowns();
        document.getElementById('filterForm').submit();
    }

    function selectStatus(value, label, icon) {
        document.getElementById('statusInput').value = value;
        document.getElementById('statusLabel').textContent = label;
        closeAllDropdowns();
        document.getElementById('filterForm').submit();
    }

    document.addEventListener('click', function(e) {
        const dropdowns = document.querySelectorAll('[data-dropdown]');
        let clickedInside = false;

        dropdowns.forEach(dropdown => {
            if (dropdown.contains(e.target)) {
                clickedInside = true;
            }
        });

        if (!clickedInside) {
            closeAllDropdowns();
        }
    });

    // ==========================================
    // STATUS MODAL
    // ==========================================
    function openStatusModal(id, orderId) {
        document.getElementById('statusOrderId').textContent = orderId;
        document.getElementById('statusForm').action = `/admin/transactions/${id}/status`;
        document.getElementById('statusModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.querySelectorAll('.status-option').forEach(btn => btn.classList.remove('selected'));
        const noteInput = document.querySelector('#statusForm textarea[name="status_note"]');
        if (noteInput) noteInput.value = '';
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function selectStatusOption(status) {
        document.getElementById('selectedStatus').value = status;
        document.querySelectorAll('.status-option').forEach(btn => {
            btn.classList.remove('selected');
            if (btn.dataset.status === status) {
                btn.classList.add('selected');
            }
        });
        setTimeout(() => {
            document.getElementById('statusForm').submit();
        }, 200);
    }

    // ==========================================
    // DELETE MODAL
    // ==========================================
    function openDeleteModal(id, orderId) {
        document.getElementById('deleteOrderId').textContent = orderId;
        document.getElementById('deleteForm').action = `/admin/transactions/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // ==========================================
    // GLOBAL: CLOSE WITH ESCAPE KEY
    // ==========================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
            closeStatusModal();
            closeDeleteModal();
        }
    });
</script>
@endpush
