<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Vote;

class DashboardController extends Controller
{
    public function index()
    {
        $kandidat = Kandidat::withCount('votes')->get();
        $totalKandidat = Kandidat::count();
        $totalSuara = Vote::count();
        $totalMahasiswa = \App\Models\User::where('role', 'mahasiswa')->count();

        return view('admin.dashboard', [
            'kandidat' => $kandidat,
            'totalKandidat' => $totalKandidat,
            'totalSuara' => $totalSuara,
            'total_mahasiswa' => $totalMahasiswa,
        ]);
    }
}
