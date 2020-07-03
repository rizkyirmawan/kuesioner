<?php

namespace App\Http\Controllers;

use App\Models\Pembelajaran;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
	// Get Pembelajaran
    public function getPembelajaran()
    {
    	$title = 'Kuesioner Pembelajaran';

    	$pembelajaran = Pembelajaran::select('pembelajaran.*')
    					->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
    					->join('matkul', 'studi.matkul_id', '=', 'matkul.id')
    					->join('peserta_didik', 'matkul.id', '=', 'peserta_didik.matkul_id')
    					->join('kelas', 'studi.kelas_id', '=', 'kelas.id')
    					->join('mahasiswa', 'peserta_didik.mahasiswa_id', '=', 'mahasiswa.id')
    					->where('kelas.id', auth()->user()->userable->kelas_id)
    					->where('mahasiswa.id', auth()->user()->userable->id)
    					->get();

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
