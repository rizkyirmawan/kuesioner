<?php

namespace App\Http\Controllers;

use App\Models\Kemahasiswaan;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
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
        
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

    	$kemahasiswaan = Kemahasiswaan::where('tahun_ajaran', $tahunAjaran->id)
                            ->get();

    	return view('kuesioner.kemahasiswaan.index', compact('title', 'kemahasiswaan'));
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
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

    	$request->request->add([
    		'user_id' => auth()->user()->id,
            'tahun_ajaran' => $tahunAjaran->id
    	]);

    	$kemahasiswaan = Kemahasiswaan::create($request->all());

        $data = [
            ['pertanyaan' => 'Pelayanan administrasi akademik dan kemahasiswaan STMIK Bandung.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Sikap pelayanan staff layanan akademik.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Pelaksanaan bimbingan kegiatan kemahasiswaan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Pelaksanaan bimbingan akademik mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Ketertarikan untuk mengikuti kegiatan bimbingan akademik.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Ketertarikan untuk mengikuti kegiatan bimbingan kegiatan kemahasiswaan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Manfaat dan kinerja organisasi kemahasiswaan STMIK Bandung.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Pengaruh keberadaan dan kinerja organisasi mahasiswa terhadap motivasi belajar anda.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Keaktifan anda dalam mengikuti kegiatan ekstrakurikuler di STMIK Bandung.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Penyebaran Informasi dan layanan beasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Penyebaran informasi kegiatan dan lomba kemahasiswaan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kondisi sarana perkuliahan di STMIK Bandung.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kondisi sarana praktikum di STMIK Bandung.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kenyamanan situasi belajar di STMIK Bandung yang dapat memotivasi berkajar mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kondisi tempat istirahat mahasiswa di lingkungan STMIK Bandung.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Hubungan personal di bagian kerumahtanggaan (satpam, cleaning service dan office boy) untuk kenyamanan mahasiswa menuntut ilmu.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kondisi tempat parkir.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kondisi sarana peribadahan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kondisi sarana perpustakaan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kondisi sarana toilet.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kondisi sarana konsultasi.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Kondisi penunjang kegiatan kemahasiswaan.', 'tipe' => 'Radio']
        ];

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

    	$kemahasiswaan->load(['tahunAjaran']);

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
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();
    	
    	$request->request->add([
    		'user_id' => auth()->user()->id,
            'tahun_ajaran' => $tahunAjaran->id
    	]);

    	$kemahasiswaan->update($request->all());

    	return redirect()->route('kemahasiswaan.show', ['kemahasiswaan' => $kemahasiswaan])->with('success', 'Data kuesioner layanan mahasiswa berhasil diubah.');
    }

    // Destroy
    public function destroy(Kemahasiswaan $kemahasiswaan)
    {
    	$kemahasiswaan->pertanyaan()->jawaban()->delete();

        $kemahasiswaan->responden()->respons()->delete();

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
