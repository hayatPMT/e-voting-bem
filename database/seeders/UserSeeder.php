<?php

namespace Database\Seeders;

use App\Models\AdminProfile;
use App\Models\Kampus;
use App\Models\MahasiswaProfile;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Default Kampus
        $kampusUtama = Kampus::create([
            'nama' => 'Universitas Indonesia',
            'kode' => 'UI',
            'kota' => 'Depok',
            'primary_color' => '#f5a623',
            'secondary_color' => '#1a1a2e',
            'is_active' => true,
        ]);

        // 2. Create Super Admin
        $superadmin = User::create([
            'name' => 'SUPER ADMIN',
            'email' => 'superadmin@bem.ac.id',
            'password' => Hash::make('superadmin123'),
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // 3. Create default admin user untuk Kampus Utama
        $admin = User::create([
            'name' => 'Admin Kampus UI',
            'email' => 'admin@ui.ac.id',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
            'kampus_id' => $kampusUtama->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create admin profile
        AdminProfile::create([
            'user_id' => $admin->id,
            'phone' => '08123456789',
            'department' => 'BEM Kesejahteraan',
            'status' => 'active',
        ]);

        // Create sample mahasiswa users
        $mahasiswaData = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@student.ac.id',
                'nim' => '19081234001',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => '2019',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@student.ac.id',
                'nim' => '19081234002',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => '2019',
            ],
            [
                'name' => 'Ahmad Ridho',
                'email' => 'ahmad@student.ac.id',
                'nim' => '20081234001',
                'program_studi' => 'Teknik Elektro',
                'angkatan' => '2020',
            ],
            [
                'name' => 'Diana Kusuma',
                'email' => 'diana@student.ac.id',
                'nim' => '20081234002',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => '2020',
            ],
            [
                'name' => 'Rahmat Wijaya',
                'email' => 'rahmat@student.ac.id',
                'nim' => '21081234001',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => '2021',
            ],
        ];

        foreach ($mahasiswaData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['nim']), // Password = NIM
                'role' => 'mahasiswa',
                'kampus_id' => $kampusUtama->id,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            MahasiswaProfile::create([
                'user_id' => $user->id,
                'nim' => $data['nim'],
                'program_studi' => $data['program_studi'],
                'angkatan' => $data['angkatan'],
                'semester' => 5,
                'phone' => '08'.rand(100000000, 999999999),
                'status' => 'active',
                'has_voted' => false,
            ]);
        }

        // Create initial settings (Open for 24 hours) for Kampus Utama
        Setting::create([
            'kampus_id' => $kampusUtama->id,
            'voting_start' => now(),
            'voting_end' => now()->addHours(24),
        ]);

        $this->command->info('User accounts created successfully!');
        $this->command->info('Super Admin account: superadmin@bem.ac.id / superadmin123');
        $this->command->info('Admin account: admin@ui.ac.id / admin12345');
        $this->command->info('Mahasiswa accounts created: '.count($mahasiswaData).' in Kampus UI');
        $this->command->info('Settings initialized for Kampus UI (Voting Open for 24h)');
    }
}
