# 🗳️ MASTER DOCUMENTATION: SISTEM E-VOTING BEM

Dokumen ini berisi penjelasan menyeluruh mengenai arsitektur, database, alur proses, dan konfigurasi Sistem E-Voting BEM.

---

## 📑 DAFTAR ISI

1. [Gambaran Umum Sistem](#-gambaran-umum-sistem)
2. [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
3. [Arsitektur Database](#-arsitektur-database)
4. [Peran Pengguna (User Roles)](#-peran-pengguna-user-roles)
5. [Alur Proses (System Workflows)](#-alur-proses-system-workflows)
6. [Struktur Folder Proyek](#-struktur-folder-proyek)
7. [Konfigurasi & Instalasi](#-konfigurasi--instalasi)

---

## 🌐 GAMBARAN UMUM SISTEM

Sistem E-Voting BEM adalah platform berbasis web yang dirancang untuk mengotomatisasi proses pemilihan umum mahasiswa. Fokus utama sistem ini adalah **keamanan**, **transparansi (real-time)**, dan **kemudahan penggunaan**.

### Fitur Utama:

- **One-Vote Constraint**: Memastikan satu mahasiswa hanya bisa memilih satu kali.
- **Real-Time Analytics**: Grafik hasil suara yang diperbarui secara instan.
- **Bulk Data Management**: Fitur import data mahasiswa via CSV untuk efisiensi admin.
- **Reporting**: Fitur rekapitulasi dan export data hasil pemilihan.

---

## 🛠️ TEKNOLOGI YANG DIGUNAKAN

- **Core Framework**: Laravel 12 (PHP 8.4+)
- **Database**: MySQL / MariaDB
- **Frontend**: Vanilla CSS, JavaScript (ES6+), Blade Templating
- **Charts**: Chart.js (untuk visualisasi hasil real-time)
- **Code Quality**: Laravel Pint (Linter), Pest (Testing)

---

## 🗄️ ARSITEKTUR DATABASE

### 📊 Entity Relationship Diagram (Conceptual)

Sistem menggunakan relasi yang ketat untuk menjaga integritas data:

- `users` (1:1) `mahasiswa_profiles` / `admin_profiles`
- `users` (1:M) `votes`
- `kandidats` (1:M) `votes`

### 📋 Detail Tabel Utama:

1.  **`users`**: Menyimpan kredensial login (email/nim, password, role).
2.  **`mahasiswa_profiles`**:
    - Atribut: `nim`, `program_studi`, `angkatan`, `semester`.
    - Flag Penting: `has_voted` (boolean).
    - _Catatan Privasi_: Kolom `voted_at` dinonaktifkan untuk mencegah pelacakan waktu voting yang bisa dihubungkan dengan identitas pemilih.
    - Berfungsi menjaga agar mahasiswa tidak voting dua kali.
3.  **`admin_profiles`**: Profil tambahan untuk pengelola sistem.
4.  **`kandidats`**: Informasi pasangan calon (Nama, Visi, Misi, Foto).
5.  **`votes`**: Menyimpan rekaman suara. Hanya mencatat `user_id` dan `kandidat_id`.
6.  **`settings`**: Pengaturan global seperti `voting_start_date` dan `voting_end_date`.

---

## 👥 PERAN PENGGUNA (USER ROLES)

### 🎓 Mahasiswa (Voter)

- **Akses**: Halaman landing, verifikasi, dan voting.
- **Kapasitas**: Melakukan verifikasi NIM, melihat kandidat, memberikan satu suara, dan melihat hasil publik.
- **Batasan**: Setelah `has_voted` bernilai `true`, akses ke halaman voting akan ditutup (Redirect ke hasil).

### 👨‍💼 Admin (Organizer)

- **Akses**: Dashboard admin penuh.
- **Kapasitas**:
    - Kelola data kandidat (Tambah/Edit/Hapus).
    - Kelola data mahasiswa (Import CSV/Export).
    - Monitor suara masuk secara real-time.
    - Mengatur periode waktu pemilihan.
    - Reset password mahasiswa jika diperlukan.

---

## 🔄 ALUR PROSES (SYSTEM WORKFLOWS)

### A. Alur Voting Mahasiswa (The Happy Path - Privacy Focus)

1.  **Akses Landing Page**: Mahasiswa memilih menu "Mulai Voting".
2.  **Verifikasi NIM**: Memasukkan NIM dan Password.
3.  **Validasi Sistem**: Cek kredensial dan status `has_voted`.
4.  **Halaman Pemilihan**: Menampilkan Gallery Kandidat.
5.  **Submit Suara**: Klik 'Pilih' -> Konfirmasi.
6.  **Privacy Delay**: Sistem menyisipkan **jeda acak (0.5 - 2.5 detik)** sebelum menulis ke DB untuk memutus korelasi waktu antara aktivitas user dan penulisan data.
7.  **Submit Vote**: Data masuk ke tabel `votes` dengan `user_id` bernilai `null`.
8.  **Post-Processing**: Sistem mengubah `has_voted` menjadi `true`. Catatan waktu voting di profil mahasiswa **tidak disimpan**.
9.  **Selesai**: Redirect ke halaman Hasil Real-Time.

### C. Mekanisme Anonimitas Lanjutan (Periodic Shuffle)

Untuk keamanan tingkat tinggi, sistem menyediakan perintah:
`php artisan app:shuffle-votes`
yang berfungsi mengacak kembali seluruh _timestamp_ dan _hash_ di tabel `votes` secara berkala, sehingga urutan fisik data di database tidak lagi mencerminkan urutan waktu pemilihan yang sebenarnya.

### B. Alur Manajemen Admin

1.  **Persiapan Data**: Admin mengimport file CSV berisi ribuan data mahasiswa.
2.  **Input Kandidat**: Admin mengunggah foto dan detail visi-misi kandidat.
3.  **Monitoring**: Selama pemilihan berlangsung, admin memantau progres lewat Dashboard.
4.  **Rekapitulasi**: Setelah periode berakhir, admin mendownload laporan hasil suara.

---

## 📂 STRUKTUR FOLDER PROYEK

- `app/Http/Controllers/`: Logika utama (VotingController, AdminController, dll).
- `app/Models/`: Definisi tabel dan relasi database.
- `database/migrations/`: Cetak biru (blueprint) tabel database.
- `resources/views/`: File tampilan (UI) berbasis Blade.
- `routes/web.php`: Definisi semua alamat URL sistem.
- `public/`: Asset statis (CSS, Images, JS).

---

## ⚙️ KONFIGURASI & INSTALASI

### 1. File `.env`

Konfigurasi database diatur di sini:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=evoting_bem
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Langkah Instalasi (Development)

1.  **Clone/Copy folder** ke `htdocs`.
2.  **Install Dependencies**: `composer install` & `npm install`.
3.  **Setup Database**: Buat database baru di phpMyAdmin.
4.  **Migrate & Seed**: `php artisan migrate --seed` (untuk membuat tabel dan data awal).
5.  **Run System**: `php artisan serve` atau akses via `localhost/e-voting-bem/public`.

### 3. Keamanan Sistem

- **Middleware `auth`**: Melindungi halaman voting agar hanya bisa diakses mahasiswa terverifikasi.
- **Middleware `admin`**: Melindungi dashboard agar tidak bisa dibuka oleh mahasiswa biasa.
- **CSRF Protection**: Mencegah serangan _Cross-Site Request Forgery_ pada semua form.

---

## 📈 LOGIKA REAL-TIME CHART

Sistem menggunakan AJAX ke route `/api/chart` yang mengambil data dari `Kandidat::withCount('votes')`. Data ini kemudian diproses oleh **Chart.js** di frontend untuk memperbarui grafik batang/pie tanpa perlu refresh halaman.

---

_Dokumentasi ini dibuat untuk memudahkan pemeliharaan dan pengembangan sistem di masa depan._
