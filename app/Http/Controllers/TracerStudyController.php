<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Identitas;
use App\Models\TracerStudy;
use Illuminate\Http\Request;

class TracerStudyController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Kuesioner Tracer Study';

    	$tracerStudy = TracerStudy::with('user')->get();

    	$identitas = Identitas::all();

    	$angkatanUnique = Alumni::pluck('angkatan')
    						->unique()
    						->values()
    						->all();

    	return view('kuesioner.tracerStudy.index', compact('title', 'identitas', 'tracerStudy', 'angkatanUnique'));
    }

    // Create Identitas
    public function createIdentitas(Request $request)
    {
    	try {
    		Identitas::create($request->all());
    	} catch (\Exception $e) {
    		return back()->with('error', 'Silahkan pilih angkatan tertuju.');
    	}

    	return redirect()
    			->route('tracerStudy.index')
    			->with('success', 'Data kuesioner berhasil ditambah.');
    }

    public function showIdentitas(Identitas $identitas)
    {
        $title = 'Detail Kuesioner Tracer Study';

        $identitas->load(['tracerStudy']);

        return view('kuesioner.tracerStudy.showIdentitas', compact('title', 'identitas'));
    }

    // Show Respons
    public function showRespons(TracerStudy $tracerStudy)
    {
        $title = 'Respons Kuesioner Tracer Study';

        $tracerStudy->load(['pertanyaan.jawaban', 'responden.respons']);

        return view('kuesioner.tracerStudy.respons', compact('title', 'tracerStudy'));
    }
}
