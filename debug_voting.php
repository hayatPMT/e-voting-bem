<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== APP TIMEZONE ===\n";
echo config('app.timezone')."\n";

echo "\n=== CURRENT TIME ===\n";
echo 'now(): '.now()."\n";
echo 'now()->timestamp: '.now()->timestamp."\n";

echo "\n=== TAHAPAN ===\n";
$t = \App\Models\Tahapan::where('is_current', 1)->where('status', 'active')->first();
if ($t) {
    echo 'Found: '.$t->nama_tahapan."\n";
    echo 'waktu_mulai: '.$t->waktu_mulai."\n";
    echo 'waktu_selesai: '.$t->waktu_selesai."\n";
    echo 'waktu_mulai->timestamp: '.$t->waktu_mulai->timestamp."\n";
    echo 'waktu_selesai->timestamp: '.$t->waktu_selesai->timestamp."\n";
    echo 'isActive(): '.($t->isActive() ? 'YES - VOTING ACTIVE' : 'NO - VOTING NOT ACTIVE')."\n";
    echo 'now < mulai: '.(now()->lt($t->waktu_mulai) ? 'YES (too early)' : 'NO')."\n";
    echo 'now > selesai: '.(now()->gt($t->waktu_selesai) ? 'YES (too late)' : 'NO')."\n";
} else {
    echo "NO ACTIVE TAHAPAN FOUND\n";
    echo "All tahapan:\n";
    foreach (\App\Models\Tahapan::all() as $all) {
        echo "  id:{$all->id} nama:{$all->nama_tahapan} status:{$all->status} is_current:{$all->is_current}\n";
    }
}

echo "\n=== SETTING ===\n";
$s = \App\Models\Setting::first();
if ($s) {
    echo 'voting_start: '.$s->voting_start."\n";
    echo 'voting_end: '.$s->voting_end."\n";
} else {
    echo "NO SETTINGS FOUND\n";
}

echo "\n=== USERS (mahasiswa) ===\n";
$users = \App\Models\User::where('role', 'mahasiswa')->take(3)->get();
foreach ($users as $u) {
    $profile = $u->mahasiswaProfile;
    echo "id:{$u->id} name:{$u->name} has_voted:".($profile->has_voted ?? 'NULL')."\n";
    $att = \App\Models\AttendanceApproval::where('mahasiswa_id', $u->id)->whereDate('created_at', today())->first();
    echo '  attendance today: '.($att ? "id:{$att->id} status:{$att->status} token:{$att->session_token}" : 'NONE')."\n";
}
