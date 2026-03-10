<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaTemplateExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([
            [
                'nim' => '12345678',
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi@student.example.ac.id',
                'program_studi' => 'Teknik Informatika',
                'angkatan' => '2023',
                'semester' => '3',
            ],
            [
                'nim' => '87654321',
                'nama_lengkap' => 'Siti Rahayu',
                'email' => 'siti@student.example.ac.id',
                'program_studi' => 'Sistem Informasi',
                'angkatan' => '2022',
                'semester' => '5',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'nim',
            'nama_lengkap',
            'email',
            'program_studi',
            'angkatan',
            'semester',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF059669']],
                'borders' => ['bottom' => ['borderStyle' => 'thick']],
            ],
        ];
    }
}
