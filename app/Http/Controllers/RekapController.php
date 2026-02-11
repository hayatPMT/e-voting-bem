<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;

class RekapController extends Controller
{
    public function index()
    {
        $data = Kandidat::withCount('votes')->get();

        return view('admin.rekap', compact('data'));
    }
}
