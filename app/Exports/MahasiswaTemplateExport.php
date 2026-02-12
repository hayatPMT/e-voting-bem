<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MahasiswaTemplateExport implements WithHeadings, FromCollection
{
 /**
  * @return \Illuminate\Support\Collection
  */
 public function collection()
 {
  // Provide example data row
  return collect([
   [
    'nim' => '12345678',
    'nama_lengkap' => 'Contoh Mahasiswa',
    'email' => 'contoh@student.ac.id',
    'program_studi' => 'Teknik Informatika',
    'angkatan' => '2023',
   ],
  ]);
 }

 public function headings(): array
 {
  return [
   'NIM',
   'Nama Lengkap',
   'Email',
   'Program Studi',
   'Angkatan',
  ];
 }
}
