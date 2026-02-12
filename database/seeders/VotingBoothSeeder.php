<?php

namespace Database\Seeders;

use App\Models\VotingBooth;
use Illuminate\Database\Seeder;

class VotingBoothSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booths = [
            [
                'nama_booth' => 'Kamar Vote A',
                'lokasi' => 'Gedung Rektorat Lantai 1',
                'is_active' => true,
            ],
            [
                'nama_booth' => 'Kamar Vote B',
                'lokasi' => 'Gedung Rektorat Lantai 2',
                'is_active' => true,
            ],
            [
                'nama_booth' => 'Kamar Vote C',
                'lokasi' => 'Gedung Fakultas',
                'is_active' => true,
            ],
        ];

        foreach ($booths as $booth) {
            VotingBooth::create($booth);
        }
    }
}
