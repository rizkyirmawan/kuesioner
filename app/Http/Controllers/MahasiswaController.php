<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Http\Requests\MahasiswaRequest;
use App\Http\Requests\UserRequest;
use App\Exports\MahasiswaExport;
use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    // Index
    public function index()
    {
        $mahasiswa = Mahasiswa::all();

        $title = 'Data Mahasiswa';

        return view('mahasiswa.index', compact('mahasiswa', 'title'));
    }

    // Create Mahasiswa View
    public function create()
    {
        $title = 'Tambah Data Mahasiswa';

        $mahasiswa = new Mahasiswa();

        $jurusan = Jurusan::all();

        $kelas = Kelas::all();

        return view('mahasiswa.create', compact('title', 'jurusan', 'mahasiswa', 'kelas'));
    }

    // Create Mahasiswa
    public function store(MahasiswaRequest $mahasiswaReq, UserRequest $userReq)
    {
        $currentYear = Str::of(strval(Carbon::now()->year))->substr(0, 2);
        $tahunAngkatan = Str::of($mahasiswaReq->nim)->substr(2, 2);
        $angkatan = $currentYear . $tahunAngkatan;

        $mahasiswaRole = Role::where('role', 'Mahasiswa')->first();
        
        $mahasiswaReq->request->add([
            'jurusan_id' => $mahasiswaReq->jurusan,
            'kelas_id' => $mahasiswaReq->kelas,
            'nomor_telepon' => '+62' . $mahasiswaReq->nomor_telepon,
            'angkatan' => $angkatan,
            'email' => $userReq->email,
            'password' => bcrypt($mahasiswaReq->nim),
            'role_id' => $mahasiswaRole->id,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10)
        ]);

        $mahasiswa = Mahasiswa::create($mahasiswaReq->only([
            'nim', 'nama', 'alamat', 'nomor_telepon', 'angkatan', 'jurusan_id', 'kelas_id'
        ]));

        $this->storeImage($mahasiswa);

        $user = $mahasiswa->user()->create($mahasiswaReq->only([
            'email', 'password', 'role_id', 'email_verified_at', 'remember_token'
        ]));

        return redirect()
                ->route('mahasiswa.show', ['mahasiswa' => $mahasiswa->id])
                ->with('success', 'Data mahasiswa telah ditambahkan.');
    }

    // Show Details
    public function show(Mahasiswa $mahasiswa)
    {
        $title = 'Detail dari ' . $mahasiswa->nama;

        return view('mahasiswa.show', compact('mahasiswa', 'title'));
    }

    // Edit Mahasiswa
    public function edit(Mahasiswa $mahasiswa)
    {
        $title = 'Ubah Data Mahasiswa: ' . $mahasiswa->nama;

        $jurusan = Jurusan::all();

        $kelas = Kelas::all();

        return view('mahasiswa.edit', compact('mahasiswa', 'jurusan', 'title', 'kelas'));
    }

    // Update Mahasiswa
    public function update(
        MahasiswaRequest $mahasiswaReq,
        UserRequest $userReq,
        Mahasiswa $mahasiswa
    ) {
        $currentYear = Str::of(strval(Carbon::now()->year))->substr(0, 2);
        $tahunAngkatan = Str::of($mahasiswaReq->nim)->substr(2, 2);
        $angkatan = $currentYear . $tahunAngkatan;

        $mahasiswaRole = Role::where('role', 'Mahasiswa')->first();

        $mahasiswaReq->request->add([
            'jurusan_id' => $mahasiswaReq->jurusan,
            'kelas_id' => $mahasiswaReq->kelas,
            'nomor_telepon' => '+62' . $mahasiswaReq->nomor_telepon,
            'angkatan' => $angkatan,
            'email' => $userReq->email,
            'password' => bcrypt($mahasiswaReq->nim),
            'role_id' => $mahasiswaRole->id,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10)
        ]);

        $mahasiswa->update($mahasiswaReq->only([
            'nim', 'nama', 'alamat', 'nomor_telepon', 'angkatan', 'jurusan_id', 'kelas_id'
        ]));

        $this->storeImage($mahasiswa);

        $user = $mahasiswa->user()->update($mahasiswaReq->only([
            'email', 'password', 'role_id', 'email_verified_at', 'remember_token'
        ]));

        return redirect()
                ->route('mahasiswa.show', ['mahasiswa' => $mahasiswa])
                ->with('success', 'Data mahasiswa telah diubah.');
    }

    // Delete Mahasiswa
    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->foto) {
            Storage::delete('public/' . $mahasiswa->foto);
        }

        $mahasiswa->user->delete();

        $mahasiswa->matkul()->detach();

        $mahasiswa->delete();

        return redirect()
                ->route('mahasiswa.index')
                ->with('success', 'Data mahasiswa telah dihapus.');
    }

    // Store Image
    public function storeImage($mahasiswa)
    {
        if (request()->has('foto')) {
            if ($mahasiswa->foto) {
                Storage::delete('public/' . $mahasiswa->foto);
            }

            $mahasiswa->update(['foto' => request()->foto->store('img/uploads', 'public')]);

            $image = Image::make(public_path('storage/' . $mahasiswa->foto))->fit(295, 295);

            $image->save();
        }
    }

    // API Mahasiswa by Kelas
    public function mahasiswaByKelas($kelas)
    {
        $res = Mahasiswa::where('kelas_id', '=', $kelas)->get();

        return response()->json($res, 200);
    }

    // API Mahasiswa by Jurusan
    public function mahasiswaByJurusan($kelas, $jurusan)
    {
        $res = Mahasiswa::where([
                    ['kelas_id', '=', $kelas],
                    ['jurusan_id', '=', $jurusan]
                ])->get();

        return response()->json($res, 200);
    }

    // API Mahasiswa by Angkatan
    public function mahasiswaByAngkatan($kelas, $jurusan, $angkatan)
    {
        $res = Mahasiswa::where([
                    ['kelas_id', '=', $kelas],
                    ['jurusan_id', '=', $jurusan],
                    ['angkatan', '=', $angkatan]
                ])->get();

        return response()->json($res, 200);
    }

    // API Mahasiswa Attached to Matkul
    public function mahasiswaAttached($matkul)
    {
        $res = Mahasiswa::whereHas('matkul', function ($query) use ($matkul) {
           $query->where('kode_matkul', '=', $matkul);
        })->get();

        return response()->json($res, 200);
    }

    // Download Blanko
    public function blankoMahasiswa()
    {
        return response()->download(public_path().'/files/Mahasiswa.xlsx');
    }

    // Export Mahasiswa
    public function exportMahasiswa()
    {
        $kode = Str::upper(Str::random(5));

        return Excel::download(new MahasiswaExport, $kode . '-DATA-MAHASISWA.xlsx');
    }

    // Import Mahasiswa
    public function importMahasiswa(Request $request)
    {
        try {
            ini_set('max_execution_time', 800);
            
            $collection = Excel::toCollection(new MahasiswaImport, $request->file('excel'));

            $dataMhs = $collection->first()->map(function ($item, $key) {
                $jurusanIF      = Jurusan::where('kode', 'IF')->first();
                $jurusanSI      = Jurusan::where('kode', 'SI')->first();

                $kelasRegPagi   = Kelas::where('kode', 'REG-A')->first();
                $kelasRegSore   = Kelas::where('kode', 'REG-B')->first();
                $kelasEksekutif = Kelas::where('kode', 'EKS-A')->first();

                $mahasiswaRole  = Role::where('role', 'Mahasiswa')->first();

                $currentYear    = Str::of(strval(Carbon::now()->year))->substr(0, 2);
                $tahunAngkatan  = Str::of(strval($item['nim']))->substr(2, 2);
                
                $item['angkatan']           = $currentYear . $tahunAngkatan;
                $item['nama']               = $item['nama_mahasiswa'];
                $item['nomor_telepon']      = '+' . strval($item['nomor_telepon']);
                $item['password']           = bcrypt($item['nim']);
                $item['remember_token']     = Str::random(10);
                $item['email_verified_at']  = Carbon::now();
                $item['role_id']            = $mahasiswaRole->id;

                if (Str::substr(strval($item['nim']), 0, 2) == '12') {
                    $item['jurusan_id'] = $jurusanIF->id;
                } elseif (Str::substr(strval($item['nim']), 0, 2) == '32') {
                    $item['jurusan_id'] = $jurusanSI->id;
                }

                if($item['kelas_program'] === 'REGULER') {
                    $item['kelas_id'] = $kelasRegPagi->id;
                } elseif ($item['kelas_program'] === 'KARYAWAN') {
                    $item['kelas_id'] = $kelasRegSore->id;
                } elseif ($item['kelas_program'] === 'EKSEKUTIF') {
                    $item['kelas_id'] = $kelasEksekutif->id;
                }

                return collect($item)->forget(['nama_mahasiswa', 'kelas_program', 'jurusan']);
            })->toArray();

            Mahasiswa::truncate();

            User::where('userable_type', Mahasiswa::class)->delete();

            foreach ($dataMhs as $mahasiswa) {
                $mhs = Mahasiswa::create(Arr::except($mahasiswa, [
                    'email',
                    'password',
                    'role_id',
                    'remember_token',
                    'email_verified_at'
                ]));

                $mhs->user()->create(Arr::only($mahasiswa, [
                    'email',
                    'password',
                    'role_id',
                    'remember_token',
                    'email_verified_at'
                ]));
            }
        } catch (\Exception $e) {
            return back()
                    ->with('error', 'Gagal membaca file. Silahkan sesuaikan field dengan blanko.');
        } catch (\Error $e) {
            return back()
                    ->with('error', 'Gagal membaca file. Silahkan sesuaikan field dengan blanko.');
        }

        return redirect()
                ->route('mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil diimport.');
    }
}
