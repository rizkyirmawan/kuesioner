<?php

namespace App\Exports;

use App\Models\Kemahasiswaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapKemahasiswaanExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
    	$kemahasiswaan = Kemahasiswaan::all();

        return view('exports.rekapKemahasiswaan', compact('kemahasiswaan'));
    }
}
