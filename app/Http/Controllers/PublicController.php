<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\User;
use App\Models\Vote;

class PublicController extends Controller
{
    public function index(): \Illuminate\Http\RedirectResponse|\Illuminate\View\View
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

        $kandidat = Kandidat::withCount('votes')->get();
        $totalSuara = Kandidat::sum('total_votes') + Vote::count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();

        return view('public.index', [
            'kandidat' => $kandidat,
            'totalSuara' => $totalSuara,
            'totalMahasiswa' => $totalMahasiswa,
            'setting' => \App\Models\Setting::first(),
        ]);
    }
}
