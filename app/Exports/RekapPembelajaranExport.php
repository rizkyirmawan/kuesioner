<?php

namespace App\Exports;

use App\Models\Pembelajaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapPembelajaranExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
    	$pembelajaran = Pembelajaran::with('studi')->get();

        return view('exports.rekapPembelajaran', compact('pembelajaran'));
    }
}
