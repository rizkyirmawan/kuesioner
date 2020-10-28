<?php

namespace App\Http\Controllers\Pertanyaan;

use App\Models\Pertanyaan\PertanyaanTracerStudy;
use App\Http\Controllers\Controller;
use App\Imports\PertanyaanTracerImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PertanyaanTracerController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Pertanyaan Tracer Study';

    	$pertanyaanTracerStudy = PertanyaanTracerStudy::all();

    	return view('pertanyaan.tracerStudy.index', compact('title', 'pertanyaanTracerStudy'));
    }

    // Store
    public function store(Request $request)
    {
    	PertanyaanTracerStudy::create($request->all());

    	return back()->with('success', 'Data pertanyaan berhasil ditambah.');
    }

    // Update
    public function update(PertanyaanTracerStudy $pertanyaan, Request $request)
    {
    	$pertanyaan->update($request->all());

    	return back()->with('success', 'Data pertanyaan berhasil diubah.');
    }

    // Delete
    public function destroy(PertanyaanTracerStudy $pertanyaan)
    {
    	$pertanyaan->delete();

    	return back()->with('success', 'Data pertanyaan berhasil dihapus.');
    }

    // Download Blanko
    public function blanko()
    {
        return response()->download(public_path().'/files/PertanyaanTracerStudy.xlsx');
    }

    // Import
    public function import()
    {
        try {
            $collection = Excel::toCollection(new PertanyaanTracerImport, request()->file('excel'));

            $dataPertanyaan = $collection->first()->toArray();

            PertanyaanTracerStudy::truncate();

            PertanyaanTracerStudy::insert($dataPertanyaan);

            return back()
                    ->with('success', 'Data pertanyaan berhasil diimport.');
        } catch (\Exception $e) {
            return back()
                    ->with('error', 'Gagal membaca file. Silahkan sesuaikan field dengan blanko.');
        } catch (\Error $e) {
            return back()
                    ->with('error', 'Gagal membaca file. Silahkan sesuaikan field dengan blanko.');
        }
    }
}
