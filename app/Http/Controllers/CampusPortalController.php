<?php

namespace App\Http\Controllers;

use App\Models\Kampus;
use App\Models\Tahapan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CampusPortalController extends Controller
{
    /**
     * Show the campus portal landing page (mode selection).
     * No need to pick campus first – it's already resolved from the URL slug.
     */
    public function index(Request $request, string $kampus_slug): View|RedirectResponse
    {
        /** @var Kampus $kampus */
        $kampus = $request->attributes->get('kampus');

        $currentTahapan = Tahapan::getCurrentTahapan($kampus->id);

        if (! $currentTahapan) {
            return view('campus-portal.portal', [
                'tahapanActive' => false,
                'message' => 'Belum ada tahapan voting yang aktif',
                'kampus' => $kampus,
            ]);
        }

        if (! $currentTahapan->isActive()) {
            $message = 'Voting belum dimulai';

            if ($currentTahapan->hasEnded()) {
                $message = 'Voting sudah berakhir';
            }

            return view('campus-portal.portal', [
                'tahapanActive' => false,
                'message' => $message,
                'tahapan' => $currentTahapan,
                'kampus' => $kampus,
            ]);
        }

        return view('campus-portal.portal', [
            'tahapanActive' => true,
            'tahapan' => $currentTahapan,
            'kampus' => $kampus,
        ]);
    }

    /**
     * Handle mode selection on the campus portal.
     */
    public function selectMode(Request $request, string $kampus_slug): RedirectResponse
    {
        /** @var Kampus $kampus */
        $kampus = $request->attributes->get('kampus');

        $request->validate([
            'mode' => 'required|in:online,offline',
        ]);

        $currentTahapan = Tahapan::getCurrentTahapan($kampus->id);

        if (! $currentTahapan || ! $currentTahapan->isActive()) {
            return back()->with('error', 'Tidak ada tahapan voting yang aktif di kampus ini');
        }

        if ($request->mode === 'online') {
            return redirect()->route('campus.verifikasi', ['kampus_slug' => $kampus_slug]);
        } else {
            return redirect()->route('campus.petugas.login', ['kampus_slug' => $kampus_slug]);
        }
    }

    /**
     * Show the public voting chart for this campus.
     */
    public function chart(Request $request, string $kampus_slug): View
    {
        /** @var Kampus $kampus */
        $kampus = $request->attributes->get('kampus');

        $kandidat = \App\Models\Kandidat::where('kampus_id', $kampus->id)
            ->withCount('votes')
            ->get();

        $totalSuara = $kandidat->sum(fn ($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0));

        $totalMahasiswa = \App\Models\User::where('role', 'mahasiswa')
            ->where('kampus_id', $kampus->id)
            ->count();

        $sudahVoting = \App\Models\Vote::where('kampus_id', $kampus->id)->count();
        $abstainVotes = \App\Models\Vote::where('kampus_id', $kampus->id)->where('is_abstain', true)->count();

        $attendanceAll = \App\Models\AttendanceApproval::whereHas('mahasiswa', fn ($q) => $q->where('kampus_id', $kampus->id))
            ->where('status', 'voted')
            ->get();

        $onlineVoters = $attendanceAll->where('mode', 'online')->count();
        $offlineVoters = $attendanceAll->where('mode', 'offline')->count();

        // Hourly trend (last 10 hours today)
        $hourlyTrend = \App\Models\Vote::where('kampus_id', $kampus->id)
            ->whereDate('created_at', today())
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('total', 'hour')
            ->toArray();

        $currentHour = now()->hour;
        $trendLabels = [];
        $trendData = [];
        for ($h = max(0, $currentHour - 9); $h <= $currentHour; $h++) {
            $trendLabels[] = str_pad($h, 2, '0', STR_PAD_LEFT).':00';
            $trendData[] = $hourlyTrend[$h] ?? 0;
        }

        $stats = [
            'total_mahasiswa' => $totalMahasiswa,
            'sudah_voting' => $sudahVoting,
            'belum_voting' => max(0, $totalMahasiswa - $sudahVoting),
            'partisipasi_persen' => $totalMahasiswa > 0 ? round(($sudahVoting / $totalMahasiswa) * 100, 1) : 0,
            'online_voters' => $onlineVoters,
            'offline_voters' => $offlineVoters,
            'abstain_votes' => $abstainVotes,
            'trend_labels' => $trendLabels,
            'trend_data' => $trendData,
        ];

        return view('campus-portal.chart', compact('kampus', 'kandidat', 'totalSuara', 'stats'));
    }
}
