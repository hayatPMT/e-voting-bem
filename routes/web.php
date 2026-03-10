<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampusAuthController;
use App\Http\Controllers\CampusPortalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PetugasAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SuperAdmin\AdminKampusController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\KampusController;
use App\Http\Controllers\TahapanController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\VotingBoothController;
use App\Http\Controllers\VotingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// =========================================================================
// ROOT & SUPER ADMIN GLOBAL ROUTES
// =========================================================================

// Root: Redirect to campus selection or super admin dashboard
Route::get('/', function () {
    if (Auth::check() && Auth::user()->isSuperAdmin()) {
        return redirect()->route('superadmin.dashboard');
    }

    // Show a list of campuses to choose from (fallback for direct access)
    $kampuses = \App\Models\Kampus::where('is_active', true)->get();

    return view('select_kampus_awal', compact('kampuses'));
})->name('landing');

// Global Super Admin login (not campus-specific)
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Public chart (global)
Route::get('/chart', [PublicController::class, 'index'])->name('public.chart');

// =========================================================================
// LEGACY AUTH ROUTES (keep for backward compat with existing admin accounts)
// =========================================================================
Route::get('/verifikasi', [VerifikasiController::class, 'show'])->name('verifikasi');
Route::post('/verifikasi', [VerifikasiController::class, 'verify']);

// Petugas Daftar Hadir Routes (legacy global)
Route::get('/petugas/login', [PetugasAuthController::class, 'showLoginForm'])->name('petugas.login')->middleware('guest');
Route::post('/petugas/login', [PetugasAuthController::class, 'login']);
Route::get('/petugas/logout', [PetugasAuthController::class, 'logout'])->name('petugas.logout')->middleware('auth');

// =========================================================================
// VOTING ROUTES (Mahasiswa - Auth Required)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/voting', [VotingController::class, 'index'])->name('voting.index');
    Route::get('/vote/{id}', [VotingController::class, 'vote'])->name('voting.vote');
    Route::get('/vote-abstain', [VotingController::class, 'abstain'])->name('voting.abstain');
    Route::get('/vote-receipt/download', [VotingController::class, 'downloadReceipt'])->name('voting.receipt.download');
    Route::post('/voting/confirm-attendance', [VotingController::class, 'confirmAttendance'])->name('voting.confirm-attendance');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// =========================================================================
// PETUGAS MANAGEMENT (Attendance)
// =========================================================================
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

// =========================================================================
// ADMIN MANAGEMENT ROUTES
// =========================================================================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/rekap', [RekapController::class, 'index'])->name('admin.rekap');
    Route::get('/admin/attendance', [RekapController::class, 'attendanceReport'])->name('admin.attendance.index');
    Route::get('/admin/attendance/export', [RekapController::class, 'exportAttendance'])->name('admin.attendance.export');

    Route::get('/admin/kandidat', [KandidatController::class, 'index'])->name('admin.kandidat.index');
    Route::get('/admin/kandidat/create', [KandidatController::class, 'create'])->name('admin.kandidat.create');
    Route::post('/admin/kandidat', [KandidatController::class, 'store'])->name('admin.kandidat.store');
    Route::get('/admin/kandidat/{id}/edit', [KandidatController::class, 'edit'])->name('admin.kandidat.edit');
    Route::put('/admin/kandidat/{id}', [KandidatController::class, 'update'])->name('admin.kandidat.update');
    Route::delete('/admin/kandidat/{id}', [KandidatController::class, 'destroy'])->name('admin.kandidat.destroy');

    Route::get('/admin/admins', [AdminController::class, 'index'])->name('admin.admins.index');
    Route::get('/admin/admins/create', [AdminController::class, 'create'])->name('admin.admins.create');
    Route::post('/admin/admins', [AdminController::class, 'store'])->name('admin.admins.store');
    Route::get('/admin/admins/{id}', [AdminController::class, 'show'])->name('admin.admins.show');
    Route::get('/admin/admins/{id}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admin/admins/{id}', [AdminController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admin/admins/{id}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');
    Route::patch('/admin/admins/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.admins.toggle-status');

    Route::get('/admin/mahasiswa', [MahasiswaController::class, 'index'])->name('admin.mahasiswa.index');
    Route::get('/admin/mahasiswa/create', [MahasiswaController::class, 'create'])->name('admin.mahasiswa.create');
    Route::post('/admin/mahasiswa', [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
    Route::get('/admin/mahasiswa/export/csv', [MahasiswaController::class, 'export'])->name('admin.mahasiswa.export');
    Route::get('/admin/mahasiswa/template', [MahasiswaController::class, 'downloadTemplate'])->name('admin.mahasiswa.template');
    Route::get('/admin/mahasiswa/import', [MahasiswaController::class, 'importForm'])->name('admin.mahasiswa.importForm');
    Route::post('/admin/mahasiswa/import', [MahasiswaController::class, 'import'])->name('admin.mahasiswa.import');
    Route::get('/admin/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('admin.mahasiswa.show');
    Route::get('/admin/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
    Route::put('/admin/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
    Route::delete('/admin/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');
    Route::patch('/admin/mahasiswa/{id}/toggle-voting', [MahasiswaController::class, 'toggleVotingStatus'])->name('admin.mahasiswa.toggle-voting');

    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::put('/admin/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    Route::get('/admin/tahapan', [TahapanController::class, 'index'])->name('admin.tahapan.index');
    Route::get('/admin/tahapan/create', [TahapanController::class, 'create'])->name('admin.tahapan.create');
    Route::post('/admin/tahapan', [TahapanController::class, 'store'])->name('admin.tahapan.store');
    Route::get('/admin/tahapan/{id}/edit', [TahapanController::class, 'edit'])->name('admin.tahapan.edit');
    Route::put('/admin/tahapan/{id}', [TahapanController::class, 'update'])->name('admin.tahapan.update');
    Route::delete('/admin/tahapan/{id}', [TahapanController::class, 'destroy'])->name('admin.tahapan.destroy');
    Route::post('/admin/tahapan/{id}/set-current', [TahapanController::class, 'setAsCurrent'])->name('admin.tahapan.set-current');
    Route::patch('/admin/tahapan/{id}/status', [TahapanController::class, 'updateStatus'])->name('admin.tahapan.update-status');

    Route::get('/admin/voting-booths', [VotingBoothController::class, 'index'])->name('admin.voting-booths.index');
    Route::get('/admin/voting-booths/create', [VotingBoothController::class, 'create'])->name('admin.voting-booths.create');
    Route::post('/admin/voting-booths', [VotingBoothController::class, 'store'])->name('admin.voting-booths.store');
    Route::get('/admin/voting-booths/{id}/edit', [VotingBoothController::class, 'edit'])->name('admin.voting-booths.edit');
    Route::put('/admin/voting-booths/{id}', [VotingBoothController::class, 'update'])->name('admin.voting-booths.update');
    Route::delete('/admin/voting-booths/{id}', [VotingBoothController::class, 'destroy'])->name('admin.voting-booths.destroy');
    Route::patch('/admin/voting-booths/{id}/toggle-status', [VotingBoothController::class, 'toggleStatus'])->name('admin.voting-booths.toggle-status');

    Route::resource('/admin/petugas', \App\Http\Controllers\PetugasController::class, ['names' => 'admin.petugas']);
    Route::patch('/admin/petugas/{id}/toggle-status', [\App\Http\Controllers\PetugasController::class, 'toggleStatus'])->name('admin.petugas.toggle-status');
});

// =========================================================================
// SUPER ADMIN ROUTES
// =========================================================================
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

    // Kampus (Campus) Management
    Route::get('/kampus', [KampusController::class, 'index'])->name('kampus.index');
    Route::get('/kampus/create', [KampusController::class, 'create'])->name('kampus.create');
    Route::post('/kampus', [KampusController::class, 'store'])->name('kampus.store');
    Route::post('/kampus/exit-monitor', [KampusController::class, 'exitMonitor'])->name('kampus.exit-monitor');
    Route::get('/kampus/{kampus}', [KampusController::class, 'show'])->name('kampus.show');
    Route::get('/kampus/{kampus}/edit', [KampusController::class, 'edit'])->name('kampus.edit');
    Route::put('/kampus/{kampus}', [KampusController::class, 'update'])->name('kampus.update');
    Route::delete('/kampus/{kampus}', [KampusController::class, 'destroy'])->name('kampus.destroy');
    Route::patch('/kampus/{kampus}/toggle-status', [KampusController::class, 'toggleStatus'])->name('kampus.toggle-status');
    Route::post('/kampus/{kampus}/monitor', [KampusController::class, 'monitor'])->name('kampus.monitor');

    // Admin per-Kampus Management
    Route::get('/admins', [AdminKampusController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminKampusController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminKampusController::class, 'store'])->name('admins.store');
    Route::get('/admins/{id}/edit', [AdminKampusController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{id}', [AdminKampusController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{id}', [AdminKampusController::class, 'destroy'])->name('admins.destroy');
    Route::patch('/admins/{id}/toggle-status', [AdminKampusController::class, 'toggleStatus'])->name('admins.toggle-status');
});

// =========================================================================
// VOTING BOOTH (Public / Kiosk Mode)
// =========================================================================
Route::get('/booths', [VotingBoothController::class, 'portal'])->name('voting-booth.portal');
Route::get('/voting-booth/{id}/standby', [VotingBoothController::class, 'standby'])->name('voting-booth.standby');
Route::post('/voting-booth/validate', [VotingBoothController::class, 'validateToken'])->name('voting-booth.validate');
Route::get('/voting-booth/{id}/check', [VotingBoothController::class, 'checkStandby'])->name('voting-booth.check-standby');

// =========================================================================
// API: CHART REALTIME
// =========================================================================
Route::get('/api/chart', function (\Illuminate\Http\Request $request) {
    if ($request->has('kampus_id')) {
        $data = \App\Models\Kandidat::where('kampus_id', $request->kampus_id)->withCount('votes')->get();
    } else {
        $data = \App\Models\Kandidat::withCount('votes')->get();
    }

    return response()->json([
        'labels' => $data->pluck('nama'),
        'values' => $data->map(fn ($k) => ($k->votes_count ?? 0) + ($k->total_votes ?? 0)),
    ]);
});

// =========================================================================
// TEST/DEBUG ROUTES
// =========================================================================
if (config('app.debug')) {
    require __DIR__.'/test-pdf.php';
}

// =========================================================================
// CAMPUS PORTAL ROUTES (/{slug}/...)
// Middleware 'campus.portal' resolves Kampus from slug, aborts 404 if invalid
// VERY IMPORTANT: Kept at bottom of the file so {kampus_slug} does not
// overlap with real global routes like /dashboard or /login
// =========================================================================
Route::prefix('{kampus_slug}')
    ->middleware('campus.portal')
    ->name('campus.')
    ->group(function () {

        // Campus Portal: Landing / Mode Selection
        Route::get('/', [CampusPortalController::class, 'index'])->name('portal');
        Route::post('/select-mode', [CampusPortalController::class, 'selectMode'])->name('select-mode');

        // Campus Public: Voting Chart
        Route::get('/chart', [CampusPortalController::class, 'chart'])->name('chart');

        // Campus Admin Login
        Route::get('/login', [CampusAuthController::class, 'login'])->name('login')->middleware('guest');
        Route::post('/login', [CampusAuthController::class, 'authenticate'])->name('authenticate');

        // Campus Student Verification
        Route::get('/verifikasi', [CampusAuthController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/verifikasi', [CampusAuthController::class, 'verifikasiProcess'])->name('verifikasi.process');

        // Campus Petugas Login
        Route::get('/petugas/login', [CampusAuthController::class, 'petugasLogin'])->name('petugas.login')->middleware('guest');
        Route::post('/petugas/login', [CampusAuthController::class, 'petugasAuthenticate'])->name('petugas.authenticate');
    });
