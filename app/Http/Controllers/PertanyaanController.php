<?php

namespace App\Http\Controllers;

use App\Models\Pembelajaran;
use App\Models\Pertanyaan;
use App\Http\Requests\PertanyaanRequest;

class PertanyaanController extends Controller
{
	// Create Pembelajaran
    public function createPembelajaran(Pembelajaran $pembelajaran)
    {
    	$title = 'Tambah Pertanyaan';

    	return view('pertanyaan.create', compact('title', 'pembelajaran'));
    }

    // Store Pembelajaran
    public function storePembelajaran(PertanyaanRequest $request, Pembelajaran $pembelajaran)
    {
    	$pertanyaan = $pembelajaran
    					->pertanyaan()
    					->create($request->only('pertanyaan', 'tipe'));

    	if ($request->jawaban) {
	    	$pertanyaan->jawaban()->createMany($request->jawaban);
    	}

    	return redirect()
    			->route('pembelajaran.show', ['pembelajaran' => $pembelajaran])
    			->with('success', 'Pertanyaan berhasil ditambah.');
    }

    // Store Pembelajaran Default
    public function storePembelajaranDefault(Pembelajaran $pembelajaran)
    {
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
            ['jawaban' => 'Sangat Baik'],
            ['jawaban' => 'Baik'],
            ['jawaban' => 'Cukup Baik'],
            ['jawaban' => 'Kurang'],
            ['jawaban' => 'Sangat Kurang']
        ];

        $pertanyaan = $pembelajaran
                        ->pertanyaan()
                        ->createMany($data);

        foreach ($pertanyaan as $key) {   
            $key->jawaban()->createMany($dataJawaban);
        }

        $pembelajaran->update(['status' => 1]);

        return redirect()
                ->route('pembelajaran.show', ['pembelajaran' => $pembelajaran])
                ->with('success', 'Pertanyaan default berhasil ditambah.');
    }

    // Update Pembelajaran
    public function updatePembelajaran(Pembelajaran $pembelajaran, Pertanyaan $pertanyaan)
    {
        $pertanyaan->update(request()->only('pertanyaan'));

        return redirect()
                ->route('pembelajaran.show', ['pembelajaran' => $pembelajaran])
                ->with('success', 'Pertanyaan berhasil diubah.');
    }

    // Delete Pembelajaran
    public function destroyPembelajaran(Pembelajaran $pembelajaran, Pertanyaan $pertanyaan)
    {
        $pertanyaan->jawaban()->delete();

        $pertanyaan->respons()->delete();

        $pertanyaan->delete();

        return redirect()
                ->route('pembelajaran.show', ['pembelajaran' => $pembelajaran])
                ->with('success', 'Pertanyaan berhasil dihapus.');   
    }
}
