<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasAuthController extends Controller
{
    /**
     * Show petugas login form
     */
    public function showLoginForm(Request $request)
    {
        $kampusId = $request->query('kampus_id');

        if (! $kampusId) {
            return redirect()->route('landing');
        }

        $kampus = \App\Models\Kampus::find($kampusId);
        if (! $kampus) {
            return redirect()->route('landing')->with('error', 'Kampus tidak valid');
        }

        return view('petugas.login', [
            'kampus_id' => $kampusId,
            'kampus' => $kampus,
        ]);
    }

    /**
     * Handle petugas login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'kampus_id' => 'required|numeric',
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

            // Enforce kampus check
            if ($user->kampus_id != $request->kampus_id) {
                $kampusPilih = \App\Models\Kampus::find($request->kampus_id);
                $kampusAsli = \App\Models\Kampus::find($user->kampus_id);
                Auth::logout();

                return back()->withErrors([
                    'email' => "Akun Petugas ini terdaftar di {$kampusAsli->nama}. Anda tidak dapat login di portal {$kampusPilih->nama}.",
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
