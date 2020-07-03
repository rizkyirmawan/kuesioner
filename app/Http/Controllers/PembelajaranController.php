<?php

namespace App\Http\Controllers;

use App\Models\Pembelajaran;
use App\Models\Studi;
use App\Http\Requests\KuesionerRequest;

class PembelajaranController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Kuesioner Pembelajaran';

    	$pembelajaran = Pembelajaran::with('studi')
    					->where('user_id', auth()->user()->id)
    					->get();

    	return view('kuesioner.pembelajaran.index', compact('title', 'pembelajaran'));
    }

    // Create
    public function create()
    {
    	$title = 'Tambah Data Kuesioner Pembelajaran';

    	$studi = Studi::with(['matkul', 'kelas'])
    				->where('dosen_id', auth()->user()->userable->id)
    				->get();

    	$pembelajaran = new Pembelajaran();

        // dd($pembelajaran->studi());

    	return view('kuesioner.pembelajaran.create', compact('title', 'pembelajaran', 'studi'));
    }

    // Store
    public function store(KuesionerRequest $request)
    {
    	$request->request->add([
    		'user_id' => auth()->user()->id,
    		'studi_id' => $request->studi
    	]);

    	$pembelajaran = Pembelajaran::create($request->only([
    		'user_id', 'studi_id', 'kuesioner', 'deskripsi'
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
    public function update(Pembelajaran $pembelajaran, KuesionerRequest $request)
    {
    	
    	$request->request->add([
    		'user_id' => auth()->user()->id,
    		'studi_id' => $request->studi
    	]);

    	$pembelajaran->update($request->only([
    		'user_id', 'studi_id', 'kuesioner', 'deskripsi'
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

        $collection = $pembelajaran->responden;

        $uniqueResponden = $collection->unique(function($item) {
            return $item['user_id'].$item['kuesionerable_id'];
        });

        return view('kuesioner.pembelajaran.respons', compact('title', 'pembelajaran', 'uniqueResponden'));
    }
}
