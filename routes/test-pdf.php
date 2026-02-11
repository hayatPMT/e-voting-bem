<?php

// Temporary test route for PDF generation
Route::get('/test-pdf', function () {
    $user = \App\Models\User::where('role', 'mahasiswa')->whereHas('vote')->first();

    if (! $user || ! $user->vote) {
        return 'No user with vote found. Please vote first.';
    }

    $vote = $user->vote;
    $kandidat = \App\Models\Kandidat::find($vote->kandidat_id);

    if (! $kandidat) {
        return 'Kandidat not found';
    }

    $mahasiswa = $user->mahasiswaProfile;
    $voteTime = $vote->created_at;
    $voteHash = strtoupper(substr(hash('sha256', $user->id.$vote->kandidat_id.$voteTime->timestamp), 0, 16));

    $data = [
        'nim' => $mahasiswa->nim ?? 'N/A',
        'nama' => $user->name,
        'kandidat' => $kandidat,
        'vote_time' => $voteTime,
        'vote_hash' => $voteHash,
        'qr_data' => 'VOTE-VERIFICATION:'.$voteHash,
    ];

    try {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.vote-receipt', $data);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('test-receipt.pdf');
    } catch (\Exception $e) {
        return 'Error: '.$e->getMessage().'<br><br>Trace: <pre>'.$e->getTraceAsString().'</pre>';
    }
})->name('test.pdf');
