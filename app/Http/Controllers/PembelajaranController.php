<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Matkul;
use App\Models\Pembelajaran;
use App\Models\Studi;
use App\Models\TahunAjaran;
use App\Http\Requests\PembelajaranRequest;

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

        $pembelajaran->load(['pertanyaan.jawaban', 'responden.respons']);

        return view('kuesioner.pembelajaran.respons', compact('title', 'pembelajaran'));
    }
}
