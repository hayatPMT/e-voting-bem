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

        // Get mahasiswa profile if user is mahasiswa
        if ($user && $user->role === 'mahasiswa') {
            $mahasiswa = $user->mahasiswaProfile;
        }

        $currentTahapan = \App\Models\Tahapan::getCurrentTahapan();
        $setting = Setting::first();

        // Sync setting with tahapan for consistency in views
        if ($currentTahapan && $setting) {
            $setting->voting_start = $currentTahapan->waktu_mulai;
            $setting->voting_end = $currentTahapan->waktu_selesai;
        }

        return view('mahasiswa.voting', [
            'kandidat' => Kandidat::all(),
            'setting' => $setting,
            'mahasiswa' => $mahasiswa,
            'currentTahapan' => $currentTahapan,
        ]);
    }

    public function vote($id)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/verifikasi?kandidat='.$id)->with('error', 'Silakan verifikasi NIM dan password Anda terlebih dahulu.');
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
            return back()->with('error', $scheduleName.' belum dimulai. Harap kembali pada '.$startTime->format('d M Y H:i'));
        }
        if ($endTime && $now->gt($endTime)) {
            return back()->with('error', $scheduleName.' sudah ditutup pada '.$endTime->format('d M Y H:i'));
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
                    'voted_at' => now(),
                    'vote_receipt' => encrypt([
                        'kandidat_id' => $id,
                        'kandidat_nama' => $kandidat->nama,
                        'vote_time' => now()->toDateTimeString(),
                    ]),
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Voting Error: '.$e->getMessage());

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
            $voteHash = strtoupper(substr(hash('sha256', $user->id.$receiptData['kandidat_id'].$voteTime->timestamp), 0, 16));

            $data = [
                'nim' => $mahasiswa->nim ?? 'N/A',
                'nama' => $user->name,
                'kandidat' => $kandidat,
                'vote_time' => $voteTime,
                'vote_hash' => $voteHash,
                'qr_data' => 'VOTE-VERIFICATION:'.$voteHash,
                'setting' => Setting::first(),
            ];

            $pdf = Pdf::loadView('pdf.vote-receipt', $data);
            $pdf->setPaper('a4', 'portrait');

            $filename = 'Bukti-Voting-'.($mahasiswa->nim ?? $user->id).'-'.now()->format('YmdHis').'.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('PDF Generation Error: '.$e->getMessage());

            return redirect('/voting')->with('error', 'Gagal membuat PDF: '.$e->getMessage());
        }
    }
}
