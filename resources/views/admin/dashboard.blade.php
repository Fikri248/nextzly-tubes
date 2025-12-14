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

        /* ===== SIDEBAR TOGGLE ANIMATION ===== */
        #admin-sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                        opacity 0.3s ease,
                        width 0.3s ease;
        }

        #admin-sidebar.sidebar-hidden {
            transform: translateX(-100%);
            opacity: 0;
            width: 0;
            padding: 0;
            overflow: hidden;
        }

        /* ===== DYNAMIC ISLAND STYLES ===== */
        .dynamic-island {
            --island-bg: rgba(15, 23, 42, 0.95);
            --island-border: rgba(255, 255, 255, 0.1);
            --glow-color: rgba(16, 185, 129, 0.4);

            background: var(--island-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--island-border);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.05),
                0 10px 40px -10px rgba(0, 0, 0, 0.5),
                0 0 60px -20px var(--glow-color);
        }

        .dynamic-island::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            padding: 1px;
            background: linear-gradient(
                135deg,
                rgba(255, 255, 255, 0.15),
                rgba(255, 255, 255, 0.05),
                transparent
            );
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Pulse ring animation */
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse-ring {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
            }
        }

        /* Island entrance animation */
        .island-enter {
            animation: islandEnter 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .island-exit {
            animation: islandExit 0.4s cubic-bezier(0.4, 0, 1, 1) forwards;
        }

        @keyframes islandEnter {
            0% {
                opacity: 0;
                transform: translateX(-50%) scale(0.8);
                filter: blur(10px);
            }
            100% {
                opacity: 1;
                transform: translateX(-50%) scale(1);
                filter: blur(0);
            }
        }

        @keyframes islandExit {
            0% {
                opacity: 1;
                transform: translateX(-50%) scale(1);
                filter: blur(0);
            }
            100% {
                opacity: 0;
                transform: translateX(-50%) scale(0.9);
                filter: blur(10px);
            }
        }

        /* Icon bounce */
        .icon-bounce {
            animation: iconBounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes iconBounce {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">

    <div class="min-h-screen flex flex-col">

        {{-- NAVBAR ATAS - z-index lebih tinggi dari sidebar --}}
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8 sticky top-0 z-50">
            <div class="flex items-center gap-3">
                {{-- Tombol Toggle Sidebar --}}
                <button type="button" id="sidebar-toggle"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200
                           text-slate-600 hover:bg-slate-100 hover:border-slate-300
                           active:scale-95 transition-all duration-200">
                    <i class="bi bi-list text-xl" id="toggle-icon"></i>
                </button>

                <div>
                    <h1 class="text-base md:text-lg font-semibold">
                        Dashboard Admin
                    </h1>
                    <p class="text-xs text-slate-500 hidden sm:block">
                        Ringkasan penjualan dan data akun digital Nextzly.
                    </p>
                </div>
            </div>

            {{-- DYNAMIC ISLAND - Di Tengah Navbar --}}
            <div id="dynamic-island"
                class="dynamic-island absolute left-1/2 -translate-x-1/2 z-50
                       px-5 py-2 rounded-full
                       flex items-center gap-3
                       opacity-0 invisible scale-90 transition-all duration-500">

                {{-- Icon Container --}}
                <div class="relative">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600
                                flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <i class="bi bi-check-lg text-white text-sm icon-bounce"></i>
                    </div>
                    {{-- Pulse Ring --}}
                    <div class="absolute inset-0 rounded-full bg-emerald-500/30 pulse-ring"></div>
                </div>

                {{-- Text Content --}}
                <div>
                    <p class="text-[10px] text-slate-400 uppercase tracking-wider leading-none mb-0.5">Welcome back</p>
                    <p class="text-xs font-semibold text-white leading-none">
                        {{ session('admin_name') ?? 'Admin' }}
                        <span class="inline-block ml-0.5">👋</span>
                    </p>
                </div>
            </div>

            {{-- AREA PROFIL + STATUS --}}
            <div class="relative flex items-center gap-3 text-xs md:text-sm">
                {{-- Badge Online --}}
                <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-medium border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Online
                </span>

                {{-- Profil Admin + Dropdown --}}
                <div class="relative">
                    <button type="button" id="profile-toggle"
                        class="flex items-center gap-2 rounded-xl px-3 py-2 hover:bg-slate-100 transition-colors">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center">
                            <i class="bi bi-person-fill text-white text-sm"></i>
                        </div>
                        <div class="hidden sm:flex flex-col items-start">
                            <span class="text-[10px] text-slate-400 uppercase tracking-wide">Logged in as</span>
                            <span class="text-xs font-semibold text-slate-800">
                                {{ session('admin_name') ?? 'Admin Nextzly' }}
                            </span>
                        </div>
                        <i class="bi bi-chevron-down text-slate-400 text-xs transition-transform duration-200" id="profile-chevron"></i>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div id="profile-menu"
                        class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl
                               opacity-0 invisible translate-y-2 transition-all duration-200 z-50">
                        <div class="p-2">
                            <div class="px-3 py-2 border-b border-slate-100 mb-2">
                                <p class="text-xs text-slate-500">Signed in as</p>
                                <p class="text-sm font-semibold text-slate-800 truncate">
                                    {{ session('admin_name') ?? 'Admin Nextzly' }}
                                </p>
                            </div>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs
                                           bg-red-500 hover:bg-red-600 text-white font-semibold
                                           transition-colors duration-200">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1 relative">

            {{-- SIDEBAR - Fixed tapi mulai dari bawah navbar --}}
            <aside id="admin-sidebar"
                class="fixed top-16 left-0 z-40 w-64 h-[calc(100vh-64px)] bg-slate-950 text-slate-100
                       md:translate-x-0 flex flex-col overflow-hidden">

                {{-- Logo Area (Mobile) --}}
                <div class="md:hidden px-4 py-4 border-b border-slate-800">
                    <span class="text-lg font-bold text-white">Nextzly</span>
                    <span class="text-xs text-slate-500 ml-2">Admin</span>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-1 text-sm overflow-y-auto">
                    <div class="text-[10px] uppercase tracking-[.2em] text-slate-500 mb-3 px-3">
                        Main Menu
                    </div>

                    {{-- Dashboard (active) --}}
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-slate-800/80 text-emerald-400
                               hover:bg-slate-800 transition-all duration-200 group">
                        <span class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400
                                     group-hover:bg-emerald-500/30 transition-colors">
                            <i class="bi bi-grid-1x2-fill text-sm"></i>
                        </span>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    {{-- Data Produk --}}
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400
                               hover:bg-slate-800/50 hover:text-slate-200 transition-all duration-200 group">
                        <span class="w-8 h-8 rounded-lg bg-slate-800/50 flex items-center justify-center
                                     group-hover:bg-slate-800 transition-colors">
                            <i class="bi bi-box-seam text-sm"></i>
                        </span>
                        <span class="font-medium">Data Produk</span>
                    </a>

                    {{-- Transaksi --}}
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400
                               hover:bg-slate-800/50 hover:text-slate-200 transition-all duration-200 group">
                        <span class="w-8 h-8 rounded-lg bg-slate-800/50 flex items-center justify-center
                                     group-hover:bg-slate-800 transition-colors">
                            <i class="bi bi-receipt text-sm"></i>
                        </span>
                        <span class="font-medium">Transaksi</span>
                    </a>

                    {{-- Laporan --}}
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400
                               hover:bg-slate-800/50 hover:text-slate-200 transition-all duration-200 group">
                        <span class="w-8 h-8 rounded-lg bg-slate-800/50 flex items-center justify-center
                                     group-hover:bg-slate-800 transition-colors">
                            <i class="bi bi-bar-chart-line text-sm"></i>
                        </span>
                        <span class="font-medium">Laporan</span>
                    </a>

                    {{-- Data Pelanggan --}}
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400
                               hover:bg-slate-800/50 hover:text-slate-200 transition-all duration-200 group">
                        <span class="w-8 h-8 rounded-lg bg-slate-800/50 flex items-center justify-center
                                     group-hover:bg-slate-800 transition-colors">
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

            {{-- Sidebar Overlay (Mobile) --}}
            <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

            {{-- MAIN CONTENT - dengan margin left untuk sidebar --}}
            <main class="flex-1 p-4 md:p-8 overflow-y-auto md:ml-64">

                {{-- GRID 4 SUMMARY CARDS --}}
                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

                    {{-- Card 1: Total Akun Tersedia --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
                        <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600 text-xl">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Total Akun Tersedia</p>
                            <p class="text-xl font-bold text-slate-800">
                                {{ number_format($totalAkunTersedia, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Card 2: Total Akun Terjual --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Total Akun Terjual</p>
                            <p class="text-xl font-bold text-slate-800">
                                {{ number_format($totalAkunTerjual, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Card 3: Total Semua Aplikasi --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
                        <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center text-violet-600 text-xl">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Total Semua Aplikasi</p>
                            <p class="text-xl font-bold text-slate-800">
                                {{ number_format($totalAplikasi, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Card 4: Total Pendapatan + Pajak --}}
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 text-xl">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Pendapatan + Pajak (11%)</p>
                            <p class="text-xl font-bold text-slate-800">
                                Rp {{ number_format($pendapatanDenganPajak, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                </section>

                {{-- DETAIL PENDAPATAN --}}
                <section class="bg-white rounded-2xl border border-slate-200 p-6 mb-8 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="bi bi-calculator text-slate-400"></i>
                        Rincian Pendapatan
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-xs text-slate-500 mb-1">Pendapatan Bersih</p>
                            <p class="text-lg font-bold text-slate-800">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                            <p class="text-xs text-slate-500 mb-1">Pajak (11%)</p>
                            <p class="text-lg font-bold text-red-500">
                                Rp {{ number_format($pajak, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                            <p class="text-xs text-slate-500 mb-1">Total Keseluruhan</p>
                            <p class="text-lg font-bold text-emerald-600">
                                Rp {{ number_format($pendapatanDenganPajak, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </section>

                {{-- PLACEHOLDER CHART --}}
                <section class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                        <i class="bi bi-bar-chart-fill text-slate-400"></i>
                        Statistik Penjualan per Aplikasi
                    </h2>

                    <div class="h-64 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 border border-slate-100">
                        <div class="text-center">
                            <i class="bi bi-bar-chart text-4xl mb-2"></i>
                            <p class="text-sm">Grafik akan ditampilkan di sini</p>
                            <p class="text-xs text-slate-400">(Task 2.3)</p>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // ===== SIDEBAR TOGGLE =====
        const sidebar = document.getElementById('admin-sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const toggleIcon = document.getElementById('toggle-icon');
        const mainContent = document.querySelector('main');

        let sidebarOpen = true;

        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;

            if (sidebarOpen) {
                // Show sidebar
                sidebar.classList.remove('sidebar-hidden');
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                toggleIcon.classList.remove('bi-layout-sidebar-inset');
                toggleIcon.classList.add('bi-list');
                // Tambah margin ke main content
                mainContent.classList.add('md:ml-64');
            } else {
                // Hide sidebar
                sidebar.classList.add('sidebar-hidden');
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                toggleIcon.classList.remove('bi-list');
                toggleIcon.classList.add('bi-layout-sidebar-inset');
                // Hapus margin dari main content
                mainContent.classList.remove('md:ml-64');
            }
        }

        // Mobile: Start with sidebar hidden
        if (window.innerWidth < 768) {
            sidebarOpen = false;
            sidebar.classList.add('-translate-x-full');
            mainContent.classList.remove('md:ml-64');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // ===== PROFILE DROPDOWN =====
        const profileToggle = document.getElementById('profile-toggle');
        const profileMenu = document.getElementById('profile-menu');
        const profileChevron = document.getElementById('profile-chevron');
        let profileOpen = false;

        function toggleProfileMenu() {
            profileOpen = !profileOpen;

            if (profileOpen) {
                profileMenu.classList.remove('opacity-0', 'invisible', 'translate-y-2');
                profileMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                profileChevron.style.transform = 'rotate(180deg)';
            } else {
                profileMenu.classList.add('opacity-0', 'invisible', 'translate-y-2');
                profileMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                profileChevron.style.transform = 'rotate(0deg)';
            }
        }

        profileToggle.addEventListener('click', toggleProfileMenu);

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileToggle.contains(e.target) && !profileMenu.contains(e.target)) {
                if (profileOpen) {
                    toggleProfileMenu();
                }
            }
        });

        // ===== DYNAMIC ISLAND =====
        const island = document.getElementById('dynamic-island');

        function showIsland() {
            island.classList.remove('opacity-0', 'invisible', 'scale-90');
            island.classList.add('opacity-100', 'visible', 'scale-100', 'island-enter');
        }

        function hideIsland() {
            island.classList.remove('island-enter');
            island.classList.add('island-exit');

            setTimeout(() => {
                island.classList.add('opacity-0', 'invisible', 'scale-90');
                island.classList.remove('opacity-100', 'visible', 'scale-100', 'island-exit');
            }, 400);
        }

        // Show island on page load
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(showIsland, 500);

            // Auto hide after 4 seconds
            setTimeout(hideIsland, 4500);
        });

        // ===== KEYBOARD SHORTCUTS =====
        document.addEventListener('keydown', function(e) {
            // ESC to close dropdown/sidebar
            if (e.key === 'Escape') {
                if (profileOpen) toggleProfileMenu();
                if (!sidebarOpen && window.innerWidth < 768) toggleSidebar();
            }
            // Ctrl+B to toggle sidebar
            if (e.ctrlKey && e.key === 'b') {
                e.preventDefault();
                toggleSidebar();
            }
        });
    </script>

</body>

</html>
