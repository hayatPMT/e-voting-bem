<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Cek apakah ini Super Admin (Super Admin bisa login dari mana saja)
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user && $user->role === 'super_admin') {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended(route('superadmin.dashboard'));
            }
        }

        // 2. Cek apakah ini Admin Kampus
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Validasi Kampus untuk Admin
            $selectedKampusId = $request->input('kampus_id');

            // Jika dia Admin tapi masuk lewat portal kampus lain
            if ($user->role === 'admin' && $selectedKampusId && $user->kampus_id != $selectedKampusId) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $kampusTerdaftar = \App\Models\Kampus::find($user->kampus_id);

                return back()->with('error', 'Akun Admin Anda terdaftar di '.($kampusTerdaftar->nama ?? 'Kampus Lain').'. Silakan login melalui portal kampus yang benar.');
            }

            if ($user->role === 'admin') {
                return redirect()->intended('dashboard');
            }

            // Jika mahasiswa mencoba login di halaman admin
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('error', 'Login mahasiswa silahkan melalui menu Mahasiswa di halaman utama.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
