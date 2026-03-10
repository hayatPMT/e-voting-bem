<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\User;
use App\Models\Vote;

class PublicController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user->role === 'admin') {
                return redirect('/dashboard');
            }
            if ($user->role === 'mahasiswa') {
                return redirect('/voting');
            }
        }

        $kampusId = $request->get('kampus_id');

        // Jika tidak ada parameter kampus_id, arahkan ke halaman pilih kampus
        if (! $kampusId) {
            $kampuses = \App\Models\Kampus::where('is_active', true)->get();

            return view('public.select_kampus', compact('kampuses'));
        }

        $kampus = \App\Models\Kampus::findOrFail($kampusId);

        $kandidat = Kandidat::where('kampus_id', $kampusId)->withCount('votes')->get();

        $totalSuara = Kandidat::where('kampus_id', $kampusId)->sum('total_votes')
            + Vote::whereHas('kandidat', fn ($q) => $q->where('kampus_id', $kampusId))->count();

        $totalMahasiswa = User::where('role', 'mahasiswa')
            ->where('kampus_id', $kampusId)
            ->count();

        return view('public.index', [
            'kampus' => $kampus,
            'kandidat' => $kandidat,
            'totalSuara' => $totalSuara,
            'totalMahasiswa' => $totalMahasiswa,
            'setting' => \App\Models\Setting::where('kampus_id', $kampusId)->first(),
        ]);
    }
}
