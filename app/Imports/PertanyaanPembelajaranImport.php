<?php

namespace App\Imports;

use App\Models\Pertanyaan\Pembelajaran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PertanyaanPembelajaranImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
        	Pembelajaran::insert(['pertanyaan' => $row['pertanyaan']]);
    	}
    }
}
