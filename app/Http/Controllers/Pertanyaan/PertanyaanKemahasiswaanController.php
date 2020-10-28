<?php

namespace App\Http\Controllers\Pertanyaan;

use App\Models\Pertanyaan\PertanyaanKemahasiswaan;
use App\Http\Controllers\Controller;
use App\Imports\PertanyaanKemahasiswaanImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PertanyaanKemahasiswaanController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Data Pertanyaan Layanan Mahasiswa';

    	$pertanyaanKemahasiswaan = PertanyaanKemahasiswaan::all();

    	return view('pertanyaan.kemahasiswaan.index', compact('title', 'pertanyaanKemahasiswaan'));
    }

    // Store
    public function store(Request $request)
    {
    	PertanyaanKemahasiswaan::create($request->all());

    	return back()->with('success', 'Data pertanyaan berhasil ditambah.');
    }

    // Update
    public function update(PertanyaanKemahasiswaan $pertanyaan, Request $request)
    {
    	$pertanyaan->update($request->all());

    	return back()->with('success', 'Data pertanyaan berhasil diubah.');
    }

    // Delete
    public function destroy(PertanyaanKemahasiswaan $pertanyaan)
    {
    	$pertanyaan->delete();

    	return back()->with('success', 'Data pertanyaan berhasil dihapus.');
    }

    // Download Blanko
    public function blanko()
    {
        return response()->download(public_path().'/files/PertanyaanLayananMahasiswa.xlsx');
    }

    // Import
    public function import()
    {
        try {
            $collection = Excel::toCollection(new PertanyaanKemahasiswaanImport, request()->file('excel'));

            $dataPertanyaan = $collection->first()->toArray();

            PertanyaanKemahasiswaan::truncate();

            PertanyaanKemahasiswaan::insert($dataPertanyaan);

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
