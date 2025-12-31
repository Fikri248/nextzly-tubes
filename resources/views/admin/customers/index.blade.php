@extends('layouts.admin')

@section('title', 'Daftar Pelanggan')
@section('page-title', 'Daftar Pelanggan')
@section('page-description', 'Kelola dan lihat data pelanggan.')

@section('content')
    {{-- HEADER + SEARCH + ADD BUTTON --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-800">Data Pelanggan</h2>
            <p class="text-xs text-slate-500">Total {{ $customers->total() }} pelanggan terdaftar</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            {{-- SEARCH FORM --}}
            <form action="{{ route('admin.customers.index') }}" method="GET" class="flex items-center gap-2">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Cari nama, email, telepon..."
                           class="w-full sm:w-64 pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
                <button type="submit"
                        class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium transition-all">
                    Cari
                </button>
                @if($search)
                <a href="{{ route('admin.customers.index') }}"
                   class="px-4 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium transition-all">
                    Reset
                </a>
                @endif
            </form>

            {{-- ADD BUTTON --}}
            <a href="{{ route('admin.customers.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-all shadow-lg shadow-emerald-500/30">
                <i class="bi bi-plus-lg"></i>
                Tambah Pelanggan
            </a>
        </div>
    </div>

    {{-- SEARCH RESULT INFO --}}
    @if($search)
    <div class="mb-4 px-4 py-3 rounded-xl bg-sky-50 border border-sky-100">
        <p class="text-sm text-sky-700">
            <i class="bi bi-search mr-1"></i>
            Hasil pencarian untuk "<strong>{{ $search }}</strong>"
            <span class="text-sky-500">({{ $customers->total() }} ditemukan)</span>
        </p>
    </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">#</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Nama Pelanggan</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Email</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Telepon</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-600">Transaksi</th>
                        <th class="px-6 py-4 text-left font-semibold text-slate-600">Bergabung</th>
                        <th class="px-6 py-4 text-center font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $index => $customer)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-500">
                            {{ $customers->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center text-emerald-600 font-semibold">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-slate-800">{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            @if($customer->email)
                                <a href="mailto:{{ $customer->email }}" class="hover:text-emerald-600 transition-colors flex items-center gap-1">
                                    <i class="bi bi-envelope text-xs"></i>
                                    {{ $customer->email }}
                                </a>
                            @else
                                <span class="text-slate-400 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->phone) }}"
                               target="_blank"
                               class="hover:text-emerald-600 transition-colors flex items-center gap-1">
                                <i class="bi bi-whatsapp text-xs"></i>
                                {{ $customer->phone }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full {{ $customer->transactions_count > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }} text-xs font-semibold">
                                {{ $customer->transactions_count }} transaksi
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            {{ $customer->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- View Transactions --}}
                                <a href="{{ route('admin.customers.transactions', $customer) }}"
                                    class="w-8 h-8 rounded-lg bg-sky-100 hover:bg-sky-200 text-sky-600 flex items-center justify-center transition-colors"
                                    title="Riwayat Transaksi">
                                    <i class="bi bi-receipt text-sm"></i>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('admin.customers.edit', $customer) }}"
                                    class="w-8 h-8 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-600 flex items-center justify-center transition-colors"
                                    title="Edit">
                                    <i class="bi bi-pencil text-sm"></i>
                                </a>
                                {{-- Delete --}}
                                <button type="button"
                                    onclick="confirmDelete({{ $customer->id }}, '{{ $customer->name }}', {{ $customer->transactions_count }})"
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
                                    <i class="bi bi-people text-2xl"></i>
                                </div>
                                @if($search)
                                    <p class="text-slate-500 font-medium">Tidak ada pelanggan ditemukan</p>
                                    <p class="text-slate-400 text-xs">Coba kata kunci lain</p>
                                    <a href="{{ route('admin.customers.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium mt-2">
                                        <i class="bi bi-arrow-left mr-1"></i> Lihat semua pelanggan
                                    </a>
                                @else
                                    <p class="text-slate-500 font-medium">Belum ada pelanggan</p>
                                    <a href="{{ route('admin.customers.create') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                        + Tambah pelanggan pertama
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $customers->links() }}
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
                        Apakah Anda yakin ingin menghapus pelanggan <strong id="delete-customer-name" class="text-slate-800"></strong>?
                    </p>
                    <p id="delete-warning" class="text-xs text-red-500 mt-2 hidden">
                        <i class="bi bi-exclamation-circle"></i> Pelanggan ini memiliki riwayat transaksi dan tidak dapat dihapus.
                    </p>
                    <p id="delete-info" class="text-xs text-slate-500 mt-2">
                        <i class="bi bi-info-circle"></i> Data pelanggan akan dihapus permanen.
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
                        <button type="submit" id="delete-btn"
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
    const deleteCustomerName = document.getElementById('delete-customer-name');
    const deleteWarning = document.getElementById('delete-warning');
    const deleteInfo = document.getElementById('delete-info');
    const deleteBtn = document.getElementById('delete-btn');

    function confirmDelete(customerId, customerName, transactionCount) {
        deleteForm.action = `/admin/customers/${customerId}`;
        deleteCustomerName.textContent = customerName;

        // Check if customer has transactions
        if (transactionCount > 0) {
            deleteWarning.classList.remove('hidden');
            deleteInfo.classList.add('hidden');
            deleteBtn.disabled = true;
            deleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
            deleteBtn.classList.remove('hover:bg-red-600');
        } else {
            deleteWarning.classList.add('hidden');
            deleteInfo.classList.remove('hidden');
            deleteBtn.disabled = false;
            deleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            deleteBtn.classList.add('hover:bg-red-600');
        }

        deleteModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    });
</script>
@endpush
