<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\Pembelajaran;
use App\Models\Pertanyaan;
use App\Models\Studi;
use App\Models\TahunAjaran;
use App\Models\Pertanyaan\PertanyaanPembelajaran;
use App\Http\Requests\PembelajaranRequest;
use App\Exports\ResponsPembelajaranExport;
use App\Exports\RekapPembelajaranExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PembelajaranController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Kuesioner Pembelajaran';

        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

        $studiCount = Studi::where('tahun_ajaran', $tahunAjaran->id)->count();

        $pertanyaanPembelajaranCount = PertanyaanPembelajaran::count();

    	$pembelajaran = Pembelajaran::with('studi')
                        ->where('tahun_ajaran', $tahunAjaran->id)
                        ->get();

        $dosenUnik = $pembelajaran->unique('studi.kode_dosen')->map(function ($item) {
                            return [
                                'kode'  => $item->studi->dosen->kode,
                                'nama'  => $item->studi->dosen->nama
                            ];
                        });

        $matkulUnik = $pembelajaran->unique('studi.kode_matkul')->map(function ($item) {
                            return [
                                'kode'          => $item->studi->matkul->kode,
                                'mata_kuliah'   => $item->studi->matkul->mata_kuliah
                            ];
                        });

    	return view('kuesioner.pembelajaran.index', compact('title', 'pembelajaran', 'dosenUnik', 'matkulUnik', 'studiCount', 'pertanyaanPembelajaranCount'));
    }

    // Index for Dosen
    public function indexDosen()
    {
        $title = 'Data Kuesioner Pembelajaran';
        
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

        $pembelajaran = Pembelajaran::select('pembelajaran.*')
                        ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                        ->where('studi.kode_dosen', auth()->user()->userable->kode)
                        ->where('pembelajaran.tahun_ajaran', $tahunAjaran->id)
                        ->get();

        return view('kuesioner.pembelajaran.index', compact('title', 'pembelajaran'));
    }

    // Create
    public function create()
    {
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

    	$title = 'Tambah Data Kuesioner Pembelajaran';

    	$studi = Studi::with(['matkul', 'kelas'])
                    ->where('tahun_ajaran', $tahunAjaran->id)
                    ->get();

    	$pembelajaran = new Pembelajaran();

    	return view('kuesioner.pembelajaran.create', compact('title', 'pembelajaran', 'studi'));
    }

    // Store
    public function store(PembelajaranRequest $request)
    {
        $dataPertanyaan = collect(PertanyaanPembelajaran::all())->map(function($item) {
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

        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

        if ($request->studi === 'Semua') {
            ini_set('max_execution_time', 300);

            $tahunAjaran = TahunAjaran::where('aktif', 1)->first();

            $studiIds = Studi::where('tahun_ajaran', $tahunAjaran->id)
                        ->pluck('id')
                        ->values();

            $insertedPembelajaranIds = [];

            $dataPertanyaanBaru = [];

            $dataJawabanBaru = [];

            foreach ($studiIds as $id => $value) {
                $insertedPembelajaranIds[] = DB::table('pembelajaran')->insertGetId([
                    'user_id'       => auth()->user()->id,
                    'studi_id'      => $value,
                    'kuesioner'     => $request->kuesioner,
                    'deskripsi'     => $request->deskripsi,
                    'awal'          => $request->awal,
                    'akhir'         => $request->akhir,
                    'tahun_ajaran'  => $tahunAjaran->id,
                    'status'        => 1
                ]);
            }

            foreach ($insertedPembelajaranIds as $id => $value) {
                foreach ($dataPertanyaan as $pertanyaan) {
                    $pertanyaan['questionable_id'] = $value;
                    $pertanyaan['questionable_type'] = Pembelajaran::class;

                    $dataPertanyaanBaru[] = $pertanyaan;
                }
            }

            DB::transaction(function () use ($dataPertanyaanBaru, $dataJawaban, $dataJawabanBaru) {
                Pertanyaan::all()->last() ? $lastId = Pertanyaan::all()->last()->id : $lastId = 0;

                DB::table('pertanyaan')->insert($dataPertanyaanBaru);

                $pertanyaanIds = [];

                for ($i = 1; $i <= count($dataPertanyaanBaru); $i++) { 
                    array_push($pertanyaanIds, $lastId + $i);
                }

                foreach ($pertanyaanIds as $id => $value) {
                    foreach ($dataJawaban as $jawaban) {
                        $jawaban['pertanyaan_id'] = $value;

                        $dataJawabanBaru[] = $jawaban;
                    }
                }

                DB::table('jawaban')->insert($dataJawabanBaru);
            });

            return redirect()
                        ->route('pembelajaran.index')
                        ->with('success', 'Data kuesioner pembelajaran berhasil ditambah.');
        }

    	$pembelajaran = Pembelajaran::create($request->only([
    		'user_id', 'studi_id', 'kuesioner', 'deskripsi', 'tahun_ajaran', 'awal', 'akhir'
    	]));

        $pertanyaan = $pembelajaran
                        ->pertanyaan()
                        ->createMany($dataPertanyaan);

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
            'tahun_ajaran' => $tahunAjaran->id,
            'awal' => $request->awal,
            'akhir' => $request->akhir
    	]);

    	$pembelajaran->update($request->only([
    		'user_id', 'studi_id', 'kuesioner', 'deskripsi', 'tahun_ajaran', 'awal', 'akhir'
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

        $questions = $pembelajaran->pertanyaan->chunk(5);

        // dd($question);

        return view('kuesioner.pembelajaran.respons', compact('title', 'pembelajaran', 'questions'));
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
