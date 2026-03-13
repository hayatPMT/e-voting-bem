<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\AttendanceApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapController extends Controller
{
    public function index()
    {
        $kampusId = $this->getKampusId();

        // Scope kandidat to campus
        $data = Kandidat::where('kampus_id', $kampusId)->withCount('votes')->get();

        // Calculate statistics
        $totalMahasiswa = \App\Models\User::where('role', 'mahasiswa')
            ->where('kampus_id', $kampusId)
            ->count();

        $sudahVoting = \App\Models\MahasiswaProfile::where('has_voted', true)
            ->whereHas('user', function ($q) use ($kampusId) {
                $q->where('kampus_id', $kampusId);
            })->count();

        $belumVoting = max(0, $totalMahasiswa - $sudahVoting);
        $partisipasiPersen = $totalMahasiswa > 0 ? round(($sudahVoting / $totalMahasiswa) * 100, 1) : 0;
        
        $abstainVotes = \App\Models\Vote::where('kampus_id', $kampusId)->where('is_abstain', true)->count();

        // Count voters by mode based on completed attendances
        $onlineVoters = AttendanceApproval::where('kampus_id', $kampusId)
            ->where('mode', 'online')
            ->where('status', 'voted')
            ->count();

        $offlineVoters = AttendanceApproval::where('kampus_id', $kampusId)
            ->where('mode', 'offline')
            ->where('status', 'voted')
            ->count();

        // Calculate trend data for today (voted per hour from 08:00 to 18:00)
        $votesToday = \App\Models\Vote::where('kampus_id', $kampusId)
            ->whereDate('created_at', today())
            ->get()
            ->groupBy(function($vote) {
                return \Carbon\Carbon::parse($vote->created_at)->format('H');
            });

        $trendLabels = [];
        $trendData = [];

        for ($i = 8; $i <= 18; $i++) {
            $formattedHour = sprintf("%02d", $i);
            $trendLabels[] = $formattedHour . ":00";
            $trendData[] = isset($votesToday[$formattedHour]) ? $votesToday[$formattedHour]->count() : 0;
        }

        $stats = [
            'total_mahasiswa' => $totalMahasiswa,
            'sudah_voting' => $sudahVoting,
            'belum_voting' => $belumVoting,
            'partisipasi_persen' => $partisipasiPersen,
            'abstain_votes' => $abstainVotes,
            'online_voters' => $onlineVoters,
            'offline_voters' => $offlineVoters,
            'trend_labels' => $trendLabels,
            'trend_data' => $trendData,
        ];

        return view('admin.rekap', compact('data', 'stats'));
    }

    public function attendanceReport(Request $request)
    {
        $kampusId = $this->getKampusId();
        
        $query = AttendanceApproval::with(['mahasiswa.mahasiswaProfile', 'petugas'])
                                    ->where('kampus_id', $kampusId);

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

        $attendances = $query->orderBy('created_at', 'desc')->get();

        $baseQuery = AttendanceApproval::where('kampus_id', $kampusId);
        if ($request->filled('date')) {
            $baseQuery->whereDate('created_at', $request->date);
        } else {
            $baseQuery->whereDate('created_at', today());
        }

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'online' => (clone $baseQuery)->where('mode', 'online')->count(),
            'offline' => (clone $baseQuery)->where('mode', 'offline')->count(),
            'voted' => (clone $baseQuery)->where('status', 'voted')->count(),
        ];

        return view('admin.attendance-report', compact('attendances', 'stats'));
    }

    public function exportAttendance(Request $request)
    {
        $kampusId = $this->getKampusId();
        
        $query = AttendanceApproval::with(['mahasiswa.mahasiswaProfile', 'petugas'])
                                    ->where('kampus_id', $kampusId);

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

        $attendances = $query->orderBy('created_at', 'desc')->get();

        $filename = "laporan_kehadiran_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['No', 'Waktu', 'NIM', 'Nama Mahasiswa', 'Program Studi', 'Mode', 'Status', 'Petugas'];

        $callback = function () use ($attendances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            $no = 1;
            foreach ($attendances as $attendance) {
                $row = [
                    $no++,
                    $attendance->created_at->format('Y-m-d H:i:s'),
                    $attendance->mahasiswa->mahasiswaProfile->nim ?? '-',
                    $attendance->mahasiswa->name ?? '-',
                    $attendance->mahasiswa->mahasiswaProfile->program_studi ?? '-',
                    ucfirst($attendance->mode),
                    ucfirst($attendance->status),
                    $attendance->petugas->name ?? 'Self-Register'
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
