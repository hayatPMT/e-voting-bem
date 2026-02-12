<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasAuthController extends Controller
{
    /**
     * Show petugas login form
     */
    public function showLoginForm()
    {
        return view('petugas.login');
    }

    /**
     * Handle petugas login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if user is petugas
            if (! $user->isPetugas()) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Anda tidak memiliki akses sebagai petugas daftar hadir.',
                ])->withInput();
            }

            // Check if user is active
            if (! $user->isActive()) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif.',
                ])->withInput();
            }

            $request->session()->regenerate();
            $user->updateLastLogin();

            return redirect()->intended(route('petugas.attendance.index'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    /**
     * Handle petugas logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
