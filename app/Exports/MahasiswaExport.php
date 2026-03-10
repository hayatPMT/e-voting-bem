<?php

namespace App\Exports;

use App\Models\MahasiswaProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    /**
     * @param  int  $kampusId  Campus ID to export data for
     */
    public function __construct(public readonly int $kampusId) {}

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MahasiswaProfile::whereHas('user', function ($q) {
            $q->where('kampus_id', $this->kampusId);
        })->with('user')->orderBy('id')->get();
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Lengkap',
            'Email',
            'Program Studi',
            'Angkatan',
            'Semester',
            'Status Akun',
            'Status Voting',
            'Tanggal Voting',
        ];
    }

    public function map($m): array
    {
        return [
            $m->nim,
            $m->user->name ?? '',
            $m->user->email ?? '',
            $m->program_studi,
            $m->angkatan,
            $m->semester,
            $m->status,
            $m->has_voted ? 'Sudah Memilih' : 'Belum Memilih',
            $m->voted_at?->format('d/m/Y') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF4F46E5']],
            ],
        ];
    }
}
