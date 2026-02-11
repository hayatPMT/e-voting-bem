<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\VotingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// Public: Landing Page (Role Selection)
Route::get('/', function () {
    return view('landing');
})->name('landing');

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
});

/*
|--------------------------------------------------------------------------
| API CHART (Realtime)
|--------------------------------------------------------------------------
*/
Route::get('/api/chart', function () {
    $data = \App\Models\Kandidat::withCount('votes')->get();

    return response()->json([
        'labels' => $data->pluck('nama'),
        'values' => $data->pluck('votes_count'),
    ]);
});

/*
|--------------------------------------------------------------------------
| TEST PDF ROUTE (TEMPORARY - FOR DEBUGGING)
|--------------------------------------------------------------------------
*/
if (config('app.debug')) {
    require __DIR__.'/test-pdf.php';
}
