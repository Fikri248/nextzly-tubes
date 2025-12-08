<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // cek apakah session admin_id ada
        if (! $request->session()->has('admin_id')) {
            // kalau belum login, balikin ke halaman login admin
            return redirect()
                ->route('admin.login')
                ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        return $next($request);
    }
}
