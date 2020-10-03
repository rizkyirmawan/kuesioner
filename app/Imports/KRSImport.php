<?php

namespace App\Imports;

use App\Models\Matkul;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KRSImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            DB::table('peserta_didik')->insert([
                'nim'         => $row['nim'],
                'kode_matkul' => $row['kd_mk']
            ]);
        }
    }
}
