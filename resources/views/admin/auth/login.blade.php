<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Nextzly</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        * {
            font-family: "Montserrat", sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 flex items-center justify-center px-4">

    {{-- KARTU LOGIN --}}
    <div class="w-full max-w-md bg-slate-900/80 border border-slate-700 rounded-3xl shadow-2xl p-8">
        {{-- LOGO / TITLE --}}
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-white tracking-wide">
                Nextzly Login
            </h1>
            <p class="text-sm text-slate-300 mt-1">
                Silakan login untuk mengelola akun digital Nextzly.
            </p>
        </div>

        {{-- PESAN ERROR--}}
        @if (session('error'))
            <div class="mb-4 text-sm text-red-300 bg-red-900/40 border border-red-700 rounded-xl px-4 py-2">
                {{ session('error') }}
            </div>
        @endif

        {{-- FORM LOGIN --}}
        <form
            method="POST"
            action="#"
            class="space-y-4"
        >
            @csrf

            {{-- EMAIL / USERNAME --}}
            <div>
                <label for="email" class="block text-sm font-medium text-slate-200 mb-1">
                    Email
                </label>
                <input
                    type="text"
                    id="email"
                    name="email"
                    class="w-full rounded-2xl bg-slate-800 border border-slate-600 text-slate-100 text-sm px-3 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400"
                    placeholder="admin@nextzly.com"
                    required
                >
            </div>

            {{-- PASSWORD --}}
            <div>
                <label for="password" class="block text-sm font-medium text-slate-200 mb-1">
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full rounded-2xl bg-slate-800 border border-slate-600 text-slate-100 text-sm px-3 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400"
                    placeholder="Masukkan password admin"
                    required
                >
            </div>

            {{-- REMEMBER ME --}}
            <div class="flex items-center justify-between text-xs text-slate-300">
                <label class="inline-flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded border-slate-500 bg-slate-800 text-emerald-400
                               focus:ring-emerald-400 focus:ring-offset-0"
                    >
                    <span>Ingat saya sebagai admin</span>
                </label>
            </div>

            {{-- TOMBOL LOGIN --}}
            <button
                type="submit"
                class="w-full mt-2 inline-flex items-center justify-center rounded-2xl bg-emerald-500
                       hover:bg-emerald-400 text-slate-950 font-semibold text-sm py-2.5
                       transition-all duration-150 shadow-lg shadow-emerald-500/30"
            >
                Login Admin
            </button>
        </form>

        {{-- FOOTER KECIL --}}
        <p class="mt-6 text-[11px] text-center text-slate-500">
            Hanya untuk administrator Nextzly. Akses halaman ini tidak dibuka untuk pelanggan.
        </p>
    </div>
</body>
</html>
