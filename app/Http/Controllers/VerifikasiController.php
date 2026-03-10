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
        $kampusId = $request->query('kampus_id');

        if (! $kampusId) {
            return redirect()->route('landing');
        }

        $kampus = \App\Models\Kampus::find($kampusId);
        if (! $kampus) {
            return redirect()->route('landing')->with('error', 'Kampus tidak valid');
        }

        return view('auth.verifikasi', [
            'kandidat_id' => $kandidatId,
            'kampus_id' => $kampusId,
            'kampus' => $kampus,
        ]);
    }

    /**
     * Verify mahasiswa by NIM + password, log in, then redirect to vote or voting page.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
            'password' => 'required',
            'kampus_id' => 'required|numeric',
        ]);

        $profile = MahasiswaProfile::where('nim', $request->nim)->first();
        if (! $profile) {
            return back()->with('error', 'NIM tidak ditemukan.');
        }

        $user = $profile->user;
        if (! $user || $user->role !== 'mahasiswa') {
            return back()->with('error', 'Akun tidak valid untuk voting.');
        }

        // Enforce kampus check
        if ($user->kampus_id != $request->kampus_id) {
            $kampusPilih = \App\Models\Kampus::find($request->kampus_id);
            $kampusAsli = \App\Models\Kampus::find($user->kampus_id);

            return back()->with('error', "NIM ini terdaftar di {$kampusAsli->nama}. Anda tidak dapat login di portal {$kampusPilih->nama}.");
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
