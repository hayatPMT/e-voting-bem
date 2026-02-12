# IMPLEMENTASI SISTEM E-VOTING DENGAN MODE ONLINE/OFFLINE

## Status Implementasi

### ✅ Yang Sudah Dibuat:

#### 1. **Database Migrations** (4 files)

- `2026_02_12_032900_add_petugas_role_to_users_table.php` - Menambah role 'petugas_daftar_hadir'
- `2026_02_12_032901_create_tahapan_table.php` - Tabel untuk mengelola tahapan voting
- `2026_02_12_032902_create_voting_booths_table.php` - Tabel untuk kamar vote
- `2026_02_12_032903_create_attendance_approvals_table.php` - Tabel untuk daftar hadir offline

#### 2. **Models** (4 files)

- `Tahapan.php` - Model untuk tahapan voting dengan helper methods
- `VotingBooth.php` - Model untuk kamar vote
- `AttendanceApproval.php` - Model untuk approval daftar hadir
- `User.php` - Updated dengan method `isPetugas()` dan relationships

#### 3. **Controllers** (5 files)

- `TahapanController.php` - CRUD tahapan untuk admin
- `VotingBoothController.php` - CRUD kamar vote untuk admin
- `AttendanceController.php` - Manajemen daftar hadir untuk petugas
- `ModeSelectionController.php` - Pemilihan mode online/offline
- `PetugasAuthController.php` - Autentikasi petugas

#### 4. **Middleware**

- `PetugasMiddleware.php` - Validasi role petugas

#### 5. **Routes**

- ✅ Mode selection routes
- ✅ Petugas authentication routes
- ✅ Attendance management routes
- ✅ Tahapan management routes (admin)
- ✅ Voting booth management routes (admin)

#### 6. **Views**

- `mode-selection.blade.php` - Halaman pemilihan mode (DONE)
- `old-landing.blade.php` - Backup landing page lama (DONE)

---

## 📋 Yang Masih Perlu Dibuat:

### Views yang Diperlukan:

#### A. **Petugas Views** (folder: `resources/views/petugas/`)

1. `login.blade.php` - Halaman login petugas
2. `no-tahapan.blade.php` - Pesan ketika tidak ada tahapan aktif
3. **Subfolder `attendance/`**:
    - `index.blade.php` - Dashboard daftar hadir dengan pencarian mahasiswa
    - `voting.blade.php` - Halaman voting untuk mahasiswa (mode offline, tanpa login)

#### B. **Admin Views** (folder: `resources/views/admin/`)

1. **Subfolder `tahapan/`**:
    - `index.blade.php` - List semua tahapan
    - `create.blade.php` - Form buat tahapan baru
    - `edit.blade.php` - Form edit tahapan

2. **Subfolder `voting-booths/`**:
    - `index.blade.php` - List semua kamar vote
    - `create.blade.php` - Form buat kamar vote
    - `edit.blade.php` - Form edit kamar vote

#### C. **Update Admin Dashboard**

- Tambahkan menu navigasi untuk:
    - Tahapan Management
    - Voting Booths Management
    - Petugas Management (create/manage petugas users)

---

## 🔧 Langkah Selanjutnya:

### 1. **Jalankan Migrations**

```bash
php artisan migrate
```

### 2. **Register Middleware di `bootstrap/app.php`**

Tambahkan:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'petugas' => \App\Http\Middleware\PetugasMiddleware::class,
    ]);
})
```

### 3. **Buat Seeders untuk Testing**

- Seeder untuk user petugas
- Seeder untuk tahapan
- Seeder untuk voting booths

### 4. **Update Existing Views**

- Update admin sidebar/navigation untuk menu baru
- Update dashboard untuk menampilkan info tahapan aktif

---

## 📊 Alur Sistem Baru:

### **Mode Online:**

1. User buka `/` → Pilih "Mode Online"
2. Redirect ke `/verifikasi` (login mahasiswa dengan NIM)
3. Mahasiswa login dan voting seperti biasa

### **Mode Offline:**

1. User buka `/` → Pilih "Mode Offline"
2. Redirect ke `/petugas/login`
3. Petugas login dengan email/password
4. Petugas masuk ke dashboard daftar hadir
5. Petugas cari mahasiswa by NIM
6. Petugas approve mahasiswa dan pilih kamar vote
7. Sistem generate session token
8. Redirect ke halaman voting dengan token
9. Mahasiswa voting tanpa perlu login
10. Setelah vote, attendance status berubah jadi "voted"

### **Admin:**

1. Admin bisa mengelola tahapan di `/admin/tahapan`
2. Admin set tahapan mana yang aktif
3. Semua halaman mengecek tahapan aktif sebelum allow voting
4. Admin bisa mengelola kamar vote di `/admin/voting-booths`

---

## 🎯 Fitur Utama yang Sudah Terimplementasi:

✅ Role baru: `petugas_daftar_hadir`
✅ Tabel tahapan dengan status tracking
✅ Tabel voting booths untuk offline voting
✅ Tabel attendance approvals dengan session token
✅ Mode selection page (Online/Offline)
✅ Controllers untuk semua fitur
✅ Routes untuk semua fitur
✅ Middleware untuk petugas

---

## ⚠️ Catatan Penting:

1. **Session Token**: Digunakan untuk voting offline tanpa login, expired setelah digunakan
2. **Tahapan**: Hanya 1 tahapan yang bisa aktif di satu waktu (`is_current = true`)
3. **Attendance**: Mahasiswa hanya bisa approve 1x per hari
4. **Security**: Petugas hanya bisa approve, tidak bisa melihat pilihan mahasiswa

---

## 🚀 Next Steps untuk Anda:

1. Review semua file yang sudah dibuat
2. Jalankan migrations
3. Buat views yang masih kurang (saya bisa bantu)
4. Test seluruh flow
5. Tambahkan validasi tambahan jika diperlukan

Apakah Anda ingin saya lanjutkan membuat semua views yang masih kurang?
