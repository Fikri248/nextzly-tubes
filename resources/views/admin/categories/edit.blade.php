@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-description', 'Perbarui informasi kategori.')

@section('content')
    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="hover:text-slate-700">Kategori</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-slate-700 font-medium">Edit</span>
    </div>

    {{-- FORM CARD --}}
    <div class="w-full">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="font-semibold text-slate-800 flex items-center gap-2">
                    <i class="bi bi-pencil-square text-amber-500"></i>
                    Edit: {{ $category->nama_kategori }}
                </h2>
            </div>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm @error('nama_kategori') border-red-300 bg-red-50 @enderror"
                        placeholder="Contoh: Streaming Video">
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
                        placeholder="Deskripsi singkat tentang kategori ini...">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                </div>

                {{-- Info Timestamps --}}
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-slate-500">
                        <div class="flex items-center gap-1.5">
                            <i class="bi bi-calendar-plus"></i>
                            <span>Dibuat: <strong class="text-slate-600">{{ $category->created_at->format('d M Y, H:i') }}</strong></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i class="bi bi-calendar-check"></i>
                            <span>Diubah: <strong class="text-slate-600">{{ $category->updated_at->format('d M Y, H:i') }}</strong></span>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                        <i class="bi bi-check-lg"></i> Simpan Perubahan
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
