<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Http\Requests\TahunAjaranRequest;

class TahunAjaranController extends Controller
{
	// Index
    public function index()
    {
    	$title = 'Data Tahun Ajaran';

    	$tahunAjaran = TahunAjaran::all();

    	return view('tahunAjaran.index', compact('title', 'tahunAjaran'));
    }

    // Create
    public function create()
    {
    	$title = 'Tambah Data Tahun Ajaran';

    	$tahunAjaran = new TahunAjaran();

    	return view('tahunAjaran.create', compact('title', 'tahunAjaran'));
    }

    // Store
    public function store(TahunAjaranRequest $request)
    {
    	TahunAjaran::create($request->all());

    	return redirect()->route('tahunAjaran.index')->with('success', 'Data tahun ajaran berhasil ditambah.');
    }

    // Activate
    public function activate(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->update(['aktif' => 1]);

        TahunAjaran::where('id', '!=', $tahunAjaran->id)
                    ->where('aktif', '=', 1)
                    ->update(['aktif' => 0]);

    	return redirect()->route('tahunAjaran.index')->with('success', 'Data tahun ajaran berhasil diaktifkan.');
    }

    // Destroy
    public function destroy(TahunAjaran $tahunAjaran)
    {
    	if($tahunAjaran->pembelajaran->count() > 0) {
    		return 	redirect()
    				->route('tahunAjaran.index')
    				->with('error', 'Tahun ajaran ini mempunyai kuesioner yang terkait.');
    	}

    	$tahunAjaran->delete();

    	return 	redirect()
    			->route('tahunAjaran.index')
    			->with('success', 'Data tahun ajaran berhasil dihapus.');
    }
}
