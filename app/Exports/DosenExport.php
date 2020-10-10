<?php

namespace App\Exports;

use App\Models\Dosen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DosenExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
    	$dosen = Dosen::all();

        return view('exports.exportDosen', compact('dosen'));
    }
}
