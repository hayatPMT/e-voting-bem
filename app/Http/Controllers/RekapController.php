<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\AttendanceApproval;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapController extends Controller
{
    public function index()
    {
        $data = Kandidat::withCount('votes')->get();

        return view('admin.rekap', compact('data'));
    }

    /**
     * Show attendance report (daftar hadir)
     */
    public function attendanceReport(Request $request)
    {
        $query = AttendanceApproval::with(['mahasiswa.mahasiswaProfile', 'petugas']);

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
        $query = AttendanceApproval::with(['mahasiswa.mahasiswaProfile', 'petugas']);

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
        $filename = 'Daftar_Hadir_' . now()->format('Y-m-d_His') . '.csv';

        $response = new StreamedResponse(function () use ($attendances) {
            $handle = fopen('php://output', 'w');

            // Set UTF-8 BOM for Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

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
                'Token'
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
                    $att->session_token ?? '-'
                ], ';');
            }

            fclose($handle);
        }, 200, [
            'Content-Encoding' => 'UTF-8',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);

        return $response;
    }
}
