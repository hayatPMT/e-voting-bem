<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\MahasiswaProfile;
use App\Models\Setting;
use App\Models\Vote;
use App\Services\VoteEncryptionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        return view('mahasiswa.voting', [
            'kandidat' => Kandidat::all(),
            'setting' => Setting::first(),
            'mahasiswa' => $mahasiswa,
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
        if (Vote::where('user_id', $userId)->exists()) {
            return back()->with('error', 'Anda sudah memilih');
        }

        $setting = Setting::first();
        $now = Carbon::now();

        if ($setting) {
            if ($now->lt($setting->voting_start)) {
                return back()->with('error', 'Voting belum dimulai. Harap kembali pada '.$setting->voting_start->format('d M Y H:i'));
            }
            if ($now->gt($setting->voting_end)) {
                return back()->with('error', 'Voting sudah ditutup pada '.$setting->voting_end->format('d M Y H:i'));
            }
        }

        // Create encrypted vote record
        $encryptionService = new VoteEncryptionService;

        Vote::create([
            'user_id' => $userId,
            'kandidat_id' => $id, // Keep for backward compatibility during transition
            'encrypted_kandidat_id' => $encryptionService->encryptKandidatId($id),
            'vote_hash' => $encryptionService->generateVoteHash($userId, $id),
        ]);

        // Mark mahasiswa as voted
        $mahasiswa = MahasiswaProfile::where('user_id', $userId)->first();
        if ($mahasiswa) {
            $mahasiswa->markAsVoted();
        }

        $kandidat = Kandidat::find($id);

        return redirect('/voting')->with([
            'success' => 'Vote Anda berhasil disimpan. Terima kasih telah berpartisipasi!',
            'voted_candidate' => $kandidat,
            'vote_time' => now(),
            'vote_hash' => substr(hash('sha256', $userId.$id.now()->timestamp), 0, 16),
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

        // Get vote record
        $vote = $user->vote;

        if (! $vote) {
            return redirect('/voting')->with('error', 'Anda belum melakukan voting.');
        }

        // Get voted candidate from vote record (not from session)
        $kandidat = Kandidat::find($vote->kandidat_id);

        if (! $kandidat) {
            return redirect('/voting')->with('error', 'Data kandidat tidak ditemukan.');
        }

        $mahasiswa = $user->mahasiswaProfile;
        $voteTime = $vote->created_at;

        // Generate vote hash for verification
        $voteHash = strtoupper(substr(hash('sha256', $user->id.$vote->kandidat_id.$voteTime->timestamp), 0, 16));

        $data = [
            'nim' => $mahasiswa->nim ?? 'N/A',
            'nama' => $user->name,
            'kandidat' => $kandidat,
            'vote_time' => $voteTime,
            'vote_hash' => $voteHash,
            'qr_data' => 'VOTE-VERIFICATION:'.$voteHash,
            'setting' => Setting::first(),
        ];

        try {
            $pdf = Pdf::loadView('pdf.vote-receipt', $data);
            $pdf->setPaper('a4', 'portrait');

            $filename = 'Bukti-Voting-'.($mahasiswa->nim ?? $user->id).'-'.now()->format('YmdHis').'.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: '.$e->getMessage());

            return redirect('/voting')->with('error', 'Gagal membuat PDF. Silakan coba lagi atau hubungi admin.');
        }
    }
}
