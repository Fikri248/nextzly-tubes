@extends('layouts.admin')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Tambah Pelanggan')
@section('page-description', 'Tambah data pelanggan baru.')

@section('content')
    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.customers.index') }}" class="hover:text-slate-700">Pelanggan</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-slate-700 font-medium">Tambah Baru</span>
    </div>

    {{-- FORM CARD --}}
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="font-semibold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-person-plus text-emerald-500"></i>
                    Informasi Pelanggan
                </h2>
            </div>

            <form action="{{ route('admin.customers.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm @error('name') border-red-300 bg-red-50 @enderror"
                        placeholder="Contoh: John Doe" autofocus>
                    @error('name')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Email <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm @error('email') border-red-300 bg-red-50 @enderror"
                        placeholder="Contoh: john@email.com">
                    @error('email')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm @error('phone') border-red-300 bg-red-50 @enderror"
                        placeholder="Contoh: 08123456789">
                    @error('phone')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                    <p class="mt-1.5 text-xs text-slate-400">
                        <i class="bi bi-info-circle"></i> Nomor ini akan digunakan untuk WhatsApp
                    </p>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                        <i class="bi bi-check-lg"></i> Simpan Pelanggan
                    </button>
                    <a href="{{ route('admin.customers.index') }}"
                        class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
