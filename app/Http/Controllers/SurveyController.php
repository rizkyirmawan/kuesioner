<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\TracerStudyMail;
use App\Models\Identitas;
use App\Models\Kemahasiswaan;
use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\Pembelajaran;
use App\Models\Studi;
use App\Models\TracerStudy;
use App\Models\TahunAjaran;
use App\Models\Pertanyaan\PertanyaanTracerStudy;
use App\Http\Requests\FormulirPerusahaanRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class SurveyController extends Controller
{
	// Get Pembelajaran
    public function getPembelajaran()
    {
    	$title = 'Kuesioner Pembelajaran';

        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

        $today = Carbon::now();

    	$data = Pembelajaran::select('pembelajaran.*')
                        ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                        ->join('matkul', 'studi.kode_matkul', '=', 'matkul.kode')
                        ->join('peserta_didik', 'matkul.kode', '=', 'peserta_didik.kode_matkul')
                        ->join('kelas', 'studi.kelas_id', '=', 'kelas.id')
                        ->join('mahasiswa', 'peserta_didik.nim', '=', 'mahasiswa.nim')
                        ->where('studi.kelas_id', auth()->user()->userable->kelas_id)
                        ->where('peserta_didik.nim', auth()->user()->userable->nim)
                        ->where('pembelajaran.tahun_ajaran', $tahunAjaran->id)
                        ->whereDate('awal', '<=', $today->format('Y-m-d'))
                        ->whereDate('akhir', '>=', $today->format('Y-m-d'))
                        ->get();

        $pembelajaran = collect($data)->unique()->values()->all();

    	return view('kuesioner.mahasiswa.pembelajaran.index', compact('title', 'pembelajaran'));
    }

    // Show Pembelajaran
    public function showPembelajaran(Pembelajaran $pembelajaran)
    {
        $title = 'Pengisian Kuesioner Pembelajaran';

        $counter = 0;

        $pembelajaran->load(['pertanyaan.jawaban']);

        $questions = $pembelajaran->pertanyaan->chunk(5);

        return view('kuesioner.mahasiswa.pembelajaran.show', compact('title', 'counter', 'pembelajaran', 'questions'));
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

    // Get Kemahasiswaan
    public function getKemahasiswaan()
    {
        $title = 'Kuesioner Layanan Mahasiswa';

        $today = Carbon::now();

        $data = Kemahasiswaan::whereDate('awal', '<=', $today->format('Y-m-d'))
                            ->whereDate('akhir', '>=', $today->format('Y-m-d'))
                            ->get();

        $kemahasiswaan = collect($data)->all();

        return view('kuesioner.mahasiswa.kemahasiswaan.index', compact('title', 'kemahasiswaan'));
    }

    // Show Kemahasiswaan
    public function showKemahasiswaan(Kemahasiswaan $kemahasiswaan)
    {
        $title = 'Pengisian Kuesioner Kemahasiswaan';

        $counter = 0;

        $kemahasiswaan->load(['pertanyaan.jawaban']);

        $questions = $kemahasiswaan->pertanyaan->chunk(5);

        return view('kuesioner.mahasiswa.kemahasiswaan.show', compact('title', 'counter', 'kemahasiswaan', 'questions'));
    }

    // Store Kemahasiswaan
    public function storeKemahasiswaan(Kemahasiswaan $kemahasiswaan)
    {
        $responden = $kemahasiswaan->responden()->create(['user_id' => auth()->user()->id]);

        $responden->respons()->createMany(request()->respons);

        $responden->respons()
                ->where('jawaban_id', null)
                ->where('jawaban_teks', null)
                ->delete();

        return redirect()
                ->route('mahasiswa.kemahasiswaan')
                ->with('success', 'Terimakasih atas tanggapannya.');
    }

    // Get Tracer Study Identitas
    public function getTracerStudyIdentitas(Identitas $identitas)
    {
        $title = 'Kuesioner Tracer Study';

        $today = Carbon::now();

        $pertanyaanTracerStudyCount = PertanyaanTracerStudy::count();

        $identitas = Identitas::where('tahun_lulus', auth()->user()->userable->tahun_lulus)
                        ->whereDate('awal', '<=', $today->format('Y-m-d'))
                        ->whereDate('akhir', '>=', $today->format('Y-m-d'))
                        ->first();

        $tracerStudy = TracerStudy::where('user_id', auth()->user()->id)->first();

        return view('kuesioner.alumni.tracerStudy.index', compact('title', 'identitas', 'tracerStudy', 'pertanyaanTracerStudyCount'));
    }

    // Create Tracer Study Identitas
    public function createTracerStudyIdentitas(Identitas $identitas)
    {
        $title = 'Kuesioner Tracer Study';

        return view('kuesioner.alumni.tracerStudy.create', compact('title', 'identitas'));
    }

    // Store Tracer Study Identitas
    public function storeTracerStudyIdentitas(Identitas $identitas, FormulirPerusahaanRequest $request)
    {
        $kode = Str::upper(Str::random(8));

        if ($request->bidang == 'IT') {
            $dataPertanyaan = collect(PertanyaanTracerStudy::orderBy('tipe', 'desc')->get())->map(function($item) {
                $item['tipe'] = 'Radio';

                return $item->only(['pertanyaan', 'tipe']);
            })->toArray();
        } else {
            $dataPertanyaan = collect(PertanyaanTracerStudy::where('tipe', '=', 'Non IT')->get())->map(function($item) {
                $item['tipe'] = 'Radio';

                return $item->only(['pertanyaan', 'tipe']);
            })->toArray();
        }

        $additionalQuestion = [
            ['pertanyaan' => 'Jabatan pengisi.', 'tipe' => 'Text'],
            ['pertanyaan' => 'Nama pengisi.', 'tipe' => 'Text']
        ];

        foreach ($additionalQuestion as $question) {
            array_unshift($dataPertanyaan, $question);
        }

        $dataJawaban = [
            ['jawaban' => 'Sangat Baik', 'skor' => 4],
            ['jawaban' => 'Baik', 'skor' => 3],
            ['jawaban' => 'Cukup', 'skor' => 2],
            ['jawaban' => 'Kurang', 'skor' => 1]
        ];        

        $request->request->add([
            'user_id'       => auth()->user()->id,
            'identitas_id'  => $identitas->id,
            'kode'          => $kode
        ]);

        $tracerStudy = TracerStudy::create($request->all());

        $pertanyaanTracerStudi = $tracerStudy->pertanyaan()->createMany($dataPertanyaan);

        foreach ($pertanyaanTracerStudi as $pertanyaan) {
            $pertanyaan->jawaban()->createMany($dataJawaban);
        }

        Mail::to($request->email_perusahaan)->send(new TracerStudyMail($tracerStudy));

        return redirect()
                ->route('alumni.tracerStudy')
                ->with('success', 'Terima kasih.');
    }

    // Get Tracer Study
    public function getTracerStudy()
    {
        auth()->logout();

        $title = 'Kuesioner Tracer Study';

        return view('kuesioner.tracerStudy.auth', compact('title'));
    }

    // Redirect Tracer Study
    public function redirectTracerStudy()
    {
        $uniqueKode = TracerStudy::pluck('kode')
                        ->unique()
                        ->values()
                        ->all();

        if (!request()->kode) {
            return back()->with('error', 'Silahkan isi dengan kode yang telah diberikan.');
        } else if (!in_array(request()->kode, $uniqueKode)) {
            return back()->with('error', 'Kode tidak valid.');
        }

        return redirect()->route('tracerStudy.show', ['tracerStudy' => request()->kode]);
    }

    // Show Tracer Study
    public function showTracerStudy(TracerStudy $tracerStudy)
    {
        $title = 'Pengisian Kuesioner Tracer Study';

        $counter = 0;

        $tracerStudy->load(['pertanyaan.jawaban']);

        $questions = $tracerStudy->pertanyaan->chunk(5);

        return view('kuesioner.tracerStudy.show', compact('title', 'counter', 'tracerStudy', 'questions'));
    }

    // Store Tracer Study
    public function storeTracerStudy(TracerStudy $tracerStudy)
    {
        $responden = $tracerStudy->responden()->create(['user_id' => null, 'username' => $tracerStudy->perusahaan]);

        $responden->respons()->createMany(request()->respons);

        $responden->respons()
                ->where('jawaban_id', null)
                ->where('jawaban_teks', null)
                ->delete();

        $tracerStudy->update(['status' => 1]);

        return back()->with('success', 'Terimakasih atas tanggapannya!');
    }
}
