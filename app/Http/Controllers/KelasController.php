<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Http\Requests\KelasRequest;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Kelas';

    	$kelas = Kelas::orderBy('kode')->get();

    	return view('kelas.index', compact('title', 'kelas'));
    }

    // Create
    public function create()
    {
    	$title = 'Tambah Data Kelas';

    	$kelas = new Kelas();

    	return view('kelas.create', compact('title', 'kelas'));
    }

    // Store
    public function store(KelasRequest $request)
    {
    	Kelas::create($request->all());

    	return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambah.');
    }

    // Show
    public function show(Kelas $kelas)
    {
    	$title = 'Detail Kelas: ' . $kelas->kelas;

    	return view('kelas.show', compact('title', 'kelas'));
    }

    // Edit
    public function edit(Kelas $kelas)
    {
    	$title = 'Ubah Data Kelas: ' . $kelas->kelas;

    	return view('kelas.edit', compact('title', 'kelas'));
    }

    // Update
    public function update(Kelas $kelas, KelasRequest $request)
    {
    	$kelas->update($request->all());

    	return redirect()->route('kelas.show', ['kelas' => $kelas])->with('success', 'Data kelas berhasil diubah.');
    }

    // Destroy
    public function destroy(Kelas $kelas)
    {
    	if($kelas->mahasiswa->count() > 0) {
    		return 	redirect()
    				->route('kelas.show', ['kelas' => $kelas])
    				->with('error', 'Kelas ini mempunyai mahasiswa.');
    	}

    	$kelas->delete();

    	return 	redirect()
    			->route('kelas.index')
    			->with('success', 'Data kelas berhasil dihapus.');
    }
}
