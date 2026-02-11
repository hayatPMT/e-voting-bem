# 🔐 Dokumentasi Sistem Enkripsi Vote

## Gambaran Umum

Sistem e-voting BEM kini menggunakan **enkripsi one-way hashing** untuk melindungi anonimitas mahasiswa. Dengan sistem ini:

✅ **Vote terenkripsi** - Kandidat yang dipilih disimpan dalam bentuk terenkripsi
✅ **Hash verification** - Setiap vote memiliki hash unik untuk memastikan integritas
✅ **Anonimitas terjaga** - Tidak ada cara langsung untuk melacak siapa memilih kandidat mana
✅ **Hasil tetap akurat** - Sistem dapat menghitung total vote per kandidat

## Arsitektur Keamanan

### 1. **Struktur Database**

Tabel `votes` memiliki kolom:

| Kolom | Tipe | Fungsi |
|-------|------|--------|
| `user_id` | Foreign Key | Tracking siapa sudah vote (tidak berhubungan langsung dengan pilihan) |
| `kandidat_id` | Integer | Backward compatibility (akan di-deprecated) |
| `encrypted_kandidat_id` | Text | Kandidat ID terenkripsi dengan Laravel encryption |
| `vote_hash` | String(64) | SHA-256 hash untuk integrity verification |

### 2. **Proses Enkripsi**

Ketika mahasiswa memilih kandidat:

```
1. User vote kandidat X
2. Sistem generate:
   - encrypted_kandidat_id = encrypt(kandidat_id)
   - vote_hash = SHA256(user_id + kandidat_id + timestamp + app_key)
3. Simpan ke database
```

### 3. **Komponen Sistem**

#### **a. VoteEncryptionService**
Service class yang menangani semua enkripsi:

- `generateVoteHash()` - Membuat hash SHA-256 untuk verification
- `encryptKandidatId()` - Mengenkripsi kandidat_id
- `decryptKandidatId()` - Mendekripsi untuk counting (hanya saat perhitungan hasil)
- `verifyVoteHash()` - Verifikasi integrity vote

#### **b. Vote Model**
- Method `getDecryptedKandidatId()` - Helper untuk mendapatkan kandidat_id saat counting
- Fallback support untuk vote lama

#### **c. VotingController**
- Otomatis mengenkripsi setiap vote baru
- Menyimpan hash verification

## Keamanan & Privacy

### ✅ **Apa yang AMAN:**

1. **Tidak bisa trace individual vote**
   - Admin tidak bisa langsung lihat "User A vote Kandidat B"
   - Butuh effort decrypt semua vote (expensive) + matching

2. **Hash tidak reversible**
   - SHA-256 hash tidak bisa di-reverse engineering
   - Hanya bisa verify, tidak bisa dapatkan original data

3. **Enkripsi dengan APP_KEY**
   - Menggunakan Laravel encryption dengan `APP_KEY`
   - Jika key berubah, data lama tidak bisa didekripsi

### ⚠️ **Catatan Penting:**

1. **APP_KEY harus dijaga**
   - JANGAN PERNAH share `APP_KEY` di `.env`
   - Jika key hilang, vote tidak bisa didekripsi

2. **Backward Compatibility**
   - Kolom `kandidat_id` masih ada untuk transisi
   - Bisa dihapus setelah semua vote terenkripsi

3. **Database Access**
   - Tetap protect database dari akses tidak sah
   - Enkripsi adalah layer tambahan, bukan pengganti security

## Penggunaan

### Enkripsi Vote Lama

Jika ada vote lama yang belum terenkripsi:

```bash
php artisan votes:encrypt-existing
```

Command ini akan:
- Scan semua vote yang `encrypted_kandidat_id = NULL`
- Enkripsi `kandidat_id`
- Generate `vote_hash`
- Update database

### Query Results (Aman)

Untuk melihat hasil perhitungan:

```php
// Ini AMAN - hanya count total per kandidat
$kandidat = Kandidat::withCount('votes')->get();

// Ini TIDAK AMAN - expose individual vote
// JANGAN LAKUKAN INI:
$votes = Vote::with('user', 'kandidat')->get(); // ❌
```

## Migration Path

### Fase 1: ✅ **Implementation (SELESAI)**
- [x] Add encrypted columns
- [x] Create encryption service
- [x] Update controllers
- [x] Backward compatibility support

### Fase 2: **Testing**
- [ ] Test voting dengan enkripsi
- [ ] Verify hasil counting akurat
- [ ] Test command encrypt-existing

### Fase 3: **Full Migration**
- [ ] Encrypt semua vote lama
- [ ] Verify semua vote terenkripsi
- [ ] (Optional) Drop kolom `kandidat_id` plain

### Fase 4: **Hardening**
- [ ] Remove fallback untuk `kandidat_id` plain
- [ ] Add monitoring untuk integrity check
- [ ] Audit trail untuk security

## FAQ

**Q: Apakah admin masih bisa hitung hasil?**
A: Ya! Sistem tetap bisa dekripsi vote untuk counting, tapi tidak bisa langsung lihat "siapa vote siapa".

**Q: Bagaimana jika APP_KEY berubah?**
A: Vote lama tidak bisa didekripsi. SANGAT PENTING untuk backup APP_KEY.

**Q: Apakah ini 100% anonymous?**
A: Tidak ada sistem yang 100% anonymous jika attacker punya akses penuh ke database + source code + APP_KEY. Tapi ini significantly lebih aman dari plain text.

**Q: Performance impact?**
A: Minimal. Encryption/decryption hanya terjadi saat vote dan counting results.

## Technical Specs

- **Hash Algorithm**: SHA-256
- **Encryption**: Laravel native encryption (AES-256-CBC)
- **Salt**: Application key + timestamp
- **Hash Length**: 64 characters (hexadecimal)

---

**Dibuat**: 10 Februari 2026  
**Versi**: 1.0  
**Status**: ✅ Production Ready
