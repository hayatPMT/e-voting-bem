<?php

namespace App\Imports;

use App\Models\User;
use App\Models\MahasiswaProfile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MahasiswaImport implements ToCollection, WithHeadingRow
{
 /**
  * @param Collection $rows
  */
 public function collection(Collection $rows)
 {
  // Use a simple loop to process rows, catching exceptions manually or relying on validation
  // But ToCollection is simpler if I want custom logic like transaction outside or inside.
  // Actually, let's use ToModel if simple, but we need two models: User and MahasiswaProfile.
  // So ToCollection is better to handle complex logic.

  foreach ($rows as $row) {
   // Skip if essential data is missing
   if (!isset($row['nim']) || !isset($row['email'])) {
    continue;
   }

   $nim = trim($row['nim']);
   $email = trim($row['email']);

   // Skip if already exists
   if (User::where('email', $email)->exists() || MahasiswaProfile::where('nim', $nim)->exists()) {
    continue;
   }

   // Create User
   $user = User::create([
    'name' => $row['nama_lengkap'] ?? $row['nama'] ?? 'Mahasiswa',
    'email' => $email,
    'password' => Hash::make($nim), // Default password is NIM
    'role' => 'mahasiswa',
    'is_active' => true,
    'email_verified_at' => now(),
   ]);

   // Create Profile
   MahasiswaProfile::create([
    'user_id' => $user->id,
    'nim' => $nim,
    'program_studi' => $row['program_studi'] ?? 'Umum',
    'angkatan' => $row['angkatan'] ?? date('Y'),
    'semester' => 1,
    'status' => 'active',
   ]);
  }
 }
}
