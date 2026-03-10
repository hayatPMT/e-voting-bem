<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;

class DashboardController extends Controller
{
    public function index()
    {
        $kampusId = $this->getKampusId();

        $kandidat = Kandidat::where('kampus_id', $kampusId)->withCount('votes')->get();
        $totalKandidat = Kandidat::where('kampus_id', $kampusId)->count();

        $totalSuara = Kandidat::where('kampus_id', $kampusId)->sum('total_votes')
            + \App\Models\Vote::whereHas('kandidat', fn ($q) => $q->where('kampus_id', $kampusId))->count();

        $totalMahasiswa = \App\Models\User::where('role', 'mahasiswa')
            ->where('kampus_id', $kampusId)
            ->count();

        return view('admin.dashboard', [
            'kandidat' => $kandidat,
            'totalKandidat' => $totalKandidat,
            'totalSuara' => $totalSuara,
            'total_mahasiswa' => $totalMahasiswa,
        ]);
    }
}
