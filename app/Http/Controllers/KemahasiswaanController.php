<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kemahasiswaan;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use App\Models\Pertanyaan\PertanyaanKemahasiswaan;
use App\Http\Requests\KemahasiswaanRequest;
use App\Exports\ResponsKemahasiswaanExport;
use App\Exports\RekapKemahasiswaanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class KemahasiswaanController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Kuesioner Layanan Mahasiswa';

        $pertanyaanKemahasiswaanCount = PertanyaanKemahasiswaan::count();

    	$kemahasiswaan = Kemahasiswaan::all();

    	return view('kuesioner.kemahasiswaan.index', compact('title', 'kemahasiswaan', 'pertanyaanKemahasiswaanCount'));
    }

    // Create
    public function create()
    {
    	$title = 'Tambah Kuesioner Layanan Mahasiswa';

    	$kemahasiswaan = new Kemahasiswaan();

    	return view('kuesioner.kemahasiswaan.create', compact('title', 'kemahasiswaan'));
    }

    // Store
    public function store(KemahasiswaanRequest $request)
    {
        $today = Carbon::now();

    	$request->request->add([
    		'user_id' => auth()->user()->id,
            'tahun' => $today->year
    	]);

    	$kemahasiswaan = Kemahasiswaan::create($request->all());

        $data = collect(PertanyaanKemahasiswaan::all())->map(function($item) {
            $item['tipe'] = 'Radio';

            return $item->only(['pertanyaan', 'tipe']);
        })->toArray();

        $dataJawaban = [
            ['jawaban' => 'Sangat Baik', 'skor' => 5],
            ['jawaban' => 'Baik', 'skor' => 4],
            ['jawaban' => 'Cukup Baik', 'skor' => 3],
            ['jawaban' => 'Kurang', 'skor' => 2],
            ['jawaban' => 'Sangat Kurang', 'skor' => 1]
        ];

        $pertanyaan = $kemahasiswaan
                        ->pertanyaan()
                        ->createMany($data);

        foreach ($pertanyaan as $key) {   
            $key->jawaban()->createMany($dataJawaban);
        }

        $kemahasiswaan->update(['status' => 1]);

    	return redirect()->route('kemahasiswaan.index')->with('success', 'Data kuesioner layanan mahasiswa berhasil ditambah.');
    }

    // Show
    public function show(Kemahasiswaan $kemahasiswaan)
    {
    	$title = 'Detail Kuesioner Layanan Mahasiswa';

    	return view('kuesioner.kemahasiswaan.show', compact('title', 'kemahasiswaan'));
    }

    // Edit
    public function edit(Kemahasiswaan $kemahasiswaan)
    {
    	$title = 'Ubah Data Kuesioner';

    	$angkatanUnique = Mahasiswa::pluck('angkatan')
    						->unique()
    						->values()
    						->all();

    	return view('kuesioner.kemahasiswaan.edit', compact('title', 'kemahasiswaan', 'angkatanUnique'));
    }

    // Update
    public function update(Kemahasiswaan $kemahasiswaan, KemahasiswaanRequest $request)
    {
        $today = Carbon::now();
    	
    	$request->request->add([
    		'user_id' => auth()->user()->id,
            'tahun' => $today->year
    	]);

    	$kemahasiswaan->update($request->all());

    	return redirect()->route('kemahasiswaan.show', ['kemahasiswaan' => $kemahasiswaan])->with('success', 'Data kuesioner layanan mahasiswa berhasil diubah.');
    }

    // Destroy
    public function destroy(Kemahasiswaan $kemahasiswaan)
    {
        $kemahasiswaan->jawaban()->delete();

        $kemahasiswaan->respons()->delete();
        
    	$kemahasiswaan->pertanyaan()->delete();

        $kemahasiswaan->responden()->delete();

        $kemahasiswaan->delete();

    	return redirect()->route('kemahasiswaan.index')->with('success', 'Data kuesioner layanan mahasiswa berhasil dihapus.');
    }

    // Show Respons
    public function showRespons(Kemahasiswaan $kemahasiswaan)
    {
        $title = 'Respons Kuesioner Layanan Mahasiswa';

        $kemahasiswaan->load(['pertanyaan.jawaban', 'pertanyaan.respons', 'pertanyaan.respons.jawaban']);

        $questions = $kemahasiswaan->pertanyaan->chunk(5);

        return view('kuesioner.kemahasiswaan.respons', compact('title', 'kemahasiswaan', 'questions'));
    }

    // Export Respons
    public function exportRespons(Kemahasiswaan $kemahasiswaan)
    {
        $kode = Str::upper(Str::random(5));

        $kemahasiswaan->load(['pertanyaan.jawaban', 'pertanyaan.respons', 'pertanyaan.respons.jawaban']);

        return Excel::download(new ResponsKemahasiswaanExport($kemahasiswaan), $kode . '-LAYANAN-MHS-' . $kemahasiswaan->tahunAjaran->semester . '-' . $kemahasiswaan->tahunAjaran->tahun_ajaran . '.xlsx');
    }

    // Export Rekap
    public function exportRekap()
    {
        $kode = Str::upper(Str::random(5));

        return Excel::download(new RekapKemahasiswaanExport, $kode . '-REKAP-LAYANAN-MHS.xlsx');
    }
}
