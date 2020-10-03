<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\Pembelajaran;
use App\Models\Studi;
use App\Models\TahunAjaran;
use App\Http\Requests\PembelajaranRequest;
use App\Exports\ResponsPembelajaranExport;
use App\Exports\RekapPembelajaranExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class PembelajaranController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Kuesioner Pembelajaran';

    	$pembelajaran = Pembelajaran::with('studi')->get();

    	return view('kuesioner.pembelajaran.index', compact('title', 'pembelajaran'));
    }

    // Index for Dosen
    public function indexDosen()
    {
        $title = 'Data Kuesioner Pembelajaran';

        $pembelajaran = Pembelajaran::select('pembelajaran.*')
                        ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                        ->where('studi.dosen_id', auth()->user()->userable->id)
                        ->get();

        return view('kuesioner.pembelajaran.index', compact('title', 'pembelajaran'));
    }

    // Create
    public function create()
    {
    	$title = 'Tambah Data Kuesioner Pembelajaran';

    	$studi = Studi::with(['matkul', 'kelas'])->get();

    	$pembelajaran = new Pembelajaran();

    	return view('kuesioner.pembelajaran.create', compact('title', 'pembelajaran', 'studi'));
    }

    // Store
    public function store(PembelajaranRequest $request)
    {
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

    	$request->request->add([
    		'user_id' => auth()->user()->id,
    		'studi_id' => $request->studi,
            'tahun_ajaran' => $tahunAjaran->id
    	]);

    	$pembelajaran = Pembelajaran::create($request->only([
    		'user_id', 'studi_id', 'kuesioner', 'deskripsi', 'tahun_ajaran'
    	]));

        $data = [
            ['pertanyaan' => 'Dosen menjelaskan silabus di awal perkuliahan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menyampaikan informasi tentang tujuan pembelajaran yang akan dicapai. ', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menginformasikan kompetensi yang harus dicapai mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menjelaskan garis besar materi yang akan dipelajari selama satu semester pada awal perkuliahan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menjelaskan keterkaitan mata kuliahnya dengan mata kuliah lain.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menyampaikan sumber referensi yang digunakan dalam perkuliahan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menjelaskan komponen penilaian hasil belajar.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menjelaskan manfaat mata kuliah dalam kehidupan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen memasuki kelas dengan mengucapkan salam.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen memberikan motivasi belajar kepada mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen membangkitkan minat belajar mahasiswa untuk mengikuti perkuliahan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen mengupayakan partisipasi aktif mahasiswa dalam perkuliahan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen mengupayakan terjadinya interaksi belajar mahasiswa secara intensif.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menggunakan strategi pembelajaran yang mendorong rasa ingin tahu mahasiswa. ', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen memberikan jawaban atas pertanyaan mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menyampaikan materi kuliah secara terstruktur.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menguasai materi perkuliahan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen memberikan contoh yang relevan dengan materi perkuliahan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menerapkan model pembelajaran secara inovatif.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen memberikan tugas terstruktur kepada mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen memberikan bimbingan  terhadap tugas yang dikerjakan mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menggunakan media pembelajaran yang menarik dan bervariasi.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen mendorong mahasiswa untuk menggunakan teknologi informasi dan komunikasi dalam kegiatan pembelajaran.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen tegas dalam menerapkan aturan yang telah disepakati.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen bersikap ramah.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menunjukkan sikap arif dan bijaksana dalam mengambil keputusan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen mengendalikan emosi dalam melaksanakan pembelajaran.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen berlaku adil dalam memperlakukan mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen berpenampilan yang menarik.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen bersedia menerima saran dari mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menunjukkan toleransi terhadap keberagaman mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen melaksanakan perkuliahan sesuai dengan alokasi waktu yang ditetapkan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen memeriksa kehadiran mahasiswa setiap kali kuliah.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menilai secara transparan.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen memberikan kesempatan kepada mahasiswa untuk konfirmasi nilai.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen menilai secara adil dan objektif.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen memberikan penilaian terhadap sikap mahasiswa.', 'tipe' => 'Radio'],
            ['pertanyaan' => 'Dosen melakukan penilaian terhadap keterampilan mahasiswa.', 'tipe' => 'Radio'],
        ];

        $dataJawaban = [
            ['jawaban' => 'Sangat Baik', 'skor' => 5],
            ['jawaban' => 'Baik', 'skor' => 4],
            ['jawaban' => 'Cukup Baik', 'skor' => 3],
            ['jawaban' => 'Kurang', 'skor' => 2],
            ['jawaban' => 'Sangat Kurang', 'skor' => 1]
        ];

        $pertanyaan = $pembelajaran
                        ->pertanyaan()
                        ->createMany($data);

        foreach ($pertanyaan as $key) {   
            $key->jawaban()->createMany($dataJawaban);
        }

        $pembelajaran->update(['status' => 1]);

    	return redirect()->route('pembelajaran.index')->with('success', 'Data kuesioner pembelajaran berhasil ditambah.');
    }

    // Show
    public function show(Pembelajaran $pembelajaran)
    {
    	$title = 'Detail Kuesioner Pembelajaran';

    	$pembelajaran->load(['studi.kelas', 'studi.matkul', 'pertanyaan.jawaban']);

    	return view('kuesioner.pembelajaran.show', compact('title', 'pembelajaran'));
    }

    // Edit
    public function edit(Pembelajaran $pembelajaran)
    {
    	$title = 'Ubah Data Kuesioner';

    	$studi = Studi::with(['matkul', 'kelas'])
    				->where('dosen_id', auth()->user()->userable->id)
    				->get();

    	return view('kuesioner.pembelajaran.edit', compact('title', 'pembelajaran', 'studi'));
    }

    // Update
    public function update(Pembelajaran $pembelajaran, PembelajaranRequest $request)
    {
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();
    	
    	$request->request->add([
    		'user_id' => auth()->user()->id,
    		'studi_id' => $request->studi,
            'tahun_ajaran' => $tahunAjaran->id
    	]);

    	$pembelajaran->update($request->only([
    		'user_id', 'studi_id', 'kuesioner', 'deskripsi', 'tahun_ajaran'
    	]));

    	return redirect()->route('pembelajaran.show', ['pembelajaran' => $pembelajaran])->with('success', 'Data kuesioner pembelajaran berhasil diubah.');
    }

    // Destroy
    public function destroy(Pembelajaran $pembelajaran)
    {
    	$pembelajaran->pertanyaan()->jawaban()->delete();

        $pembelajaran->responden()->respons()->delete();

        $pembelajaran->delete();

    	return redirect()->route('pembelajaran.index')->with('success', 'Data kuesioner pembelajaran berhasil dihapus.');
    }

    // Show Respons
    public function showRespons(Pembelajaran $pembelajaran)
    {
        $title = 'Respons Kuesioner Pembelajaran';

        $pembelajaran->load(['pertanyaan.jawaban', 'pertanyaan.respons', 'pertanyaan.respons.jawaban']);

        return view('kuesioner.pembelajaran.respons', compact('title', 'pembelajaran'));
    }

    // Export Respons
    public function exportRespons(Pembelajaran $pembelajaran)
    {
        $kode = Str::upper(Str::random(5));

        $pembelajaran->load(['pertanyaan.jawaban', 'pertanyaan.respons', 'pertanyaan.respons.jawaban']);

        return Excel::download(new ResponsPembelajaranExport($pembelajaran), $kode . '-PEMBELAJARAN-' . Str::upper(Str::slug($pembelajaran->studi->matkul->mata_kuliah)) . '-' . Str::upper(Str::slug($pembelajaran->studi->kelas->kelas)) . '.xlsx');
    }

    // Export Rekap
    public function exportRekap()
    {
        $kode = Str::upper(Str::random(5));

        return Excel::download(new RekapPembelajaranExport, $kode . '-REKAP-PEMBELAJARAN.xlsx');
    }
}
