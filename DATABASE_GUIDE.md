# 📊 DATABASE MANAGEMENT GUIDE - E-VOTING BEM

## Overview

Database E-Voting BEM telah dilengkapi dengan sistem manajemen user yang komprehensif untuk mengelola **Admin** dan **Mahasiswa**.

---

## 🗄️ DATABASE STRUCTURE

### 1. **users table** - Tabel Pengguna Utama

Menyimpan informasi login dan role dasar semua pengguna.

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255),
    role ENUM('admin', 'mahasiswa') DEFAULT 'mahasiswa',
    is_active BOOLEAN DEFAULT true,
    last_login TIMESTAMP NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX (role),
    INDEX (is_active)
)
```

**Kolom Penting:**

- `role`: Menentukan jenis user (admin/mahasiswa)
- `is_active`: Status aktif/nonaktif user
- `last_login`: Tracking login terakhir user

---

### 2. **admin_profiles table** - Profil Admin

Menyimpan detail informasi khusus admin.

```sql
CREATE TABLE admin_profiles (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT FOREIGN KEY,
    phone VARCHAR(255),
    department VARCHAR(255),
    address TEXT,
    city VARCHAR(255),
    province VARCHAR(255),
    postal_code VARCHAR(255),
    avatar VARCHAR(255),
    bio TEXT,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    appointed_at TIMESTAMP NULL,
    terminated_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX (user_id),
    INDEX (status),
    INDEX (department)
)
```

**Status Admin:**

- `active`: Admin aktif
- `inactive`: Admin tidak aktif
- `suspended`: Admin dibekukan

---

### 3. **mahasiswa_profiles table** - Profil Mahasiswa

Menyimpan detail informasi khusus mahasiswa.

```sql
CREATE TABLE mahasiswa_profiles (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT FOREIGN KEY,
    nim VARCHAR(255) UNIQUE,
    program_studi VARCHAR(255),
    angkatan VARCHAR(255),
    semester INTEGER DEFAULT 1,
    phone VARCHAR(255),
    address TEXT,
    city VARCHAR(255),
    province VARCHAR(255),
    postal_code VARCHAR(255),
    avatar VARCHAR(255),
    status ENUM('active', 'inactive', 'graduated', 'suspended') DEFAULT 'active',
    has_voted BOOLEAN DEFAULT false,
    voted_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX (user_id),
    INDEX (nim),
    INDEX (program_studi),
    INDEX (angkatan),
    INDEX (status),
    INDEX (has_voted)
)
```

**Status Mahasiswa:**

- `active`: Mahasiswa aktif, bisa voting
- `inactive`: Mahasiswa tidak aktif
- `graduated`: Mahasiswa lulus
- `suspended`: Mahasiswa dicurigai/dibekukan

**Voting Fields:**

- `has_voted`: Sudah melakukan voting atau belum
- `voted_at`: Waktu mahasiswa selesai voting

---

### 4. **votes table** - Tabel Voting

Menyimpan record suara yang diberikan.

```sql
CREATE TABLE votes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT FOREIGN KEY,
    kandidat_id BIGINT FOREIGN KEY,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
)
```

---

## 🔐 USER ROLES & PERMISSIONS

### Admin

- ✅ Akses ke semua data mahasiswa
- ✅ Buat/edit/hapus akun mahasiswa
- ✅ Buat/edit/hapus akun admin
- ✅ Lihat hasil voting
- ✅ Export data mahasiswa
- ✅ Reset voting status mahasiswa
- ❌ Tidak bisa vote

### Mahasiswa

- ✅ Lihat daftar kandidat
- ✅ Voting
- ✅ Lihat hasil voting
- ❌ Tidak bisa mengelola user

---

## 👤 DATA SAMPLE YANG TERSEDIA

### Default Admin Account

```
Email: admin@bem.ac.id
Password: admin12345
```

### Sample Mahasiswa Accounts

1. **Budi Santoso** (NIM: 19081234001)
    - Email: budi@student.ac.id
    - Password: password123

2. **Siti Nurhaliza** (NIM: 19081234002)
    - Email: siti@student.ac.id
    - Password: password123

3. **Ahmad Ridho** (NIM: 20081234001)
    - Email: ahmad@student.ac.id
    - Password: password123

4. **Diana Kusuma** (NIM: 20081234002)
    - Email: diana@student.ac.id
    - Password: password123

5. **Rahmat Wijaya** (NIM: 21081234001)
    - Email: rahmat@student.ac.id
    - Password: password123

---

## 🛠️ API & METHODS

### User Model Methods

#### Check User Role

```php
$user = Auth::user();

if ($user->isAdmin()) {
    // User adalah admin
}

if ($user->isMahasiswa()) {
    // User adalah mahasiswa
}
```

#### Check User Status

```php
if ($user->isActive()) {
    // User aktif
}
```

#### Update Last Login

```php
$user->updateLastLogin();
```

#### Get User Profile

```php
$profile = $user->getProfile(); // Auto-return admin atau mahasiswa profile
```

---

### AdminProfile Model Methods

#### Check Admin Status

```php
$admin = $user->adminProfile;

if ($admin->isActive()) {
    // Admin aktif
}
```

#### Get Full Address

```php
$address = $admin->full_address; // "Jalan..., Kota, Provinsi Kode"
```

---

### MahasiswaProfile Model Methods

#### Check If Voting

```php
$mahasiswa = $user->mahasiswaProfile;

if ($mahasiswa->has_voted) {
    // Sudah voting
    echo $mahasiswa->voted_at; // Waktu voting
}
```

#### Mark As Voted

```php
$mahasiswa->markAsVoted(); // Otomatis update has_voted & voted_at
```

#### Get Voting Status

```php
echo $mahasiswa->voting_status; // "Sudah Memilih pada 09-02-2026 14:30" atau "Belum Memilih"
```

---

## 📝 ROUTES UNTUK MANAGEMENT

### Admin Management Routes

```
GET    /admin/admins                      - List semua admin
GET    /admin/admins/create               - Form buat admin baru
POST   /admin/admins                      - Simpan admin baru
GET    /admin/admins/{id}                 - Detail admin
GET    /admin/admins/{id}/edit            - Form edit admin
PUT    /admin/admins/{id}                 - Update admin
DELETE /admin/admins/{id}                 - Hapus admin
PATCH  /admin/admins/{id}/toggle-status   - Enable/disable admin
```

### Mahasiswa Management Routes

```
GET    /admin/mahasiswa                   - List semua mahasiswa
GET    /admin/mahasiswa/create            - Form buat mahasiswa baru
POST   /admin/mahasiswa                   - Simpan mahasiswa baru
GET    /admin/mahasiswa/{id}              - Detail mahasiswa
GET    /admin/mahasiswa/{id}/edit         - Form edit mahasiswa
PUT    /admin/mahasiswa/{id}              - Update mahasiswa
DELETE /admin/mahasiswa/{id}              - Hapus mahasiswa
GET    /admin/mahasiswa/export/csv        - Export ke CSV
PATCH  /admin/mahasiswa/{id}/toggle-voting - Reset voting status
```

---

## 💾 SEEDING DATA

### Jalankan Seeder

```bash
php artisan db:seed --class=UserSeeder
```

### Output

```
User accounts created successfully!
Admin account: admin@bem.ac.id / admin12345
Mahasiswa accounts created: 5
```

---

## 🔄 RELASI DATABASE

```
users
  ├── hasOne → admin_profiles
  ├── hasOne → mahasiswa_profiles
  ├── hasOne → votes
  └── hasMany → votes (melalui user_id)

admin_profiles
  └── belongsTo → users

mahasiswa_profiles
  ├── belongsTo → users
  └── hasMany → votes (melalui user_id)

votes
  ├── belongsTo → users
  └── belongsTo → kandidats
```

---

## 📊 QUERY EXAMPLES

### Get All Active Mahasiswa

```php
$mahasiswa = MahasiswaProfile::where('status', 'active')->get();
```

### Get All Who Already Voted

```php
$voted = MahasiswaProfile::where('has_voted', true)->with('user')->get();
```

### Get Admin by Department

```php
$admins = AdminProfile::where('department', 'BEM Kesejahteraan')->get();
```

### Get Voting Stats

```php
$total = MahasiswaProfile::count();
$voted = MahasiswaProfile::where('has_voted', true)->count();
$percentage = ($voted / $total) * 100;
```

### Get Vote Details with Voter Info

```php
$votes = Vote::with('user', 'mahasiswa', 'kandidat')->get();
```

---

## ⚠️ IMPORTANT NOTES

1. **Password** harus di-hash sebelum disimpan

    ```php
    'password' => bcrypt($password)
    ```

2. **Role-based Access** - Gunakan middleware `admin` untuk protect routes

    ```php
    Route::middleware('admin')->group(function () {
        // Admin only routes
    });
    ```

3. **Foreign Keys** - Ensure relasi database konsisten
    - Hapus user akan menghapus profile dan votes

4. **Voting Logic**
    - Sekali voting, tidak bisa voting lagi
    - Admin bisa reset voting status mahasiswa

5. **Index Fields** - Sudah di-optimize dengan indexes pada:
    - role, is_active, status, has_voted
    - Untuk faster queries

---

## 🚀 NEXT STEPS

1. **Update Views** - Buat halaman CRUD untuk admin management
2. **Export Features** - Implementasi export mahasiswa ke Excel
3. **Bulk Import** - Bisa upload mahasiswa dari CSV
4. **Audit Log** - Track perubahan admin & voting
5. **Notifications** - Email notifikasi mahasiswa yang belum voting
6. **Analytics** - Dashboard statistik voting

---

**Status**: ✅ Database fully setup dan siap digunakan!
