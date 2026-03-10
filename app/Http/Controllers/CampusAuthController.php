<?php

namespace App\Http\Controllers;

use App\Models\Kampus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CampusAuthController extends Controller
{
    /**
     * Show the campus-specific admin login page.
     */
    public function login(Request $request, string $kampus_slug): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        /** @var Kampus $kampus */
        $kampus = $request->attributes->get('kampus');

        return view('campus-portal.login', compact('kampus'));
    }

    /**
     * Authenticate admin against this specific campus portal.
     */
    public function authenticate(Request $request, string $kampus_slug): RedirectResponse
    {
        /** @var Kampus $kampus */
        $kampus = $request->attributes->get('kampus');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        // Super Admin can login from any campus portal and will be redirected to superadmin dashboard
        if ($user && $user->role === 'super_admin') {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->route('superadmin.dashboard');
            }
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Ensure admin belongs to this campus
            if ($user->role === 'admin') {
                if ($user->kampus_id !== $kampus->id) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    $kampusTerdaftar = \App\Models\Kampus::find($user->kampus_id);

                    return back()->with(
                        'error',
                        'Akun Anda terdaftar di '.($kampusTerdaftar?->nama ?? 'Kampus Lain').'. Silakan login melalui portal kampus yang benar: '.($kampusTerdaftar?->admin_login_url ?? '')
                    );
                }

                if (! $user->is_active) {
                    Auth::logout();

                    return back()->with('error', 'Akun Anda telah dinonaktifkan. Hubungi Super Admin.');
                }

                return redirect()->intended(route('admin.dashboard'));
            }

            // Mahasiswa / petugas trying admin portal
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->with('error', 'Halaman ini hanya untuk Admin. Mahasiswa silakan melalui portal mahasiswa.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Show campus-specific student verification page.
     */
    public function verifikasi(Request $request, string $kampus_slug): View
    {
        /** @var Kampus $kampus */
        $kampus = $request->attributes->get('kampus');

        return view('campus-portal.verifikasi', compact('kampus'));
    }

    /**
     * Process student verification for this campus.
     */
    public function verifikasiProcess(Request $request, string $kampus_slug): RedirectResponse
    {
        /** @var Kampus $kampus */
        $kampus = $request->attributes->get('kampus');

        $request->validate([
            'nim' => 'required',
            'password' => 'required',
        ]);

        $mahasiswa = \App\Models\User::where('role', 'mahasiswa')
            ->where('kampus_id', $kampus->id)
            ->whereHas('mahasiswaProfile', fn ($q) => $q->where('nim', $request->nim))
            ->first();

        if (! $mahasiswa || ! \Illuminate\Support\Facades\Hash::check($request->password, $mahasiswa->password)) {
            return back()->withErrors([
                'nim' => 'NIM atau password tidak ditemukan di kampus ini.',
            ])->onlyInput('nim');
        }

        if (! $mahasiswa->is_active) {
            return back()->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        Auth::login($mahasiswa);
        $request->session()->regenerate();

        // Store the campus context in session for this voting session
        $request->session()->put('voting_kampus_id', $kampus->id);

        return redirect()->route('voting.index');
    }

    /**
     * Show campus-specific petugas login page.
     */
    public function petugasLogin(Request $request, string $kampus_slug): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isPetugas()) {
            return redirect()->route('petugas.attendance.index');
        }

        /** @var Kampus $kampus */
        $kampus = $request->attributes->get('kampus');

        return view('campus-portal.petugas-login', compact('kampus'));
    }

    /**
     * Authenticate petugas against this specific campus portal.
     */
    public function petugasAuthenticate(Request $request, string $kampus_slug): RedirectResponse
    {
        /** @var Kampus $kampus */
        $kampus = $request->attributes->get('kampus');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'petugas_daftar_hadir' && $user->kampus_id === $kampus->id) {
                if (! $user->is_active) {
                    Auth::logout();

                    return back()->with('error', 'Akun petugas Anda tidak aktif.');
                }

                return redirect()->route('petugas.attendance.index');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->with('error', 'Akun petugas tidak ditemukan di kampus ini.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
}
