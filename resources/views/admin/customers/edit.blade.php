@extends('layouts.admin')

@section('title', 'Edit Pelanggan')
@section('page-title', 'Edit Pelanggan')
@section('page-description', 'Perbarui data pelanggan.')

@section('content')
    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.customers.index') }}" class="hover:text-slate-700">Pelanggan</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-slate-700 font-medium">Edit: {{ $customer->name }}</span>
    </div>

    {{-- FORM CARD --}}
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="font-semibold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-person-gear text-amber-500"></i>
                    Edit Informasi Pelanggan
                </h2>
            </div>

            <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all text-sm @error('name') border-red-300 bg-red-50 @enderror"
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
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all text-sm @error('email') border-red-300 bg-red-50 @enderror"
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
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all text-sm @error('phone') border-red-300 bg-red-50 @enderror"
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

                {{-- Customer Meta Info --}}
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span>Bergabung: {{ $customer->created_at->format('d M Y, H:i') }}</span>
                        <span>Update: {{ $customer->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold transition-all shadow-lg shadow-amber-500/30 flex items-center gap-2">
                        <i class="bi bi-check-lg"></i> Update Pelanggan
                    </button>
                    <a href="{{ route('admin.customers.index') }}"
                        class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium transition-all">
                        Batal
                    </a>
                    <a href="{{ route('admin.customers.transactions', $customer) }}"
                        class="ml-auto px-4 py-2.5 rounded-xl bg-sky-100 hover:bg-sky-200 text-sky-700 text-sm font-medium transition-all flex items-center gap-2">
                        <i class="bi bi-receipt"></i> Lihat Transaksi
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
