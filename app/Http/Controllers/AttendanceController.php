<?php

namespace App\Http\Controllers;

use App\Models\AttendanceApproval;
use App\Models\Tahapan;
use App\Models\User;
use App\Models\VotingBooth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Display attendance management page for petugas
     */
    public function index()
    {
        $currentTahapan = Tahapan::getCurrentTahapan();

        if (! $currentTahapan) {
            return view('petugas.no-tahapan');
        }

        $attendances = AttendanceApproval::with(['mahasiswa.mahasiswaProfile', 'votingBooth'])
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->get();

        $votingBooths = VotingBooth::where('is_active', true)->get();

        $activeBoothId = session()->get('active_booth_id');

        return view('petugas.attendance.index', compact('attendances', 'votingBooths', 'currentTahapan', 'activeBoothId'));
    }

    /**
     * Search mahasiswa by NIM
     */
    public function searchMahasiswa(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
        ]);

        $mahasiswa = User::where('role', 'mahasiswa')
            ->whereHas('mahasiswaProfile', function ($query) use ($request) {
                $query->where('nim', $request->nim);
            })
            ->with('mahasiswaProfile')
            ->first();

        if (! $mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan',
            ], 404);
        }

        // Check if already approved today
        $existingApproval = AttendanceApproval::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('created_at', today())
            ->first();

        if ($existingApproval) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa sudah terdaftar hari ini',
                'status' => $existingApproval->status,
            ], 400);
        }

        // Check if already voted
        if ($mahasiswa->mahasiswaProfile->has_voted) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa ini sudah melakukan voting (Online/Offline)',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'mahasiswa' => [
                'id' => $mahasiswa->id,
                'name' => $mahasiswa->name,
                'nim' => $mahasiswa->mahasiswaProfile->nim,
                'prodi' => $mahasiswa->mahasiswaProfile->program_studi,
            ],
        ]);
    }

    /**
     * Approve mahasiswa for voting
     */
    public function approve(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
        ]);

        $mahasiswa = User::findOrFail($request->mahasiswa_id);

        // Check if already approved today
        $existingApproval = AttendanceApproval::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('created_at', today())
            ->first();

        if ($existingApproval) {
            return back()->with('error', 'Mahasiswa sudah terdaftar hari ini');
        }

        // Check if already voted
        if ($mahasiswa->mahasiswaProfile->has_voted) {
            return back()->with('error', 'Mahasiswa ini sudah melakukan voting (Online/Offline)');
        }

        // Create attendance approval
        $attendance = AttendanceApproval::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'petugas_id' => Auth::id(),
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Generate session token
        $token = $attendance->generateSessionToken();

        return redirect()
            ->route('petugas.attendance.index')
            ->with('success', 'Mahasiswa berhasil disetujui.')
            ->with('generated_token', $token);
    }

    /**
     * Show voting page for approved mahasiswa (offline mode)
     */
    public function showVotingPage(string $token)
    {
        $attendance = AttendanceApproval::where('session_token', $token)
            ->with(['mahasiswa.mahasiswaProfile', 'votingBooth'])
            ->firstOrFail();

        // Check if token is still valid (approved status)
        if (! $attendance->isApproved()) {
            return back()->with('error', 'Token tidak valid atau sudah digunakan');
        }

        // Check if already voted
        if ($attendance->mahasiswa->mahasiswaProfile->has_voted) {
            $attendance->markAsVoted();
            return redirect()->route('voting-booth.standby', $attendance->voting_booth_id)->with('error', 'Mahasiswa sudah melakukan voting');
        }

        $kandidat = \App\Models\Kandidat::orderBy('id')->get();
        $setting = \App\Models\Setting::first();

        $serverNow = now()->timestamp * 1000;
        $startTime = ($setting && $setting->voting_start) ? $setting->voting_start->timestamp * 1000 : now()->subMinute()->timestamp * 1000;
        $endTime = ($setting && $setting->voting_end) ? $setting->voting_end->timestamp * 1000 : now()->addHours(24)->timestamp * 1000;

        return view('petugas.attendance.voting', compact('attendance', 'kandidat', 'setting', 'serverNow', 'startTime', 'endTime'));
    }

    /**
     * Process vote from offline mode
     */
    public function processVote(Request $request, string $token)
    {
        $request->validate([
            'kandidat_id' => 'required|exists:kandidats,id',
        ]);

        $attendance = AttendanceApproval::where('session_token', $token)->firstOrFail();

        // Check if token is still valid
        if (! $attendance->isApproved()) {
            return back()->with('error', 'Token tidak valid atau sudah digunakan');
        }

        // Check if already voted
        if ($attendance->mahasiswa->mahasiswaProfile->has_voted) {
            return redirect()->route('voting-booth.standby', $attendance->voting_booth_id)->with('error', 'Mahasiswa sudah melakukan voting');
        }

        // Create vote using VotingController logic
        $votingController = new VotingController;

        // Temporarily authenticate as mahasiswa for voting
        Auth::login($attendance->mahasiswa);

        // Process the vote
        $response = $votingController->vote($request->kandidat_id);

        // Mark attendance as voted
        $attendance->markAsVoted();

        // Logout mahasiswa
        Auth::logout();

        if ($attendance->voting_booth_id) {
            return redirect()
                ->route('voting-booth.standby', $attendance->voting_booth_id)
                ->with('success', 'Vote berhasil diproses secara anonim. Terima kasih telah memilih.');
        }

        return redirect()
            ->route('voting-booth.portal')
            ->with('success', 'Vote berhasil diproses secara anonim. Terima kasih telah memilih.');
    }

    /**
     * Set active booth for this session
     */
    public function setBooth(Request $request)
    {
        $request->validate([
            'voting_booth_id' => 'required|exists:voting_booths,id',
        ]);

        Log::info('Petugas set booth: ' . $request->voting_booth_id . ' by user ' . Auth::id());
        session(['active_booth_id' => $request->voting_booth_id]);
        session()->save();

        return redirect()->route('petugas.attendance.index')->with('success', 'Bilik suara aktif berhasil diatur');
    }

    /**
     * Cancel attendance approval
     */
    public function cancel(string $id)
    {
        $attendance = AttendanceApproval::findOrFail($id);

        if ($attendance->hasVoted()) {
            return back()->with('error', 'Tidak dapat membatalkan approval yang sudah voting');
        }

        $attendance->delete();

        return back()->with('success', 'Approval berhasil dibatalkan');
    }
}
