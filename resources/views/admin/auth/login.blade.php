<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Nextzly</title>

    {{-- Tailwind CDN --}}
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

<body class="min-h-screen bg-slate-950 text-slate-50 flex items-center justify-center">

    <div class="w-full max-w-md px-4">
        {{-- KARTU LOGIN --}}
        <div class="bg-slate-900/80 border border-slate-700 rounded-3xl p-6 md:p-8 shadow-2xl backdrop-blur">

            {{-- BACK TO HOME --}}
            <a href="{{ route('homepage') }}"
                class="inline-flex items-center text-xs text-slate-400 hover:text-slate-200 mb-4">
                <i class="bi bi-arrow-left mr-1"></i>
                <span>Kembali ke Home</span>
            </a>

            {{-- HEADER --}}
            <h1 class="text-xl md:text-2xl font-semibold text-slate-50 mb-1">
                Login Admin
            </h1>
            <p class="text-xs text-slate-400 mb-5">
                Masuk untuk mengelola produk digital dan transaksi Nextzly.
            </p>

            {{-- ALERT DARI SESSION --}}
            @if (session('error'))
                <div
                    class="mb-4 rounded-2xl border border-red-500/40 bg-red-500/10 px-3 py-2.5 text-xs text-red-300 flex items-start gap-2">
                    <i class="bi bi-exclamation-circle-fill mt-[2px]"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- ERROR LOGIN KHUSUS --}}
            @if ($errors->has('login_error'))
                <div
                    class="mb-4 rounded-2xl border border-red-500/40 bg-red-500/10 px-3 py-2.5 text-xs text-red-300 flex items-start gap-2">
                    <i class="bi bi-exclamation-triangle-fill mt-[2px]"></i>
                    <span>{{ $errors->first('login_error') }}</span>
                </div>
            @endif

            {{-- ERROR VALIDASI FIELD --}}
            @if ($errors->any() && !$errors->has('login_error'))
                <div class="mb-4 rounded-2xl border border-red-500/40 bg-red-500/10 px-3 py-2.5 text-xs text-red-300">
                    <span>Periksa kembali data yang diinput.</span>
                </div>
            @endif

            {{-- FORM LOGIN --}}
            <form action="{{ route('admin.login.attempt') }}" method="POST" class="space-y-4">
                @csrf

                {{-- EMAIL --}}
                <div class="space-y-1">
                    <label for="email" class="text-xs font-medium text-slate-200">
                        Email Admin
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-500 text-sm">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-slate-900/70 border border-slate-700 rounded-2xl pl-9 pr-3 py-2.5
                               text-sm text-slate-50 placeholder:text-slate-500
                               focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    @error('email')
                        <p class="text-[11px] text-red-400 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div class="space-y-1">
                    <label for="password" class="text-xs font-medium text-slate-200">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-500 text-sm">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                            class="w-full bg-slate-900/70 border border-slate-700 rounded-2xl pl-9 pr-3 py-2.5
                               text-sm text-slate-50 placeholder:text-slate-500
                               focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    @error('password')
                        <p class="text-[11px] text-red-400 mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- REMEMBER ME (opsional) --}}
                <div class="flex items-center justify-between pt-1">
                    <label class="inline-flex items-center gap-2 text-[11px] text-slate-400">
                        <input type="checkbox" name="remember"
                            class="rounded border-slate-600 bg-slate-900/70 text-sky-500 focus:ring-sky-500">
                        <span>Ingat saya</span>
                    </label>
                </div>

                {{-- BUTTON SUBMIT --}}
                <button type="submit"
                    class="w-full mt-2 inline-flex items-center justify-center gap-2 rounded-2xl
                           bg-sky-500 hover:bg-sky-400 text-white text-sm font-semibold py-2.5
                           shadow-lg shadow-sky-500/30 transition">
                    <i class="bi bi-box-arrow-in-right text-sm"></i>
                    <span>Login sebagai Admin</span>
                </button>
            </form>

            {{-- FOOTNOTE KECIL --}}
            <p class="mt-4 text-[10px] text-slate-500 text-center">
                Akses ini khusus untuk administrator Nextzly.
            </p>
        </div>
    </div>

</body>

</html>
