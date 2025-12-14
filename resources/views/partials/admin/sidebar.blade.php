@php
    $currentRoute = Route::currentRouteName();
@endphp

<aside id="admin-sidebar" class="fixed top-16 left-0 z-40 w-64 h-[calc(100vh-64px)] bg-slate-950 text-slate-100 md:translate-x-0 flex flex-col overflow-hidden">

    {{-- Logo Area Mobile --}}
    <div class="md:hidden px-4 py-4 border-b border-slate-800">
        <span class="text-lg font-bold text-white">Nextzly</span>
        <span class="text-xs text-slate-500 ml-2">Admin</span>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 text-sm overflow-y-auto">
        <div class="text-[10px] uppercase tracking-[.2em] text-slate-500 mb-3 px-3">
            Main Menu
        </div>

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
            {{ $currentRoute == 'admin.dashboard'
                ? 'bg-slate-800/80 text-emerald-400'
                : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                {{ $currentRoute == 'admin.dashboard'
                    ? 'bg-emerald-500/20 text-emerald-400'
                    : 'bg-slate-800/50 group-hover:bg-slate-800' }}">
                <i class="bi bi-grid-1x2-fill text-sm"></i>
            </span>
            <span class="font-medium">Dashboard</span>
        </a>

        {{-- Kategori --}}
        <a href="{{ route('admin.categories.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
            {{ Str::startsWith($currentRoute, 'admin.categories')
                ? 'bg-slate-800/80 text-emerald-400'
                : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                {{ Str::startsWith($currentRoute, 'admin.categories')
                    ? 'bg-emerald-500/20 text-emerald-400'
                    : 'bg-slate-800/50 group-hover:bg-slate-800' }}">
                <i class="bi bi-bookmark-fill text-sm"></i>
            </span>
            <span class="font-medium">Kategori</span>
        </a>

        {{-- Data Produk --}}
        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
            {{ Str::startsWith($currentRoute, 'admin.products')
                ? 'bg-slate-800/80 text-emerald-400'
                : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                {{ Str::startsWith($currentRoute, 'admin.products')
                    ? 'bg-emerald-500/20 text-emerald-400'
                    : 'bg-slate-800/50 group-hover:bg-slate-800' }}">
                <i class="bi bi-box-seam text-sm"></i>
            </span>
            <span class="font-medium">Data Produk</span>
        </a>

        {{-- Transaksi --}}
        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
            {{ Str::startsWith($currentRoute, 'admin.transactions')
                ? 'bg-slate-800/80 text-emerald-400'
                : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                {{ Str::startsWith($currentRoute, 'admin.transactions')
                    ? 'bg-emerald-500/20 text-emerald-400'
                    : 'bg-slate-800/50 group-hover:bg-slate-800' }}">
                <i class="bi bi-receipt text-sm"></i>
            </span>
            <span class="font-medium">Transaksi</span>
        </a>

        {{-- Laporan --}}
        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
            {{ Str::startsWith($currentRoute, 'admin.reports')
                ? 'bg-slate-800/80 text-emerald-400'
                : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                {{ Str::startsWith($currentRoute, 'admin.reports')
                    ? 'bg-emerald-500/20 text-emerald-400'
                    : 'bg-slate-800/50 group-hover:bg-slate-800' }}">
                <i class="bi bi-bar-chart-line text-sm"></i>
            </span>
            <span class="font-medium">Laporan</span>
        </a>

        {{-- Data Pelanggan --}}
        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
            {{ Str::startsWith($currentRoute, 'admin.customers')
                ? 'bg-slate-800/80 text-emerald-400'
                : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200' }}">
            <span class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                {{ Str::startsWith($currentRoute, 'admin.customers')
                    ? 'bg-emerald-500/20 text-emerald-400'
                    : 'bg-slate-800/50 group-hover:bg-slate-800' }}">
                <i class="bi bi-people text-sm"></i>
            </span>
            <span class="font-medium">Data Pelanggan</span>
        </a>
    </nav>

    {{-- Sidebar Footer --}}
    <div class="px-4 py-4 border-t border-slate-800">
        <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-slate-900/50">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center">
                <i class="bi bi-shield-check text-white text-xs"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-medium text-slate-300 truncate">{{ session('admin_name') ?? 'Admin' }}</p>
                <p class="text-[10px] text-slate-500">{{ session('admin_role') ?? 'Administrator' }}</p>
            </div>
        </div>
    </div>
</aside>
