<?php

namespace App\Http\Controllers;

use App\Models\AttendanceApproval;
use App\Models\Kandidat;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapController extends Controller
{
    public function index()
    {
        $kampusId = $this->getKampusId();

        $data = Kandidat::where('kampus_id', $kampusId)->withCount('votes')->get();

        // Participation stats
        $totalMahasiswa = \App\Models\User::where('role', 'mahasiswa')
            ->where('kampus_id', $kampusId)
            ->count();

        $sudahVoting = \App\Models\Vote::where('kampus_id', $kampusId)->count();
        $abstainVotes = \App\Models\Vote::where('kampus_id', $kampusId)->where('is_abstain', true)->count();

        // From attendance approvals – breakdown by mode
        $attendanceAll = \App\Models\AttendanceApproval::whereHas('mahasiswa', fn ($q) => $q->where('kampus_id', $kampusId))
            ->where('status', 'voted')
            ->get();

        $onlineVoters = $attendanceAll->where('mode', 'online')->count();
        $offlineVoters = $attendanceAll->where('mode', 'offline')->count();

        // Hourly trend for today (last 8 hours)
        $hourlyTrend = \App\Models\Vote::where('kampus_id', $kampusId)
            ->whereDate('created_at', today())
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('total', 'hour')
            ->toArray();

        // Build last 12 hours array
        $currentHour = now()->hour;
        $trendLabels = [];
        $trendData = [];
        for ($h = max(0, $currentHour - 11); $h <= $currentHour; $h++) {
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

        return view('admin.rekap', compact('data', 'stats'));
    }

    /**
     * Show attendance report (daftar hadir)
     */
    public function attendanceReport(Request $request)
    {
        $kampusId = $this->getKampusId();
        $query = AttendanceApproval::whereHas('mahasiswa', function ($q) use ($kampusId) {
            $q->where('kampus_id', $kampusId);
        })->with(['mahasiswa.mahasiswaProfile', 'petugas']);

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        } else {
            // Default: today
            $query->whereDate('created_at', today());
        }

        // Filter by mode
        if ($request->filled('mode')) {
            $query->where('mode', $request->mode);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('created_at', 'desc')->get();

        // Summary stats
        $stats = [
            'total' => $attendances->count(),
            'online' => $attendances->where('mode', 'online')->count(),
            'offline' => $attendances->where('mode', 'offline')->count(),
            'approved' => $attendances->where('status', 'approved')->count(),
            'voted' => $attendances->where('status', 'voted')->count(),
        ];

        return view('admin.attendance-report', compact('attendances', 'stats'));
    }

    /**
     * Export attendance to CSV
     */
    public function exportAttendance(Request $request)
    {
        $kampusId = $this->getKampusId();
        $query = AttendanceApproval::whereHas('mahasiswa', function ($q) use ($kampusId) {
            $q->where('kampus_id', $kampusId);
        })->with(['mahasiswa.mahasiswaProfile', 'petugas']);

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        } else {
            $query->whereDate('created_at', today());
        }

        if ($request->filled('mode')) {
            $query->where('mode', $request->mode);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('created_at', 'asc')->get();

        // Create CSV response
        $filename = 'Daftar_Hadir_'.now()->format('Y-m-d_His').'.csv';

        $response = new StreamedResponse(function () use ($attendances) {
            $handle = fopen('php://output', 'w');

            // Set UTF-8 BOM for Excel
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header
            fputcsv($handle, [
                'No.',
                'Waktu',
                'NIM',
                'Nama',
                'Program Studi',
                'Mode',
                'Status',
                'Petugas',
                'Token',
            ], ';');

            // Data
            foreach ($attendances as $index => $att) {
                fputcsv($handle, [
                    $index + 1,
                    $att->created_at->format('Y-m-d H:i:s'),
                    $att->mahasiswa->mahasiswaProfile->nim ?? '-',
                    $att->mahasiswa->name ?? '-',
                    $att->mahasiswa->mahasiswaProfile->program_studi ?? '-',
                    ucfirst($att->mode ?? 'online'),
                    ucfirst($att->status ?? '-'),
                    $att->petugas?->name ?? 'Self-Register',
                    $att->session_token ?? '-',
                ], ';');
            }

            fclose($handle);
        }, 200, [
            'Content-Encoding' => 'UTF-8',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);

        return $response;
    }
}
