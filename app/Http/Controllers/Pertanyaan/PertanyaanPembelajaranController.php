<?php

namespace App\Http\Controllers\Pertanyaan;

use App\Models\Pertanyaan\PertanyaanPembelajaran;
use App\Http\Controllers\Controller;
use App\Imports\PertanyaanPembelajaranImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PertanyaanPembelajaranController extends Controller
{
	// Index
    public function index()
    {
    	$title = 'Data Pertanyaan Evaluasi Pembelajaran';

    	$pertanyaanPembelajaran = PertanyaanPembelajaran::all();

    	return view('pertanyaan.pembelajaran.index', compact('title', 'pertanyaanPembelajaran'));
    }

    // Store
    public function store(Request $request)
    {
    	PertanyaanPembelajaran::create($request->all());

    	return back()->with('success', 'Data pertanyaan berhasil ditambah.');
    }

    // Update
    public function update(PertanyaanPembelajaran $pertanyaan, Request $request)
    {
    	$pertanyaan->update($request->all());

    	return back()->with('success', 'Data pertanyaan berhasil diubah.');
    }

    // Delete
    public function destroy(PertanyaanPembelajaran $pertanyaan)
    {
    	$pertanyaan->delete();

    	return back()->with('success', 'Data pertanyaan berhasil dihapus.');
    }

    // Download Blanko
    public function blanko()
    {
        return response()->download(public_path().'/files/PertanyaanPembelajaran.xlsx');
    }

    // Import
    public function import()
    {
        try {
            $collection = Excel::toCollection(new PertanyaanPembelajaranImport, request()->file('excel'));

            $dataPertanyaan = $collection->first()->toArray();

            PertanyaanPembelajaran::truncate();

            PertanyaanPembelajaran::insert($dataPertanyaan);

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
