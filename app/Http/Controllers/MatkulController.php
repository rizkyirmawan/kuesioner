<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Matkul;
use App\Models\Mahasiswa;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Studi;
use App\Http\Requests\MatkulRequest;
use App\Imports\KRSImport;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MatkulController extends Controller
{
	// Index
    public function index()
    {
    	$title = 'Data Mata Kuliah';

    	$mataKuliah = Matkul::orderBy('kode')->get();

    	return view('matkul.index', compact('title', 'mataKuliah'));
    }

    // Create Matkul View
    public function create()
    {
    	$title = 'Tambah Data Mata Kuliah';

    	$mataKuliah = new Matkul();

        $jurusan = Jurusan::all();

    	return view('matkul.create', compact('title', 'mataKuliah', 'jurusan'));
    }

    // Create Matkul
    public function store(MatkulRequest $matkulReq)
    {
    	$mataKuliah = Matkul::create($matkulReq->only('kode', 'mata_kuliah'));

        $mataKuliah->jurusan()->sync($matkulReq->jurusan);

    	return redirect()
                ->route('matkul.show', ['mataKuliah' => $mataKuliah->kode])
                ->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    // Show Matkul
    public function show(Matkul $mataKuliah)
    {
    	$title = 'Mata Kuliah: ' . $mataKuliah->mata_kuliah;

        $kelas = Kelas::whereNotIn('id', $mataKuliah->studi->pluck('kelas_id'))->get();

        $dosen = Dosen::all();

    	return view('matkul.show', compact('title', 'mataKuliah', 'kelas', 'dosen'));
    }

    // Edit Matkul
    public function edit(Matkul $mataKuliah)
    {
    	$title = 'Ubah Data Mata Kuliah: ' . $mataKuliah->mata_kuliah;

        $jurusan = Jurusan::all();

    	return view('matkul.edit', compact('title', 'mataKuliah', 'jurusan'));
    }

    // Update Matkul
    public function update(MatkulRequest $matkulReq, Matkul $mataKuliah)
    {
    	$mataKuliah->update($matkulReq->only('kode', 'mata_kuliah'));

        $mataKuliah->jurusan()->sync($matkulReq->jurusan);

    	return redirect()
                ->route('matkul.show', ['mataKuliah' => $mataKuliah])
                ->with('success', 'Data mata kuliah berhasil diubah.');
    }

    // Delete Matkul
    public function destroy(Matkul $mataKuliah)
    {
        $mataKuliah->jurusan()->detach();

        $mataKuliah->studi()->delete();

    	$mataKuliah->delete();

    	return redirect()
                ->route('matkul.index')
                ->with('success', 'Data mata kuliah berhasil dihapus.');
    }

    // Peserta Didik
    public function pesertaDidik(Matkul $mataKuliah)
    {
        $title = 'Kelola Peserta Didik';

        $jurusan = $mataKuliah->jurusan;

        return view('matkul.peserta', compact('title', 'mataKuliah', 'jurusan'));
    }

    // Store Studi
    public function storeStudi(Matkul $mataKuliah, Request $request)
    {
        $request->request->add([
            'kelas_id' => $request->kelas,
            'dosen_id' => $request->dosen
        ]);

        $mataKuliah->studi()->create($request->only('kelas_id', 'dosen_id'));

        return redirect()
                ->route('matkul.show', ['mataKuliah' => $mataKuliah])
                ->with('success', 'Data kelas & dosen berhasil diubah.');
    }

    // Update Studi
    public function updateStudi(Matkul $mataKuliah, Studi $studi, Request $request)
    {
        $request->request->add([
            'dosen_id' => $request->dosen
        ]);

        $studi->update($request->only('dosen_id'));

        return redirect()
                ->route('matkul.show', ['mataKuliah' => $mataKuliah])
                ->with('success', 'Data kelas & dosen berhasil diubah.');
    }

    // Destroy Studi
    public function destroyStudi(Matkul $mataKuliah, Studi $studi)
    {
        if ($mataKuliah->mahasiswa->where('kelas_id', $studi->kelas->id)->count() > 0) {
            return  redirect()
                    ->route('matkul.show', ['mataKuliah' => $mataKuliah])
                    ->with('error', 'Data studi ini memiliki peserta didik.');
        }

        $studi->delete();

        return  redirect()
                ->route('matkul.show', ['mataKuliah' => $mataKuliah])
                ->with('success', 'Data kelas & dosen berhasil diubah.');
    }

    // Store Peserta Didik
    public function storePeserta(Matkul $mataKuliah, Request $request)
    {
        if (!$request->mahasiswa) {
            $mataKuliah->mahasiswa()->detach();
        } else {
            $mataKuliah->mahasiswa()->sync($request->mahasiswa);
        }

        return redirect()
                ->route('matkul.peserta', ['mataKuliah' => $mataKuliah])
                ->with('success', 'Data peserta didik berhasil diubah.');
    }

    // Get Jurusan API
    public function getJurusan(Matkul $mataKuliah)
    {
        $res = $mataKuliah->jurusan;

        return response()->json($res, 200);
    }

    // Import Excel KRS
    public function importKRS(Request $request)
    {
        $collection = Excel::toCollection(new KRSImport, $request->file('excel'));

        $plucked = $collection->first()->map(function ($item, $key) {
            $item['kode_matkul'] = $item['kode_mk'];
            return collect($item)->only(['nim', 'kode_matkul']);
        })->toArray();

        // $uniqueImportedNIM =  collect(Arr::pluck($plucked, 'nim'))
        //                         ->unique()
        //                         ->values()
        //                         ->all();

        // $uniqueImportedMk =  collect(Arr::pluck($plucked, 'kode_'))
        //                         ->unique()
        //                         ->values()
        //                         ->all();

        // $uniqueImportedNIM = array_map('intval', $uniqueImportedNIM);

        // $uniqueNIM = collect(Mahasiswa::all())->pluck('nim')->toArray();

        // $uniqueMk = collect(Matkul::all())->pluck('kode')->toArray();

        // if (Arr::sortRecursive($uniqueImportedNIM) !== Arr::sortRecursive($uniqueNIM)) {
        //     return redirect()
        //             ->route('matkul.index')
        //             ->with('error', 'Terdapat data mahasiswa yang belum terdaftar.');
        // } elseif (Arr::sortRecursive($uniqueImportedMk) !== Arr::sortRecursive($uniqueMk)) {
        //     return redirect()
        //             ->route('matkul.index')
        //             ->with('error', 'Terdapat data mata kuliah yang belum terdaftar.');
        // } else {
            DB::table('peserta_didik')->insert($plucked);

            return redirect()
                    ->route('matkul.index')
                    ->with('success', 'Data KRS berhasil diimport.');
        // }
    }
}
