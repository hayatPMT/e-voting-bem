<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ModeSelectionController;
use App\Http\Controllers\PetugasAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TahapanController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\VotingBoothController;
use App\Http\Controllers\VotingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// Public: Mode Selection Page (Online/Offline)
Route::get('/', [ModeSelectionController::class, 'index'])->name('landing');
Route::post('/select-mode', [ModeSelectionController::class, 'selectMode'])->name('mode.select');

// Public: Old Landing Page (for backward compatibility)
Route::get('/old-landing', function () {
    return view('old-landing');
})->name('old.landing');

// Public: Viewers Page (Charts)
Route::get('/chart', [PublicController::class, 'index'])->name('public.chart');

// Voting Page: Mahasiswa Only (Logged In)
Route::middleware(['auth'])->group(function () {
    Route::get('/voting', [VotingController::class, 'index'])->name('voting.index');
    Route::get('/vote/{id}', [VotingController::class, 'vote'])->name('voting.vote');
    Route::get('/vote-receipt/download', [VotingController::class, 'downloadReceipt'])->name('voting.receipt.download');

    // Profile Management (untuk semua user yang login)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Verifikasi mahasiswa (NIM + password) untuk bisa memilih
Route::get('/verifikasi', [VerifikasiController::class, 'show'])->name('verifikasi');
Route::post('/verifikasi', [VerifikasiController::class, 'verify']);

// Admin auth routes (hanya untuk admin)
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);

// Logout (for admin)
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Petugas Daftar Hadir Routes
Route::get('/petugas/login', [PetugasAuthController::class, 'showLoginForm'])->name('petugas.login')->middleware('guest');
Route::post('/petugas/login', [PetugasAuthController::class, 'login']);
Route::get('/petugas/logout', [PetugasAuthController::class, 'logout'])->name('petugas.logout')->middleware('auth');

// Petugas Attendance Management (only for petugas_daftar_hadir role)
Route::middleware(['auth', 'petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/search', [AttendanceController::class, 'searchMahasiswa'])->name('attendance.search');
    Route::post('/attendance/approve', [AttendanceController::class, 'approve'])->name('attendance.approve');
    Route::post('/attendance/booth', [AttendanceController::class, 'setBooth'])->name('attendance.setBooth');
    Route::delete('/attendance/{id}/cancel', [AttendanceController::class, 'cancel'])->name('attendance.cancel');
});

// Voting Booth (Public Routes for Kiosk Mode)
Route::get('/voting-booth/session/{token}', [AttendanceController::class, 'showVotingPage'])->name('voting-booth.voting');
Route::post('/voting-booth/session/{token}', [AttendanceController::class, 'processVote'])->name('voting-booth.vote');

// Admin Management Routes (only for admin users)
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/rekap', [RekapController::class, 'index'])->name('admin.rekap');
    // Kandidat (calon)
    Route::get('/admin/kandidat', [KandidatController::class, 'index'])->name('admin.kandidat.index');
    Route::get('/admin/kandidat/create', [KandidatController::class, 'create'])->name('admin.kandidat.create');
    Route::post('/admin/kandidat', [KandidatController::class, 'store'])->name('admin.kandidat.store');
    Route::get('/admin/kandidat/{id}/edit', [KandidatController::class, 'edit'])->name('admin.kandidat.edit');
    Route::put('/admin/kandidat/{id}', [KandidatController::class, 'update'])->name('admin.kandidat.update');
    Route::delete('/admin/kandidat/{id}', [KandidatController::class, 'destroy'])->name('admin.kandidat.destroy');
    // Admin Management
    Route::get('/admin/admins', [AdminController::class, 'index'])->name('admin.admins.index');
    Route::get('/admin/admins/create', [AdminController::class, 'create'])->name('admin.admins.create');
    Route::post('/admin/admins', [AdminController::class, 'store'])->name('admin.admins.store');
    Route::get('/admin/admins/{id}', [AdminController::class, 'show'])->name('admin.admins.show');
    Route::get('/admin/admins/{id}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admin/admins/{id}', [AdminController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admin/admins/{id}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');
    Route::patch('/admin/admins/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.admins.toggle-status');

    // Mahasiswa Management
    Route::get('/admin/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
    Route::get('/admin/mahasiswa/create', [MahasiswaController::class, 'create'])->name('admin.mahasiswa.create');
    Route::post('/admin/mahasiswa', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
    Route::get('/admin/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('admin.mahasiswa.show');
    Route::get('/admin/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
    Route::put('/admin/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
    Route::delete('/admin/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');
    Route::get('/admin/mahasiswa/export/csv', [MahasiswaController::class, 'export'])->name('admin.mahasiswa.export');
    Route::get('/admin/mahasiswa/template', [MahasiswaController::class, 'downloadTemplate'])->name('admin.mahasiswa.template');
    Route::post('/admin/mahasiswa/import', [MahasiswaController::class, 'import'])->name('admin.mahasiswa.import');
    Route::patch('/admin/mahasiswa/{id}/toggle-voting', [MahasiswaController::class, 'toggleVotingStatus'])->name('admin.mahasiswa.toggle-voting');

    // Settings Management
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::put('/admin/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    // Tahapan Management
    Route::get('/admin/tahapan', [TahapanController::class, 'index'])->name('admin.tahapan.index');
    Route::get('/admin/tahapan/create', [TahapanController::class, 'create'])->name('admin.tahapan.create');
    Route::post('/admin/tahapan', [TahapanController::class, 'store'])->name('admin.tahapan.store');
    Route::get('/admin/tahapan/{id}/edit', [TahapanController::class, 'edit'])->name('admin.tahapan.edit');
    Route::put('/admin/tahapan/{id}', [TahapanController::class, 'update'])->name('admin.tahapan.update');
    Route::delete('/admin/tahapan/{id}', [TahapanController::class, 'destroy'])->name('admin.tahapan.destroy');
    Route::post('/admin/tahapan/{id}/set-current', [TahapanController::class, 'setAsCurrent'])->name('admin.tahapan.set-current');
    Route::patch('/admin/tahapan/{id}/status', [TahapanController::class, 'updateStatus'])->name('admin.tahapan.update-status');

    // Voting Booth Management
    Route::get('/admin/voting-booths', [VotingBoothController::class, 'index'])->name('admin.voting-booths.index');
    Route::get('/admin/voting-booths/create', [VotingBoothController::class, 'create'])->name('admin.voting-booths.create');
    Route::post('/admin/voting-booths', [VotingBoothController::class, 'store'])->name('admin.voting-booths.store');
    Route::get('/admin/voting-booths/{id}/edit', [VotingBoothController::class, 'edit'])->name('admin.voting-booths.edit');
    Route::put('/admin/voting-booths/{id}', [VotingBoothController::class, 'update'])->name('admin.voting-booths.update');
    Route::delete('/admin/voting-booths/{id}', [VotingBoothController::class, 'destroy'])->name('admin.voting-booths.destroy');
    Route::patch('/admin/voting-booths/{id}/toggle-status', [VotingBoothController::class, 'toggleStatus'])->name('admin.voting-booths.toggle-status');
});

// Voting Booth Standby & Validation (Public Access for Kiosk Mode)
Route::get('/booths', [VotingBoothController::class, 'portal'])->name('voting-booth.portal');
Route::get('/voting-booth/{id}/standby', [VotingBoothController::class, 'standby'])->name('voting-booth.standby');
Route::post('/voting-booth/validate', [VotingBoothController::class, 'validateToken'])->name('voting-booth.validate');
Route::get('/voting-booth/{id}/check', [VotingBoothController::class, 'checkStandby'])->name('voting-booth.check-standby');

/*
|--------------------------------------------------------------------------
| API CHART (Realtime)
|--------------------------------------------------------------------------
*/
Route::get('/api/chart', function () {
    $data = \App\Models\Kandidat::withCount('votes')->get();

    return response()->json([
        'labels' => $data->pluck('nama'),
        'values' => $data->map(fn($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0)),
    ]);
});

/*
|--------------------------------------------------------------------------
| TEST PDF ROUTE (TEMPORARY - FOR DEBUGGING)
|--------------------------------------------------------------------------
*/
if (config('app.debug')) {
    require __DIR__ . '/test-pdf.php';
}
