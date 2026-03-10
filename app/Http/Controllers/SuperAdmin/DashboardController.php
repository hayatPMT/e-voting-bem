<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kampus;
use App\Models\Kandidat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKampus = Kampus::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalVotes = Kandidat::sum('total_votes') + \App\Models\Vote::count();

        $kampusList = Kampus::withCount(['admins', 'users as mahasiswa_count' => function ($query) {
            $query->where('role', 'mahasiswa');
        }])->with('settings')->get();

        return view('superadmin.dashboard', [
            'totalKampus' => $totalKampus,
            'totalAdmins' => $totalAdmins,
            'totalMahasiswa' => $totalMahasiswa,
            'totalVotes' => $totalVotes,
            'kampusList' => $kampusList,
        ]);
    }
}
