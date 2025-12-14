@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')
@section('page-description', 'Tambah, edit, dan hapus kategori produk.')

@section('content')
    {{-- HEADER + ADD BUTTON --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-800">Daftar Kategori</h2>
            <p class="text-xs text-slate-500">Total {{ $categories->total() }} kategori</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-all shadow-lg shadow-emerald-500/30">
            <i class="bi bi-plus-lg"></i>
            Tambah Kategori
        </a>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">#</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Nama Kategori</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Deskripsi</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-600">Jumlah Produk</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $index => $category)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500">
                            {{ $categories->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-100 to-sky-200 flex items-center justify-center text-sky-600">
                                    <i class="bi bi-folder-fill"></i>
                                </div>
                                <span class="font-semibold text-slate-800">{{ $category->nama_kategori }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            <span class="line-clamp-2">{{ $category->deskripsi ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-semibold">
                                {{ $category->products_count }} produk
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="w-8 h-8 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-600 flex items-center justify-center transition-colors"
                                    title="Edit">
                                    <i class="bi bi-pencil text-sm"></i>
                                </a>
                                <button type="button"
                                    onclick="confirmDelete({{ $category->id }}, '{{ $category->nama_kategori }}')"
                                    class="w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 text-red-600 flex items-center justify-center transition-colors"
                                    title="Hapus">
                                    <i class="bi bi-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <i class="bi bi-folder-x text-2xl"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada kategori</p>
                                <a href="{{ route('admin.categories.create') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                    + Tambah kategori pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

    {{-- DELETE CONFIRMATION MODAL --}}
    <div id="delete-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm animate-backdrop-in" onclick="closeDeleteModal()"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md mx-4">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden animate-modal-in">
                <div class="px-6 py-4 bg-red-50 border-b border-red-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                            <i class="bi bi-exclamation-triangle-fill text-red-500 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800">Konfirmasi Hapus</h3>
                            <p class="text-xs text-slate-500">Tindakan ini tidak dapat dibatalkan</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <p class="text-sm text-slate-600">
                        Apakah Anda yakin ingin menghapus kategori <strong id="delete-category-name" class="text-slate-800"></strong>?
                    </p>
                    <p class="text-xs text-slate-500 mt-2">
                        <i class="bi bi-info-circle"></i> Semua data terkait kategori ini akan dihapus permanen.
                    </p>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium transition-colors">
                        Batal
                    </button>
                    <form id="delete-form" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition-colors shadow-lg shadow-red-500/30">
                            <i class="bi bi-trash mr-1"></i> Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // DELETE MODAL
    const deleteModal = document.getElementById('delete-modal');
    const deleteForm = document.getElementById('delete-form');
    const deleteCategoryName = document.getElementById('delete-category-name');

    function confirmDelete(categoryId, categoryName) {
        deleteForm.action = `/admin/categories/${categoryId}`;
        deleteCategoryName.textContent = categoryName;
        deleteModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    });
</script>
@endpush
