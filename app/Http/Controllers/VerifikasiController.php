<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VerifikasiController extends Controller
{
    /**
     * Show verifikasi form (NIM + password for mahasiswa to vote).
     */
    public function show(Request $request)
    {
        $kandidatId = $request->query('kandidat');

        return view('auth.verifikasi', ['kandidat_id' => $kandidatId]);
    }

    /**
     * Verify mahasiswa by NIM + password, log in, then redirect to vote or voting page.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
            'password' => 'required',
        ]);

        $profile = MahasiswaProfile::where('nim', $request->nim)->first();
        if (! $profile) {
            return back()->with('error', 'NIM tidak ditemukan.');
        }

        $user = $profile->user;
        if (! $user || $user->role !== 'mahasiswa') {
            return back()->with('error', 'Akun tidak valid untuk voting.');
        }

        if (! $user->is_active) {
            return back()->with('error', 'Akun Anda dinonaktifkan.');
        }

        if (! Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah.');
        }

        Auth::login($user);

        $kandidatId = $request->input('kandidat_id');
        if ($kandidatId) {
            return redirect('/vote/'.$kandidatId);
        }

        return redirect('/voting')->with('success', 'Verifikasi berhasil. Silakan pilih kandidat.');
    }
}
