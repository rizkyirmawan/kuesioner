<?php

namespace App\Http\Controllers;

use App\Models\Kemahasiswaan;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use App\Http\Requests\KemahasiswaanRequest;

class KemahasiswaanController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Kuesioner Layanan Mahasiswa';

    	$kemahasiswaan = Kemahasiswaan::all();

    	return view('kuesioner.kemahasiswaan.index', compact('title', 'kemahasiswaan'));
    }

    // Create
    public function create()
    {
    	$title = 'Tambah Kuesioner Layanan Mahasiswa';

    	$kemahasiswaan = new Kemahasiswaan();

    	$angkatanUnique = Mahasiswa::pluck('angkatan')
    						->unique()
    						->values()
    						->all();

    	return view('kuesioner.kemahasiswaan.create', compact('title', 'kemahasiswaan', 'angkatanUnique'));
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

        $kemahasiswaan->load(['pertanyaan.jawaban', 'responden.respons']);

        return view('kuesioner.kemahasiswaan.respons', compact('title', 'kemahasiswaan'));
    }
}
