<?php

namespace App\Exports;

use App\Models\Pembelajaran;
use App\Models\TahunAjaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapPembelajaranExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

        if (request()->dosen) {
        	$pembelajaran = Pembelajaran::select('pembelajaran.*')
                        ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                        ->where('studi.kode_dosen', request()->dosen)
                        ->where('pembelajaran.tahun_ajaran', $tahunAjaran->id)
                        ->get();
        } elseif (request()->matkul) {
        	$pembelajaran = Pembelajaran::select('pembelajaran.*')
                        ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                        ->where('studi.kode_matkul', request()->matkul)
                        ->where('pembelajaran.tahun_ajaran', $tahunAjaran->id)
                        ->get();
        } elseif (auth()->user()->role->role === 'Dosen') {
            $pembelajaran = Pembelajaran::select('pembelajaran.*')
                        ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                        ->where('studi.kode_dosen', auth()->user()->userable->kode)
                        ->where('pembelajaran.tahun_ajaran', $tahunAjaran->id)
                        ->get();
        } else {
	    	$pembelajaran = Pembelajaran::with('studi')
	    					->where('pembelajaran.tahun_ajaran', $tahunAjaran->id)
	    					->get();
        }

        return view('exports.rekapPembelajaran', compact('pembelajaran'));
    }
}
