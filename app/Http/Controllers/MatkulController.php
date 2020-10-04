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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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

        $mahasiswa = Mahasiswa::whereHas('matkul', function ($query) use ($mataKuliah) {
           $query->where('kode_matkul', '=', $mataKuliah->kode);
        })->get();

        $kelas = Kelas::whereNotIn('id', $mataKuliah->studi->pluck('kelas_id'))->get();

        $dosen = Dosen::all();

    	return view('matkul.show', compact('title', 'mataKuliah', 'kelas', 'dosen', 'mahasiswa'));
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
        try {
            $collection = Excel::toCollection(new KRSImport, $request->file('excel'));

            $plucked = $collection->first()->map(function ($item, $key) {
                $item['kode_matkul'] = $item['kd_mk'];
                return collect($item)->only(['nim', 'kode_matkul']);
            })->toArray();

            $dataMatkul = $collection->first()->unique('kd_mk')->map(function ($item, $key) {
                $item['kode'] = $item['kd_mk'];

                $item['mata_kuliah'] = $item['nama_mk'];

                return collect($item)->only(['kode', 'mata_kuliah']);
            })->toArray();

            DB::table('matkul')->truncate();

            DB::table('program')->truncate();

            foreach ($dataMatkul as $matkul) {
                $jurusanIF = Jurusan::where('kode', 'IF')->first();

                $jurusanSI = Jurusan::where('kode', 'SI')->first();

                if (Str::substr($matkul['kode'], 0, 2) == 'IF') {
                    $jurusan = [$jurusanIF->id];
                } elseif (Str::substr($matkul['kode'], 0, 2) == 'SI') {
                    $jurusan = [$jurusanSI->id];
                } else {
                    $jurusan = [$jurusanIF->id, $jurusanSI->id];
                }

                $mk = Matkul::create($matkul);

                $mk->jurusan()->sync($jurusan);
            }

            DB::table('peserta_didik')->truncate();

            DB::table('peserta_didik')->insert($plucked);
        } catch(\Exception $e) {
            return back()
                    ->with('error', 'Gagal membaca file. Silahkan sesuaikan field dengan blanko.');
        } catch(\Error $e) {
            return back()
                    ->with('error', 'Gagal membaca file. Silahkan sesuaikan field dengan blanko.');
        }

        return redirect()
                ->route('matkul.index')
                ->with('success', 'Data KRS berhasil diimport.');
    }

    // Download Blanko KRS
    public function blankoKRS()
    {
        return response()->download(public_path().'/files/KRS.xlsx');
    }
}
