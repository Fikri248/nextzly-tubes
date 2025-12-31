@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    {{-- BREADCRUMB --}}
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
        <a href="{{ route('admin.products.index') }}" class="hover:text-slate-700">Produk</a>
        <i class="bi bi-chevron-right text-xs"></i>
        <span class="text-slate-700 font-medium">Tambah Baru</span>
    </div>

    {{-- FORM --}}
    <div class="w-full">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- INFORMASI DASAR --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h2 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-box-seam text-emerald-500"></i>
                        Informasi Dasar
                    </h2>
                </div>

                <div class="p-6 space-y-5">
                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm @error('nama_produk') border-red-300 bg-red-50 @enderror"
                            placeholder="Contoh: Netflix Premium" autofocus>
                        @error('nama_produk')
                        <p class="mt-1.5 text-xs text-red-500"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori & Tipe Akun --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Kategori (Alpine Dropdown) --}}
                        @php
                            $oldCategoryId = old('category_id', '');
                            $oldCategoryName = $oldCategoryId ? ($categories->firstWhere('id', $oldCategoryId)?->nama_kategori ?? '') : '';
                        @endphp
                        <div x-data="{
                            open: false,
                            selected: '{{ $oldCategoryId }}',
                            selectedText: '{{ $oldCategoryName }}'
                        }">
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm bg-white flex items-center justify-between @error('category_id') border-red-300 bg-red-50 @enderror">
                                    <span :class="selected ? 'text-slate-800' : 'text-slate-400'" x-text="selectedText || 'Pilih Kategori'"></span>
                                    <i class="bi bi-chevron-down text-slate-400 transition-transform duration-200" :class="open && 'rotate-180'"></i>
                                </button>
                                <input type="hidden" name="category_id" x-model="selected">

                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="absolute z-50 w-full mt-2 bg-white rounded-xl border border-slate-200 shadow-xl overflow-hidden">
                                    <div class="max-h-60 overflow-y-auto py-2">
                                        @foreach($categories as $category)
                                        <button type="button"
                                            @click="selected = '{{ $category->id }}'; selectedText = '{{ $category->nama_kategori }}'; open = false"
                                            class="w-full px-4 py-2.5 text-left text-sm hover:bg-emerald-50 flex items-center gap-3 transition-colors"
                                            :class="selected == '{{ $category->id }}' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600'">
                                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-xs"
                                                :class="selected == '{{ $category->id }}' ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500'">
                                                <i class="bi bi-folder-fill"></i>
                                            </span>
                                            <span class="font-medium">{{ $category->nama_kategori }}</span>
                                            <i class="bi bi-check-lg ml-auto text-emerald-600" x-show="selected == '{{ $category->id }}'"></i>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @error('category_id')
                            <p class="mt-1.5 text-xs text-red-500"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tipe Akun (Dropdown) --}}
                        @php $oldTipeAkun = old('tipe_akun', ''); @endphp
                        <div x-data="{
                            open: false,
                            selected: '{{ $oldTipeAkun }}',
                            options: [
                                { value: 'private', label: 'Private', desc: 'Akun pribadi full akses' },
                                { value: 'sharing', label: 'Sharing', desc: 'Berbagi dengan user lain' },
                                { value: 'invite_email', label: 'Invite Email', desc: 'Perlu undangan via email' },
                                { value: 'family', label: 'Family', desc: 'Paket keluarga multi-user' }
                            ]
                        }">
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Tipe Akun <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm bg-white flex items-center justify-between @error('tipe_akun') border-red-300 bg-red-50 @enderror">
                                    <span :class="selected ? 'text-slate-800' : 'text-slate-400'" x-text="selected ? options.find(o => o.value === selected)?.label : 'Pilih Tipe Akun'"></span>
                                    <i class="bi bi-chevron-down text-slate-400 transition-transform duration-200" :class="open && 'rotate-180'"></i>
                                </button>
                                <input type="hidden" name="tipe_akun" x-model="selected">

                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="absolute z-50 w-full mt-2 bg-white rounded-xl border border-slate-200 shadow-xl overflow-hidden">
                                    <div class="py-2">
                                        <template x-for="opt in options" :key="opt.value">
                                            <button type="button"
                                                @click="selected = opt.value; open = false"
                                                class="w-full px-4 py-2.5 text-left text-sm hover:bg-emerald-50 flex items-center gap-3 transition-colors"
                                                :class="selected === opt.value ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600'">
                                                <span class="w-8 h-8 rounded-lg flex items-center justify-center text-xs"
                                                    :class="selected === opt.value ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-500'">
                                                    <i class="bi bi-person-badge"></i>
                                                </span>
                                                <div class="flex-1">
                                                    <span class="font-medium block" x-text="opt.label"></span>
                                                    <span class="text-xs text-slate-400" x-text="opt.desc"></span>
                                                </div>
                                                <i class="bi bi-check-lg text-emerald-600" x-show="selected === opt.value"></i>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            @error('tipe_akun')
                            <p class="mt-1.5 text-xs text-red-500"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Platform (Multi-Select Checklist) --}}
                    @php
                        $oldPlatform = old('platform', []);
                        if (is_string($oldPlatform)) $oldPlatform = explode(',', $oldPlatform);
                    @endphp
                    <div x-data="{
                        open: false,
                        selected: {{ json_encode($oldPlatform) }},
                        platforms: [
                            { value: 'Web', icon: 'bi-globe' },
                            { value: 'Android', icon: 'bi-android2' },
                            { value: 'iOS', icon: 'bi-apple' },
                            { value: 'Windows', icon: 'bi-windows' },
                            { value: 'MacOS', icon: 'bi-laptop' },
                            { value: 'Smart TV', icon: 'bi-tv' },
                            { value: 'PlayStation', icon: 'bi-controller' },
                            { value: 'Xbox', icon: 'bi-xbox' }
                        ],
                        toggle(val) {
                            if (this.selected.includes(val)) {
                                this.selected = this.selected.filter(v => v !== val);
                            } else {
                                this.selected.push(val);
                            }
                        }
                    }">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Platform <span class="text-slate-400 font-normal">(Pilih yang tersedia)</span>
                        </label>
                        <div class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm bg-white flex items-center justify-between">
                                <span :class="selected.length ? 'text-slate-800' : 'text-slate-400'" x-text="selected.length ? selected.join(', ') : 'Pilih Platform'"></span>
                                <i class="bi bi-chevron-down text-slate-400 transition-transform duration-200" :class="open && 'rotate-180'"></i>
                            </button>
                            <input type="hidden" name="platform" :value="selected.join(',')">

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute z-50 w-full mt-2 bg-white rounded-xl border border-slate-200 shadow-xl overflow-hidden">
                                <div class="p-3 grid grid-cols-2 gap-2 max-h-60 overflow-y-auto">
                                    <template x-for="p in platforms" :key="p.value">
                                        <label class="flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer transition-colors"
                                            :class="selected.includes(p.value) ? 'bg-emerald-50 border border-emerald-200' : 'bg-slate-50 border border-transparent hover:bg-slate-100'">
                                            <input type="checkbox" class="hidden" :checked="selected.includes(p.value)" @change="toggle(p.value)">
                                            <span class="w-5 h-5 rounded flex items-center justify-center text-xs transition-colors"
                                                :class="selected.includes(p.value) ? 'bg-emerald-500 text-white' : 'bg-white border border-slate-300'">
                                                <i class="bi bi-check" x-show="selected.includes(p.value)"></i>
                                            </span>
                                            <i :class="p.icon" class="text-slate-500"></i>
                                            <span class="text-sm font-medium" :class="selected.includes(p.value) ? 'text-emerald-700' : 'text-slate-600'" x-text="p.value"></span>
                                        </label>
                                    </template>
                                </div>
                                <div class="px-3 py-2 border-t border-slate-100 flex justify-end">
                                    <button type="button" @click="open = false" class="text-xs text-emerald-600 font-medium hover:text-emerald-700">Selesai</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm resize-none"
                            placeholder="Deskripsi singkat...">{{ old('deskripsi') }}</textarea>
                    </div>

                    {{-- Logo Upload --}}
                    <div x-data="{
                        preview: null,
                        fileName: '',
                        handleFile(e) {
                            const file = e.target.files[0];
                            if (file) {
                                this.fileName = file.name;
                                const reader = new FileReader();
                                reader.onload = (e) => this.preview = e.target.result;
                                reader.readAsDataURL(file);
                            }
                        },
                        removeFile() {
                            this.preview = null;
                            this.fileName = '';
                            this.$refs.fileInput.value = '';
                        }
                    }">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Logo Produk <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <div class="flex items-start gap-4">
                            {{-- Preview --}}
                            <div class="w-20 h-20 rounded-xl border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden bg-slate-50"
                                :class="preview && 'border-solid border-emerald-200'">
                                <template x-if="!preview">
                                    <i class="bi bi-image text-2xl text-slate-300"></i>
                                </template>
                                <template x-if="preview">
                                    <img :src="preview" class="w-full h-full object-cover">
                                </template>
                            </div>

                            {{-- Upload Area --}}
                            <div class="flex-1">
                                <label class="flex flex-col items-center justify-center px-4 py-4 rounded-xl border-2 border-dashed border-slate-200 hover:border-emerald-400 hover:bg-emerald-50/50 cursor-pointer transition-all">
                                    <input type="file" name="logo" accept="image/*" class="hidden" x-ref="fileInput" @change="handleFile($event)">
                                    <i class="bi bi-cloud-arrow-up text-2xl text-slate-400 mb-1"></i>
                                    <span class="text-sm text-slate-500" x-show="!fileName">Klik untuk upload logo</span>
                                    <span class="text-sm text-emerald-600 font-medium" x-show="fileName" x-text="fileName"></span>
                                    <span class="text-xs text-slate-400 mt-1">PNG, JPG, WEBP (Max 2MB)</span>
                                </label>
                                <button type="button" x-show="preview" @click="removeFile()"
                                    class="mt-2 text-xs text-red-500 hover:text-red-600 flex items-center gap-1">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                        @error('logo')
                        <p class="mt-1.5 text-xs text-red-500"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- HARGA & STOK --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                    <h2 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-currency-dollar text-emerald-500"></i>
                        Harga & Ketersediaan
                    </h2>
                </div>

                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        {{-- Harga --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Harga (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="harga" value="{{ old('harga') }}" min="0" step="1000"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm @error('harga') border-red-300 bg-red-50 @enderror"
                                placeholder="50000">
                            @error('harga')
                            <p class="mt-1.5 text-xs text-red-500"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Durasi --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Durasi (Hari) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="durasi" value="{{ old('durasi', 30) }}" min="0"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm @error('durasi') border-red-300 bg-red-50 @enderror"
                                placeholder="30">
                            @error('durasi')
                            <p class="mt-1.5 text-xs text-red-500"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Stok --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stok" value="{{ old('stok', 100) }}" min="0"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm @error('stok') border-red-300 bg-red-50 @enderror"
                                placeholder="100">
                            @error('stok')
                            <p class="mt-1.5 text-xs text-red-500"><i class="bi bi-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status (Dropdown) --}}
                    @php $oldStatus = old('status', 'tersedia'); @endphp
                    <div x-data="{ open: false, selected: '{{ $oldStatus }}' }">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all text-sm bg-white flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full" :class="selected === 'tersedia' ? 'bg-emerald-500' : 'bg-red-400'"></span>
                                    <span class="text-slate-800" x-text="selected === 'tersedia' ? 'Tersedia' : 'Habis'"></span>
                                </div>
                                <i class="bi bi-chevron-down text-slate-400 transition-transform duration-200" :class="open && 'rotate-180'"></i>
                            </button>
                            <input type="hidden" name="status" x-model="selected">

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute z-50 w-full mt-2 bg-white rounded-xl border border-slate-200 shadow-xl overflow-hidden">
                                <div class="py-2">
                                    <button type="button" @click="selected = 'tersedia'; open = false"
                                        class="w-full px-4 py-3 text-left text-sm hover:bg-emerald-50 flex items-center gap-3 transition-colors"
                                        :class="selected === 'tersedia' && 'bg-emerald-50'">
                                        <span class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </span>
                                        <div class="flex-1">
                                            <span class="font-medium text-slate-800 block">Tersedia</span>
                                            <span class="text-xs text-slate-400">Produk aktif dan bisa dibeli</span>
                                        </div>
                                        <i class="bi bi-check-lg text-emerald-600" x-show="selected === 'tersedia'"></i>
                                    </button>
                                    <button type="button" @click="selected = 'habis'; open = false"
                                        class="w-full px-4 py-3 text-left text-sm hover:bg-red-50 flex items-center gap-3 transition-colors"
                                        :class="selected === 'habis' && 'bg-red-50'">
                                        <span class="w-10 h-10 rounded-xl bg-red-100 text-red-500 flex items-center justify-center">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </span>
                                        <div class="flex-1">
                                            <span class="font-medium text-slate-800 block">Habis</span>
                                            <span class="text-xs text-slate-400">Stok kosong / tidak tersedia</span>
                                        </div>
                                        <i class="bi bi-check-lg text-red-500" x-show="selected === 'habis'"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SUBMIT --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                    <i class="bi bi-check-lg"></i> Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}"
                    class="px-6 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
