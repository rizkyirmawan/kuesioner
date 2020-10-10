<?php

namespace App\Imports;

use App\Models\Dosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DosenImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Dosen::insert([
                'kode'          => $row['kd_dosen'],
                'nidn'          => $row['nidn'],
                'nama'          => $row['nama_dosen'],
                'nomor_telepon' => $row['nomor_telepon'],
                'alamat'        => $row['alamat']
            ]);
        }
    }
}
