<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Nextzly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Chart.js (optional, load hanya jika dibutuhkan) --}}
    @stack('styles')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        * { font-family: "Montserrat", sans-serif; }

        /* Sidebar Animation */
        #admin-sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, width 0.3s ease;
        }
        #admin-sidebar.sidebar-hidden {
            transform: translateX(-100%);
            opacity: 0;
            width: 0;
            padding: 0;
            overflow: hidden;
        }

        /* Alert Animation */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
        .animate-slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }
        .animate-slide-out {
            animation: slideOut 0.3s ease-in forwards;
        }

        /* Modal Animation */
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes backdropIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-modal-in {
            animation: modalIn 0.2s ease-out forwards;
        }
        .animate-backdrop-in {
            animation: backdropIn 0.2s ease-out forwards;
        }

        /* Dynamic Island */
        .dynamic-island {
            --island-bg: rgba(15, 23, 42, 0.95);
            --island-border: rgba(255, 255, 255, 0.1);
            --glow-color: rgba(16, 185, 129, 0.4);
            background: var(--island-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--island-border);
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.05), 0 10px 40px -10px rgba(0, 0, 0, 0.5), 0 0 60px -20px var(--glow-color);
        }
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-ring {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
            50% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
        }
        .island-enter {
            animation: islandEnter 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        .island-exit {
            animation: islandExit 0.4s cubic-bezier(0.4, 0, 1, 1) forwards;
        }
        @keyframes islandEnter {
            0% { opacity: 0; transform: translateX(-50%) scale(0.8); filter: blur(10px); }
            100% { opacity: 1; transform: translateX(-50%) scale(1); filter: blur(0); }
        }
        @keyframes islandExit {
            0% { opacity: 1; transform: translateX(-50%) scale(1); filter: blur(0); }
            100% { opacity: 0; transform: translateX(-50%) scale(0.9); filter: blur(10px); }
        }
        .icon-bounce {
            animation: iconBounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes iconBounce {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen flex flex-col">

        {{-- NAVBAR --}}
        @include('partials.admin.navbar')

        <div class="flex flex-1 relative">
            {{-- SIDEBAR --}}
            @include('partials.admin.sidebar')

            {{-- Sidebar Overlay Mobile --}}
            <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

            {{-- MAIN CONTENT --}}
            <main class="flex-1 p-4 md:p-8 overflow-y-auto md:ml-64">

                {{-- ALERT MESSAGES --}}
                @if(session('success'))
                <div id="alert-success" class="mb-6 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center justify-between gap-3 animate-slide-in">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="closeAlert('alert-success')" class="text-emerald-500 hover:text-emerald-700 transition-colors">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div id="alert-error" class="mb-6 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center justify-between gap-3 animate-slide-in">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="closeAlert('alert-error')" class="text-red-500 hover:text-red-700 transition-colors">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                @endif

                {{-- PAGE CONTENT --}}
                @yield('content')

            </main>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // =====================
        // SIDEBAR TOGGLE
        // =====================
        const sidebar = document.getElementById('admin-sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const toggleIcon = document.getElementById('toggle-icon');
        const mainContent = document.querySelector('main');
        let sidebarOpen = true;

        function toggleSidebar() {
            sidebarOpen = !sidebarOpen;
            if (sidebarOpen) {
                sidebar.classList.remove('sidebar-hidden', '-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                toggleIcon.classList.replace('bi-layout-sidebar-inset', 'bi-list');
                mainContent.classList.add('md:ml-64');
            } else {
                sidebar.classList.add('sidebar-hidden', '-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                toggleIcon.classList.replace('bi-list', 'bi-layout-sidebar-inset');
                mainContent.classList.remove('md:ml-64');
            }
        }

        if (window.innerWidth < 768) {
            sidebarOpen = false;
            sidebar.classList.add('-translate-x-full');
            mainContent.classList.remove('md:ml-64');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // =====================
        // PROFILE DROPDOWN
        // =====================
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

        if (profileToggle) {
            profileToggle.addEventListener('click', toggleProfileMenu);
            document.addEventListener('click', function(e) {
                if (!profileToggle.contains(e.target) && !profileMenu.contains(e.target)) {
                    if (profileOpen) toggleProfileMenu();
                }
            });
        }

        // =====================
        // DYNAMIC ISLAND
        // =====================
        const island = document.getElementById('dynamic-island');

        function showIsland() {
            if (island) {
                island.classList.remove('opacity-0', 'invisible', 'scale-90');
                island.classList.add('opacity-100', 'visible', 'scale-100', 'island-enter');
            }
        }

        function hideIsland() {
            if (island) {
                island.classList.remove('island-enter');
                island.classList.add('island-exit');
                setTimeout(() => {
                    island.classList.add('opacity-0', 'invisible', 'scale-90');
                    island.classList.remove('opacity-100', 'visible', 'scale-100', 'island-exit');
                }, 400);
            }
        }

        // =====================
        // ALERT AUTO DISMISS
        // =====================
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.remove('animate-slide-in');
                alert.classList.add('animate-slide-out');
                setTimeout(() => alert.remove(), 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Auto dismiss alerts after 4 seconds
            const alerts = document.querySelectorAll('[id^="alert-"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert && document.body.contains(alert)) {
                        alert.classList.remove('animate-slide-in');
                        alert.classList.add('animate-slide-out');
                        setTimeout(() => {
                            if (alert && document.body.contains(alert)) {
                                alert.remove();
                            }
                        }, 300);
                    }
                }, 4000);
            });

            // Show dynamic island on dashboard
            @if(Request::routeIs('admin.dashboard'))
            setTimeout(showIsland, 500);
            setTimeout(hideIsland, 4500);
            @endif
        });

        // =====================
        // KEYBOARD SHORTCUTS
        // =====================
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (profileOpen) toggleProfileMenu();
                if (!sidebarOpen && window.innerWidth < 768) toggleSidebar();
            }
            if (e.ctrlKey && e.key === 'b') {
                e.preventDefault();
                toggleSidebar();
            }
        });
    </script>

    {{-- Additional Scripts --}}
    @stack('scripts')
</body>
</html>
