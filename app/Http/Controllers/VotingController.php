<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\MahasiswaProfile;
use App\Models\Setting;
use App\Models\Vote;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VotingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = null;
        $attendance = null;
        $tokenValidated = $user ? session('token_validated_for_user_' . $user->id, false) : false;

        // Get mahasiswa profile if user is mahasiswa
        if ($user && $user->role === 'mahasiswa') {
            $mahasiswa = $user->mahasiswaProfile;

            // Check for today's online attendance record
            $attendance = \App\Models\AttendanceApproval::where('mahasiswa_id', $user->id)
                ->whereDate('created_at', today())
                ->latest()
                ->first();

            // If attendance is already approved for online, ensure session is set
            if ($attendance && $attendance->mode === 'online' && $attendance->status === 'approved') {
                session(['token_validated_for_user_' . $user->id => true]);
                $tokenValidated = true;
            }
        }

        $currentTahapan = \App\Models\Tahapan::getCurrentTahapan();
        $setting = Setting::first();

        // Sync setting with tahapan for consistency in views
        if ($currentTahapan && $setting) {
            $setting->voting_start = $currentTahapan->waktu_mulai;
            $setting->voting_end = $currentTahapan->waktu_selesai;
        }

        $now = now();
        // Get current system time from setting or tahapan
        $startTime = $setting?->voting_start;
        $endTime = $setting?->voting_end;

        if ($currentTahapan) {
            $startTime = $currentTahapan->waktu_mulai;
            $endTime = $currentTahapan->waktu_selesai;
        }

        $initialDiff = ['days' => '00', 'hours' => '00', 'minutes' => '00', 'seconds' => '00'];

        if ($startTime && $endTime) {
            $targetTime = $now->lt($startTime) ? $startTime : $endTime;
            if ($now->lt($endTime)) {
                $diff = $now->diff($targetTime);
                $initialDiff = [
                    'days' => str_pad($diff->d + ($diff->m * 30), 2, '0', STR_PAD_LEFT),
                    'hours' => str_pad($diff->h, 2, '0', STR_PAD_LEFT),
                    'minutes' => str_pad($diff->i, 2, '0', STR_PAD_LEFT),
                    'seconds' => str_pad($diff->s, 2, '0', STR_PAD_LEFT),
                ];
            }
        }

        return view('mahasiswa.voting', [
            'kandidat' => Kandidat::all(),
            'setting' => $setting,
            'mahasiswa' => $mahasiswa,
            'currentTahapan' => $currentTahapan,
            'attendance' => $attendance,
            'tokenValidated' => $tokenValidated,
            'initialDiff' => $initialDiff,
        ]);
    }

    public function vote($id)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/verifikasi?kandidat=' . $id)->with('error', 'Silakan verifikasi NIM dan password Anda terlebih dahulu.');
        }

        if ($user->role !== 'mahasiswa') {
            return back()->with('error', 'Hanya mahasiswa yang dapat memilih kandidat.');
        }

        $userId = $user->id;
        if ($user->mahasiswaProfile->has_voted) {
            return back()->with('error', 'Anda sudah memilih');
        }

        $setting = Setting::first();
        $currentTahapan = \App\Models\Tahapan::getCurrentTahapan();
        $now = Carbon::now();

        $startTime = $setting?->voting_start;
        $endTime = $setting?->voting_end;
        $scheduleName = 'Voting';

        if ($currentTahapan) {
            $startTime = $currentTahapan->waktu_mulai;
            $endTime = $currentTahapan->waktu_selesai;
            $scheduleName = $currentTahapan->nama_tahapan;
        }

        if ($startTime && $now->lt($startTime)) {
            return back()->with('error', $scheduleName . ' belum dimulai. Harap kembali pada ' . $startTime->format('d M Y H:i'));
        }
        if ($endTime && $now->gt($endTime)) {
            return back()->with('error', $scheduleName . ' sudah ditutup pada ' . $endTime->format('d M Y H:i'));
        }

        // Security check for online voters
        if ($user->role === 'mahasiswa' && request()->routeIs('voting.vote')) {
            $tokenValidated = session('token_validated_for_user_' . $userId, false);
            if (! $tokenValidated) {
                return redirect('/voting')->with('error', 'Silakan konfirmasi kehadiran terlebih dahulu.');
            }
        }

        // Introduce random delay (0.5 to 2.5 seconds) to break timestamp matching between profile update and vote cast
        usleep(rand(500000, 2500000));

        // Create anonymous vote record (No user_id)
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $kandidat = Kandidat::findOrFail($id);
            // Removed redundant total_votes increment as it causes double-counting in rekap
            // $kandidat->incrementVote();

            // Create anonymous vote record (No user_id linked)
            Vote::create([
                'user_id' => null,
                'kandidat_id' => $id,
                'encrypted_kandidat_id' => encrypt($id),
                'vote_hash' => hash('sha256', Str::random(40)),
            ]);

            // Mark mahasiswa as voted and store encrypted receipt
            $mahasiswa = MahasiswaProfile::where('user_id', $userId)->first();
            if ($mahasiswa) {
                $mahasiswa->update([
                    'has_voted' => true,
                    'voted_at' => today(),
                    'vote_receipt' => encrypt([
                        'kandidat_id' => $id,
                        'kandidat_nama' => $kandidat->nama,
                        'vote_time' => now()->toDateTimeString(),
                    ]),
                ]);
            }

            // Mark attendance as voted if exists
            \App\Models\AttendanceApproval::where('mahasiswa_id', $userId)
                ->whereDate('created_at', today())
                ->update([
                    'status' => 'voted',
                    'voted_at' => now(),
                ]);

            \Illuminate\Support\Facades\DB::commit();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Voting Error: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menyimpan suara Anda. Silakan coba lagi.');
        }

        return redirect('/voting')->with([
            'success' => 'Vote Anda berhasil disimpan secara anonim. Terima kasih telah berpartisipasi!',
            'voted_candidate' => $kandidat,
            'vote_hash' => substr(hash('sha256', Str::random(40)), 0, 16), // Anonymous hash for UI
        ]);
    }

    /**
     * Download vote receipt as PDF
     */
    public function downloadReceipt()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/voting')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $mahasiswa = $user->mahasiswaProfile;

        if (! $mahasiswa || ! $mahasiswa->has_voted || ! $mahasiswa->vote_receipt) {
            return redirect('/voting')->with('error', 'Anda belum melakukan voting atau data bukti voting tidak ditemukan.');
        }

        try {
            // Decrypt the receipt data from student profile
            $receiptData = decrypt($mahasiswa->vote_receipt);

            $kandidat = Kandidat::find($receiptData['kandidat_id']);

            if (! $kandidat) {
                // Fallback to name stored in receipt if candidate was deleted
                $kandidat = (object) ['nama' => $receiptData['kandidat_nama'], 'foto' => null];
            }

            $voteTime = Carbon::parse($receiptData['vote_time']);

            // Generate a verification hash based on secure user info and receipt (for print verification)
            $voteHash = strtoupper(substr(hash('sha256', $user->id . $receiptData['kandidat_id'] . $voteTime->timestamp), 0, 16));

            $data = [
                'nim' => $mahasiswa->nim ?? 'N/A',
                'nama' => $user->name,
                'kandidat' => $kandidat,
                'vote_time' => $voteTime,
                'vote_hash' => $voteHash,
                'qr_data' => 'VOTE-VERIFICATION:' . $voteHash,
                'setting' => Setting::first(),
            ];

            $pdf = Pdf::loadView('pdf.vote-receipt', $data);
            $pdf->setPaper('a4', 'portrait');

            $filename = 'Bukti-Voting-' . ($mahasiswa->nim ?? $user->id) . '-' . now()->format('YmdHis') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('PDF Generation Error: ' . $e->getMessage());

            return redirect('/voting')->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }

    /**
     * Confirm attendance for online voting and immediately grant access to voting
     */
    public function confirmAttendance()
    {
        $user = Auth::user();
        if (! $user || $user->role !== 'mahasiswa') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($user->mahasiswaProfile?->has_voted) {
            return response()->json(['success' => false, 'message' => 'Anda sudah melakukan voting.'], 409);
        }

        $now = Carbon::now();
        $startTime = null;
        $endTime = null;

        $currentTahapan = \App\Models\Tahapan::getCurrentTahapan();
        if ($currentTahapan) {
            $startTime = $currentTahapan->waktu_mulai;
            $endTime = $currentTahapan->waktu_selesai;
        } else {
            $setting = Setting::first();
            $startTime = $setting?->voting_start;
            $endTime = $setting?->voting_end;
        }

        if (! $startTime || ! $endTime) {
            return response()->json(['success' => false, 'message' => 'Jadwal voting belum dikonfigurasi.'], 400);
        }

        if ($now->lt($startTime)) {
            return response()->json([
                'success' => false,
                'message' => 'Konfirmasi kehadiran belum dibuka. Voting dimulai pada ' . $startTime->translatedFormat('d M Y H:i') . ' WIB.',
            ], 400);
        }

        if ($now->gt($endTime)) {
            return response()->json([
                'success' => false,
                'message' => 'Waktu voting sudah berakhir pada ' . $endTime->translatedFormat('d M Y H:i') . ' WIB.',
            ], 400);
        }

        // Check for existing attendance today
        $attendance = \App\Models\AttendanceApproval::where('mahasiswa_id', $user->id)
            ->whereDate('created_at', today())
            ->first();

        if ($attendance) {
            // If already voted
            if ($attendance->hasVoted()) {
                return response()->json(['success' => false, 'message' => 'Anda sudah menggunakan hak pilih Anda.'], 409);
            }

            // Already confirmed - ensure status is approved
            if ($attendance->status !== 'approved') {
                $attendance->update(['status' => 'approved', 'approved_at' => now()]);
            }

            // If it's offline mode, this shouldn't happen
            if ($attendance->mode === 'offline') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar sebagai offline voting. Silakan gunakan token yang diberikan.',
                ], 409);
            }
        } else {
            // Create new record for ONLINE mode only - NO TOKEN NEEDED
            $attendance = \App\Models\AttendanceApproval::create([
                'mahasiswa_id' => $user->id,
                'petugas_id' => null,
                'status' => 'approved',
                'mode' => 'online',
                'approved_at' => now(),
                'session_token' => null, // Online students don't get tokens
            ]);
        }

        // Immediately grant access for online voting
        session(['token_validated_for_user_' . $user->id => true]);

        return response()->json([
            'success' => true,
            'message' => 'Kehadiran Anda telah dikonfirmasi! Silakan pilih kandidat.',
        ]);
    }
}
