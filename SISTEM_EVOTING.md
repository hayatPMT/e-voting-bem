# 🗳️ Dokumentasi Sistem E-Voting BEM

Selamat datang di dokumentasi resmi Sistem E-Voting BEM. Dokumen ini menjelaskan alur sistem, arsitektur, dan cara kerja aplikasi secara rinci namun mudah dipahami.

---

## 📑 Daftar Isi

1. [Gambaran Umum](#-gambaran-umum)
2. [Peran Pengguna (Roles)](#-peran-pengguna-roles)
3. [Alur Utama Pemilihan](#-alur-utama-pemilihan)
4. [Mode Pemilihan (Online & Offline)](#-mode-pemilihan-online--offline)
5. [Fitur Keamanan & Privasi](#-fitur-keamanan--privasi)
6. [Teknologi yang Digunakan](#-teknologi-yang-digunakan)

---

## 🌐 Gambaran Umum

Sistem E-Voting BEM adalah platform digital untuk pemungutan suara mahasiswa secara modern, transparan, dan aman. Sistem ini dirancang untuk memastikan prinsip **Jurdil (Jujur dan Adil)** dengan membatasi satu mahasiswa hanya satu suara (One-Vote Constraint) dan menyediakan hasil yang dapat dipantau secara langsung (Real-Time).

---

## 👥 Peran Pengguna (Roles)

### 1. 🎓 Mahasiswa (Voter)

Fokus utama sistem. Mahasiswa dapat melihat profil kandidat dan memberikan suara.

### 2. 👨‍💼 Petugas Daftar Hadir (Offline Clerk)

Bertugas memverifikasi kehadiran mahasiswa di lokasi pemilihan kartu fisik (Luring/Offline) dan memberikan akses ke bilik suara digital.

### 3. 🛡️ Admin (Organizer)

Pemegang kontrol penuh sistem, mulai dari manajemen data mahasiswa (Import CSV), manajemen kandidat, hingga pengaturan waktu voting.

---

## 🔄 Alur Utama Pemilihan

### A. Persiapan (Admin)

1. **Input Data**: Admin mengunggah data pemilih (mahasiswa) via file CSV dan mendaftarkan pasangan kandidat.
2. **Pengaturan Waktu**: Admin menetapkan jadwal mulai dan berakhirnya pemungutan suara.

### B. Pemungutan Suara (The Happy Path)

1. **Verifikasi**: Mahasiswa melakukan verifikasi identitas (NIM & Password).
2. **Pemilihan**: Mahasiswa melihat Galeri Kandidat (Foto, Visi, Misi) dan memilih salah satu.
3. **Konfirmasi**: Konfirmasi akhir dilakukan untuk memastikan pilihan sudah benar.
4. **Pencatatan**: Suara disimpan ke database secara anonim.

---

## 🗼 Mode Pemilihan (Online & Offline)

Sistem ini mendukung dua metode pemungutan suara yang terintegrasi:

### 1. Mode Online (Voting Mandiri)

Mahasiswa mengakses sistem dari perangkat masing-masing (HP/Laptop) dan masuk menggunakan akun NIM mereka. Cocok untuk mahasiswa yang berada di luar kampus.

### 2. Mode Offline (Bilik Suara di Kampus)

Digunakan untuk pemungutan suara di tempat (TPS Digital):

- **Langkah 1**: Mahasiswa datang ke meja petugas dan menunjukkan identitas.
- **Langkah 2**: Petugas mencari NIM mahasiswa di sistem dan melakukan "Approve".
- **Langkah 3**: Sistem memberikan akses ke bilik suara (Voting Booth) yang tersedia.
- **Langkah 4**: Mahasiswa menuju bilik dan memberikan suara tanpa perlu login kembali (menggunakan token sesi sementara).

---

## 🔒 Fitur Keamanan & Privasi

Sistem ini mengutamakan kerahasiaan pemilih melalui beberapa mekanisme:

- **Anonimitas Suara**: Tabel suara (`votes`) tidak menyimpan data siapa yang memilih siapa secara langsung dalam urutan waktu yang sama dengan data profil.
- **Batasan Satu Suara**: Sistem secara ketat mengecek flag `has_voted`. Begitu suara terkirim, akses untuk memilih lagi akan ditutup otomatis.
- **Enkripsi**: Data sensitif dilindungi dengan enkripsi standar industri.
- **Bukti Voting**: Setelah selesai, mahasiswa mendapatkan bukti voting digital (PDF) yang unik.

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12 (PHP 8.4)
- **Frontend**: Blade Templating, Vanilla CSS (Modern UI), JavaScript (ES6+)
- **Visualisasi**: Chart.js untuk grafik real-time.
- **Database**: MySQL/MariaDB dengan relasi data yang optimal.

---

_Dokumentasi ini disusun untuk memberikan pemahaman cepat bagi pengelola maupun pengembang sistem._
