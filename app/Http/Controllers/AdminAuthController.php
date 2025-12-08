<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // cuma cek berdasarkan email
        $admin = Admin::where('email', $credentials['email'])->first();

        if (! $admin || ! Hash::check($credentials['password'], $admin->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau password tidak sesuai.');
        }

        $request->session()->put('admin_id', $admin->id);
        $request->session()->put('admin_name', $admin->name);
        $request->session()->put('admin_role', $admin->role);

        return redirect()->route('admin.dashboard');
    }
    public function logout(Request $request)
    {
        // hapus session khusus admin
        $request->session()->forget(['admin_id', 'admin_name', 'admin_role']);

        return redirect()
            ->route('admin.login')
            ->with('error', 'Anda telah logout dari akun admin.');
    }
}
