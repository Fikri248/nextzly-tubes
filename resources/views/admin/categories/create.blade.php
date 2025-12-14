@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')
@section('page-description', 'Buat kategori baru untuk produk.')

@section('content')
    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="hover:text-slate-700">Kategori</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-slate-700 font-medium">Tambah Baru</span>
    </div>

    {{-- FORM CARD --}}
    <div class="w-full">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="font-semibold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-folder-plus text-emerald-500"></i>
                    Informasi Kategori
                </h2>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                {{-- Nama Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm @error('nama_kategori') border-red-300 bg-red-50 @enderror"
                        placeholder="Contoh: Streaming Video" autofocus>
                    @error('nama_kategori')
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <textarea name="deskripsi" rows="4"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm resize-none"
                        placeholder="Deskripsi singkat tentang kategori ini...">{{ old('deskripsi') }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                        <i class="bi bi-check-lg"></i> Simpan Kategori
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
