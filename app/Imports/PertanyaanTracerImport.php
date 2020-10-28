<?php

namespace App\Imports;

use App\Models\Pertanyaan\TracerStudy;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PertanyaanTracerImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
    	foreach ($rows as $row) {
        	TracerStudy::insert([
        		'pertanyaan' => $row['pertanyaan'],
        		'tipe' => $row['tipe']
        	]);
    	}
    }
}
