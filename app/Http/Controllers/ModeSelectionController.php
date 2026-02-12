<?php

namespace App\Http\Controllers;

use App\Models\Tahapan;
use Illuminate\Http\Request;

class ModeSelectionController extends Controller
{
    /**
     * Show mode selection page (Online or Offline)
     */
    public function index()
    {
        $currentTahapan = Tahapan::getCurrentTahapan();

        // If no active tahapan, show message
        if (! $currentTahapan) {
            return view('mode-selection', [
                'tahapanActive' => false,
                'message' => 'Belum ada tahapan voting yang aktif',
            ]);
        }

        // Check if tahapan is currently running
        if (! $currentTahapan->isActive()) {
            $message = 'Voting belum dimulai';

            if ($currentTahapan->hasEnded()) {
                $message = 'Voting sudah berakhir';
            }

            return view('mode-selection', [
                'tahapanActive' => false,
                'message' => $message,
                'tahapan' => $currentTahapan,
            ]);
        }

        return view('mode-selection', [
            'tahapanActive' => true,
            'tahapan' => $currentTahapan,
        ]);
    }

    /**
     * Handle mode selection
     */
    public function selectMode(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:online,offline',
        ]);

        $currentTahapan = Tahapan::getCurrentTahapan();

        if (! $currentTahapan || ! $currentTahapan->isActive()) {
            return back()->with('error', 'Tidak ada tahapan voting yang aktif');
        }

        if ($request->mode === 'online') {
            // Redirect to student verification/login
            return redirect()->route('verifikasi');
        } else {
            // Redirect to petugas login
            return redirect()->route('petugas.login');
        }
    }
}
