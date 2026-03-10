<?php

namespace App\Http\Controllers;

use App\Models\Tahapan;
use Illuminate\Http\Request;

class ModeSelectionController extends Controller
{
    /**
     * Show mode selection page (Online or Offline)
     */
    public function index(Request $request)
    {
        $kampusId = $request->get('kampus_id');

        if (! $kampusId) {
            $kampuses = \App\Models\Kampus::where('is_active', true)->get();

            return view('select_kampus_awal', compact('kampuses'));
        }

        $kampus = \App\Models\Kampus::findOrFail($kampusId);
        $currentTahapan = Tahapan::getCurrentTahapan($kampusId);

        // If no active tahapan, show message
        if (! $currentTahapan) {
            return view('mode-selection', [
                'tahapanActive' => false,
                'message' => 'Belum ada tahapan voting yang aktif',
                'kampus' => $kampus,
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
                'kampus' => $kampus,
            ]);
        }

        return view('mode-selection', [
            'tahapanActive' => true,
            'tahapan' => $currentTahapan,
            'kampus' => $kampus,
        ]);
    }

    /**
     * Handle mode selection
     */
    public function selectMode(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:online,offline',
            'kampus_id' => 'required|numeric',
        ]);

        $kampusId = $request->kampus_id;
        $currentTahapan = Tahapan::getCurrentTahapan($kampusId);

        if (! $currentTahapan || ! $currentTahapan->isActive()) {
            return back()->with('error', 'Tidak ada tahapan voting yang aktif di kampus ini');
        }

        if ($request->mode === 'online') {
            // Redirect to student verification/login along with kampus_id
            return redirect()->route('verifikasi', ['kampus_id' => $kampusId]);
        } else {
            // Redirect to petugas login
            return redirect()->route('petugas.login', ['kampus_id' => $kampusId]);
        }
    }
}
