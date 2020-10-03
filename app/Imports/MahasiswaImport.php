<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Mahasiswa::create([
                'nim'           => $row['nim'],
                'nama'          => $row['nama_mahasiswa'],
                'alamat'        => $row['alamat'],
                'nomor_telepon' => $row['nomor_telepon'],
                'email'         => $row['email']
            ]);
        }
    }
}
