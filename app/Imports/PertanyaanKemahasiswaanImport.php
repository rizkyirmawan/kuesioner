<?php

namespace App\Imports;

use App\Models\Pertanyaan\Kemahasiswaan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PertanyaanKemahasiswaanImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
        	Kemahasiswaan::insert(['pertanyaan' => $row['pertanyaan']]);
    	}
    }
}
