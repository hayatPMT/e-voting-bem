<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create petugas daftar hadir users
        User::create([
            'name' => 'Petugas 1',
            'email' => 'petugas1@evoting.com',
            'password' => Hash::make('password'),
            'role' => 'petugas_daftar_hadir',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Petugas 2',
            'email' => 'petugas2@evoting.com',
            'password' => Hash::make('password'),
            'role' => 'petugas_daftar_hadir',
            'is_active' => true,
        ]);
    }
}
