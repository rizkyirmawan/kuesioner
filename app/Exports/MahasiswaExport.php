<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MahasiswaExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
    	$mahasiswa = Mahasiswa::all();

        return view('exports.exportMahasiswa', compact('mahasiswa'));
    }
}
