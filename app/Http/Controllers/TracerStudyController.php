<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Identitas;
use App\Models\TracerStudy;
use Illuminate\Http\Request;
use App\Exports\ResponsTracerStudyExport;
use App\Exports\RekapTracerStudyExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class TracerStudyController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Kuesioner Tracer Study';

    	$tracerStudy = TracerStudy::with('user')->get();

    	$identitas = Identitas::all();

    	$tahunLulus = Alumni::pluck('tahun_lulus')
    						->unique()
    						->values()
    						->all();

    	return view('kuesioner.tracerStudy.index', compact('title', 'identitas', 'tracerStudy', 'tahunLulus'));
    }

    // Create Identitas
    public function createIdentitas(Request $request)
    {
    	try {
    		Identitas::create($request->all());
    	} catch (\Exception $e) {
    		return back()->with('error', 'Silahkan pilih tahun lulus tertuju.');
    	}

    	return redirect()
    			->route('tracerStudy.index')
    			->with('success', 'Data kuesioner berhasil ditambah.');
    }

    // Show Identitas
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

    // Export Respons
    public function exportRespons(TracerStudy $tracerStudy)
    {
        $kode = Str::upper(Str::random(5));

        $tracerStudy->load(['pertanyaan.jawaban', 'pertanyaan.respons', 'pertanyaan.respons.jawaban']);

        return Excel::download(new ResponsTracerStudyExport($tracerStudy), $kode . '-TRACER-STUDY-' . Str::upper(Str::slug($tracerStudy->user->userable->nama)) . '.xlsx');
    }

    // Export Rekap
    public function exportRekap(Identitas $identitas)
    {
        $kode = Str::upper(Str::random(5));

        $identitas->load(['tracerStudy']);

        return Excel::download(new RekapTracerStudyExport($identitas), $kode . '-REKAP-TRACER-STUDY-' . $identitas->tahun_lulus . '.xlsx');
    }
}
