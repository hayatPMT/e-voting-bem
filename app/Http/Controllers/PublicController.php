<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\User;
use App\Models\Vote;

class PublicController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                return redirect('/dashboard');
            }
            if (auth()->user()->role === 'mahasiswa') {
                return redirect('/voting');
            }
        }

        $kandidat = Kandidat::withCount('votes')->get();
        $totalSuara = Vote::count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();

        return view('public.index', [
            'kandidat' => $kandidat,
            'totalSuara' => $totalSuara,
            'totalMahasiswa' => $totalMahasiswa,
            'setting' => \App\Models\Setting::first(),
        ]);
    }
}
