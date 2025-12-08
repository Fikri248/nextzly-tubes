<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Nextzly</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        * {
            font-family: "Montserrat", sans-serif;
        }
    </style>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">

    <div class="min-h-screen flex flex-col">

        {{-- NAVBAR ATAS --}}
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8">
            <div class="flex items-center gap-3">
                {{-- tombol toggle sidebar (mobile & desktop) --}}
                <button type="button" onclick="toggleSidebar()"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-300
                           text-slate-600 hover:bg-slate-100">
                    <i class="bi bi-list text-lg"></i>
                </button>

                <div>
                    <h1 class="text-base md:text-lg font-semibold">
                        Dashboard Admin
                    </h1>
                    <p class="text-xs text-slate-500">
                        Ringkasan penjualan dan data akun digital Nextzly.
                    </p>
                </div>
            </div>

            {{-- AREA PROFIL + STATUS --}}
            <div class="relative flex items-center gap-3 text-xs md:text-sm">
                {{-- badge online --}}
                <span
                    class="hidden sm:inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[11px]">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Online
                </span>

                {{-- profil admin + dropdown --}}
                <div class="relative">
                    <button type="button" onclick="toggleProfileMenu()"
                        class="flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-slate-100">
                        <div class="w-9 h-9 rounded-full bg-slate-200 flex items-center justify-center">
                            <i class="bi bi-person-circle text-slate-700 text-lg"></i>
                        </div>
                        <div class="hidden sm:flex flex-col items-start">
                            <span class="text-[11px] text-slate-500">Logged in as</span>
                            <span class="text-xs font-semibold text-slate-800">
                                {{ session('admin_name') ?? 'Admin Nextzly' }}
                            </span>
                        </div>
                        <i class="bi bi-chevron-down text-slate-500 text-xs"></i>
                    </button>

                    {{-- DROPDOWN MENU --}}
                    <div id="profile-menu"
                        class="hidden absolute right-0 mt-2 w-40 bg-white border border-slate-200 rounded-xl shadow-lg z-20">
                        <form action="{{ route('admin.logout') }}" method="POST" class="p-2">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center gap-2 px-3 py-2 rounded-lg text-xs
                                       bg-red-500 hover:bg-red-400 text-white font-semibold">
                                <i class="bi bi-box-arrow-right text-sm"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1">

            {{-- SIDEBAR (dark) --}}
            <aside id="admin-sidebar"
                class="relative hidden md:flex md:flex-col w-64 bg-slate-950 text-slate-100 border-r border-slate-900">
                <nav class="flex-1 px-4 py-6 space-y-1 text-sm">
                    <div class="text-[11px] uppercase tracking-[.18em] text-slate-500 mb-2">
                        Main Menu
                    </div>

                    {{-- Dashboard (active) --}}
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl bg-slate-900 text-emerald-300
                          hover:bg-slate-800 transition">
                        <span class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center text-base">
                            <i class="bi bi-speedometer2"></i>
                        </span>
                        <span>Dashboard</span>
                    </a>

                    {{-- Data Produk --}}
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-900 transition">
                        <span class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center text-base">
                            <i class="bi bi-bag-check"></i>
                        </span>
                        <span>Data Produk</span>
                    </a>

                    {{-- Transaksi --}}
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-900 transition">
                        <span class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center text-base">
                            <i class="bi bi-receipt"></i>
                        </span>
                        <span>Transaksi</span>
                    </a>

                    {{-- Laporan --}}
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-900 transition">
                        <span class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center text-base">
                            <i class="bi bi-graph-up-arrow"></i>
                        </span>
                        <span>Laporan</span>
                    </a>

                    {{-- Data Pelanggan --}}
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-900 transition">
                        <span class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center text-base">
                            <i class="bi bi-people"></i>
                        </span>
                        <span>Data Pelanggan</span>
                    </a>
                </nav>
            </aside>

            {{-- MAIN CONTENT (light) --}}
            <main class="flex-1 px-4 md:px-8 py-6 bg-slate-100">

                {{-- KARTU SUMMARY --}}
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    {{-- Total Akun Tersedia --}}
                    <div class="bg-white border border-slate-200 rounded-3xl p-4 flex flex-col gap-2 shadow-sm">
                        <span class="text-xs text-slate-500">Total Akun Tersedia</span>
                        <span class="text-2xl font-semibold text-emerald-500">
                            0
                        </span>
                        <span class="text-[11px] text-slate-500">
                            Berdasarkan stok produk aktif di database.
                        </span>
                    </div>

                    {{-- Total Akun Terjual --}}
                    <div class="bg-white border border-slate-200 rounded-3xl p-4 flex flex-col gap-2 shadow-sm">
                        <span class="text-xs text-slate-500">Total Akun Terjual</span>
                        <span class="text-2xl font-semibold text-sky-500">
                            0
                        </span>
                        <span class="text-[11px] text-slate-500">
                            Menghitung semua transaksi dengan status berhasil.
                        </span>
                    </div>

                    {{-- Total Aplikasi --}}
                    <div class="bg-white border border-slate-200 rounded-3xl p-4 flex flex-col gap-2 shadow-sm">
                        <span class="text-xs text-slate-500">Total Aplikasi</span>
                        <span class="text-2xl font-semibold text-amber-500">
                            0
                        </span>
                        <span class="text-[11px] text-slate-500">
                            Jumlah unik aplikasi digital yang terdaftar.
                        </span>
                    </div>

                    {{-- Total Pendapatan + Pajak --}}
                    <div class="bg-white border border-slate-200 rounded-3xl p-4 flex flex-col gap-2 shadow-sm">
                        <span class="text-xs text-slate-500">Total Pendapatan + Pajak</span>
                        <span class="text-2xl font-semibold text-fuchsia-500">
                            Rp 0
                        </span>
                        <span class="text-[11px] text-slate-500">
                            Nilai kumulatif dari transaksi berhasil (dummy).
                        </span>
                    </div>
                </div>

                {{-- ROW KEDUA --}}
                <div class="grid gap-4 lg:grid-cols-3 mt-6">
                    {{-- Grafik bar placeholder --}}
                    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl p-4 shadow-sm flex flex-col">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h2 class="text-sm font-semibold text-slate-800">
                                    Statistik Penjualan per Aplikasi
                                </h2>
                                <p class="text-[11px] text-slate-500">
                                    Placeholder grafik bar – akan diisi data dinamis pada task berikutnya.
                                </p>
                            </div>
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-slate-100 text-slate-500 text-[11px]">
                                <i class="bi bi-calendar2-week text-xs"></i>
                                Bulan ini
                            </span>
                        </div>

                        <div
                            class="flex-1 rounded-2xl border border-dashed border-slate-300 bg-slate-50
                                flex items-center justify-center text-xs text-slate-400 py-10">
                            Area grafik bar (Task 2.3)
                        </div>
                    </div>

                    {{-- Ringkasan singkat --}}
                    <div class="bg-white border border-slate-200 rounded-3xl p-4 shadow-sm flex flex-col">
                        <h2 class="text-sm font-semibold text-slate-800 mb-2">
                            Ringkasan Singkat
                        </h2>
                        <ul class="space-y-2 text-xs text-slate-600">
                            <li>• Layout Dashboard admin menggunakan sidebar dark dan konten utama light.</li>
                            <li>• Ikon menu menggunakan Bootstrap Icons.</li>
                            <li>• Sidebar dapat disembunyikan dengan tombol menu di navbar.</li>
                            <li>• Nav bar menampilkan nama admin yang sedang login dan menyediakan dropdown Logout.</li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');

            // cek apakah sekarang hidden (display: none) atau tidak
            const isHidden = window.getComputedStyle(sidebar).display === 'none';

            if (isHidden) {
                sidebar.style.display = 'flex';
            } else {
                sidebar.style.display = 'none';
            }
        }

        function toggleProfileMenu() {
            const menu = document.getElementById('profile-menu');
            menu.classList.toggle('hidden');
        }
    </script>

</body>
{{-- Dynamic Island --}}
@if (session('welcome'))
    <div id="welcome-popup" class="fixed inset-x-0 top-4 z-30 flex justify-center pointer-events-none">
        <div class="pointer-events-auto w-full max-w-md px-4">
            <div id="welcome-popup-inner"
                class="bg-slate-900 text-slate-50 rounded-full shadow-2xl
                        px-4 py-2.5 flex items-center gap-3
                        transform -translate-y-5 opacity-0 scale-95
                        transition-all duration-500 ease-out">
                <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
                    <i class="bi bi-check-circle-fill text-emerald-400 text-lg"></i>
                </div>

                <div class="flex-1">
                    <p class="text-sm font-semibold">
                        {{ session('welcome') }}
                    </p>
                    <p class="text-[11px] text-slate-300">
                        Anda berhasil login sebagai admin. Dashboard siap digunakan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inner = document.getElementById('welcome-popup-inner');
            const wrapper = document.getElementById('welcome-popup');

            if (!inner || !wrapper) return;

            requestAnimationFrame(() => {
                inner.classList.remove('-translate-y-5', 'opacity-0', 'scale-95');
                inner.classList.add('translate-y-0', 'opacity-100', 'scale-100');
            });

            setTimeout(() => {
                inner.classList.remove('translate-y-0', 'opacity-100', 'scale-100');
                inner.classList.add('-translate-y-5', 'opacity-0', 'scale-95');

                setTimeout(() => {
                    wrapper.classList.add('hidden');
                }, 500);
            }, 3500);
        });
    </script>
@endif

</html>
