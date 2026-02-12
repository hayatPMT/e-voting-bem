<?php

namespace Database\Seeders;

use App\Models\Tahapan;
use Illuminate\Database\Seeder;

class TahapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a sample tahapan for testing
        Tahapan::create([
            'nama_tahapan' => 'Pemilihan BEM 2026',
            'deskripsi' => 'Pemilihan Ketua dan Wakil Ketua BEM periode 2026-2027',
            'waktu_mulai' => now(),
            'waktu_selesai' => now()->addDays(7),
            'status' => 'active',
            'is_current' => true,
        ]);

        // Create future tahapan
        Tahapan::create([
            'nama_tahapan' => 'Pemilihan BEM 2027',
            'deskripsi' => 'Pemilihan Ketua dan Wakil Ketua BEM periode 2027-2028',
            'waktu_mulai' => now()->addMonths(12),
            'waktu_selesai' => now()->addMonths(12)->addDays(7),
            'status' => 'draft',
            'is_current' => false,
        ]);
    }
}
