<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8 sticky top-0 z-50">
    <div class="flex items-center gap-3">
        {{-- Toggle Sidebar Button --}}
        <button type="button" id="sidebar-toggle"
            class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 hover:border-slate-300 active:scale-95 transition-all duration-200">
            <i class="bi bi-list text-xl" id="toggle-icon"></i>
        </button>

        <div>
            <h1 class="text-base md:text-lg font-semibold">@yield('page-title', 'Dashboard Admin')</h1>
            <p class="text-xs text-slate-500 hidden sm:block">@yield('page-description', 'Panel administrasi Nextzly')</p>
        </div>
    </div>

    {{-- DYNAMIC ISLAND - Di Tengah Navbar (hanya di dashboard) --}}
    @if(Request::routeIs('admin.dashboard'))
    <div id="dynamic-island"
        class="dynamic-island absolute left-1/2 -translate-x-1/2 z-50 px-5 py-2 rounded-full flex items-center gap-3 opacity-0 invisible scale-90 transition-all duration-500">
        <div class="relative">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                <i class="bi bi-check-lg text-white text-sm icon-bounce"></i>
            </div>
            <div class="absolute inset-0 rounded-full bg-emerald-500/30 pulse-ring"></div>
        </div>
        <div>
            <p class="text-[10px] text-slate-400 uppercase tracking-wider leading-none mb-0.5">Welcome back</p>
            <p class="text-xs font-semibold text-white leading-none">
                {{ session('admin_name') ?? 'Admin' }}
                <span class="inline-block ml-0.5">👋</span>
            </p>
        </div>
    </div>
    @endif

    {{-- PROFILE & STATUS --}}
    <div class="relative flex items-center gap-3 text-xs md:text-sm">
        {{-- Badge Online --}}
        <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-medium border border-emerald-200">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Online
        </span>

        {{-- Profile Dropdown --}}
        <div class="relative">
            <button type="button" id="profile-toggle"
                class="flex items-center gap-2 rounded-xl px-3 py-2 hover:bg-slate-100 transition-colors">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center">
                    <i class="bi bi-person-fill text-white text-sm"></i>
                </div>
                <div class="hidden sm:flex flex-col items-start">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wide">Logged in as</span>
                    <span class="text-xs font-semibold text-slate-800">{{ session('admin_name') ?? 'Admin Nextzly' }}</span>
                </div>
                <i class="bi bi-chevron-down text-slate-400 text-xs transition-transform duration-200" id="profile-chevron"></i>
            </button>

            {{-- Dropdown Menu --}}
            <div id="profile-menu"
                class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl opacity-0 invisible translate-y-2 transition-all duration-200 z-50">
                <div class="p-2">
                    <div class="px-3 py-2 border-b border-slate-100 mb-2">
                        <p class="text-xs text-slate-500">Signed in as</p>
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ session('admin_name') ?? 'Admin Nextzly' }}</p>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs bg-red-500 hover:bg-red-600 text-white font-semibold transition-colors duration-200">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
