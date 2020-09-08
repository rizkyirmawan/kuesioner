<?php

namespace App\Http\Controllers;

use App\Models\Pembelajaran;
use App\Models\Studi;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
	// Get Pembelajaran
    public function getPembelajaran()
    {
    	$title = 'Kuesioner Pembelajaran';

    	$ds = Pembelajaran::select('pembelajaran.*')
                        ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                        ->join('matkul', 'studi.kode_matkul', '=', 'matkul.kode')
                        ->join('peserta_didik', 'matkul.kode', '=', 'peserta_didik.kode_matkul')
                        ->join('kelas', 'studi.kelas_id', '=', 'kelas.id')
                        ->join('mahasiswa', 'peserta_didik.nim', '=', 'mahasiswa.nim')
                        ->where('studi.kelas_id', auth()->user()->userable->kelas_id)
                        ->where('peserta_didik.nim', auth()->user()->userable->nim)
                        ->get();

        $pembelajaran = collect($ds)->unique()->values()->all();

        // dd($pembelajaran);

    	return view('kuesioner.mahasiswa.pembelajaran.index', compact('title', 'pembelajaran'));
    }

    // Show Pembelajaran
    public function showPembelajaran(Pembelajaran $pembelajaran)
    {
        $title = 'Pengisian Kuesioner Pembelajaran';

        $counter = 0;

        $pembelajaran->load(['pertanyaan.jawaban']);

        return view('kuesioner.mahasiswa.pembelajaran.show', compact('title', 'counter', 'pembelajaran'));
    }

    // Store Pembelajaran
    public function storePembelajaran(Pembelajaran $pembelajaran)
    {
        $responden = $pembelajaran->responden()->create(['user_id' => auth()->user()->id]);

        $responden->respons()->createMany(request()->respons);

        $responden->respons()
                ->where('jawaban_id', null)
                ->where('jawaban_teks', null)
                ->delete();

        return redirect()
                ->route('mahasiswa.pembelajaran')
                ->with('success', 'Terimakasih atas tanggapannya.');
    }
}
