<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Requests\DosenRequest;
use App\Http\Requests\UserRequest;
use App\Exports\DosenExport;
use App\Imports\DosenImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DosenController extends Controller
{
    // Index
    public function index()
    {
        $dosen = Dosen::all();

        $title = 'Data Dosen';

        return view('dosen.index', compact('dosen', 'title'));
    }

    // Create Dosen View
    public function create()
    {
        $title = 'Tambah Data Dosen';

        $dosen = new Dosen();

        return view('dosen.create', compact('title', 'dosen'));
    }

    // Create Dosen
    public function store(DosenRequest $dosenReq, UserRequest $userReq)
    {
        $dosenRole = Role::where('role', 'Dosen')->first();

        $dosenReq->request->add([
            'nomor_telepon' => '+62' . $dosenReq->nomor_telepon,
            'email' => $userReq->email,
            'password' => bcrypt($dosenReq->nidn),
            'role_id' => $dosenRole->id,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10)
        ]);

        $dosen = Dosen::create($dosenReq->only([
            'kode', 'nidn', 'nama', 'alamat', 'nomor_telepon'
        ]));

        $this->storeImage($dosen);

        $user = $dosen->user()->create($dosenReq->only([
            'email', 'password', 'role_id', 'email_verified_at', 'remember_token'
        ]));

        return redirect()
                ->route('dosen.show', ['dosen' => $dosen->kode])
                ->with('success', 'Data dosen telah ditambahkan.');
    }

    // Show Details
    public function show(Dosen $dosen)
    {
        $title = 'Detail dari ' . $dosen->nama;

        return view('dosen.show', compact('dosen', 'title'));
    }

    // Edit Dosen
    public function edit(Dosen $dosen)
    {
        $title = 'Ubah Data Dosen: ' . $dosen->nama;

        return view('dosen.edit', compact('dosen', 'title'));
    }

    // Update Dosen
    public function update(
        DosenRequest $dosenReq,
        UserRequest $userReq,
        Dosen $dosen
    ) {
        $dosenRole = Role::where('role', 'Dosen')->first();

        $dosenReq->request->add([
            'nomor_telepon' => '+62' . $dosenReq->nomor_telepon,
            'email' => $userReq->email,
            'password' => bcrypt($dosenReq->nidn),
            'role_id' => $dosenRole->id,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10)
        ]);

        $dosen->update($dosenReq->only([
            'kode', 'nidn', 'nama', 'alamat', 'nomor_telepon'
        ]));

        $this->storeImage($dosen);

        $user = $dosen->user()->update($dosenReq->only([
            'email', 'password', 'role_id', 'email_verified_at', 'remember_token'
        ]));

        return redirect()
                ->route('dosen.show', ['dosen' => $dosen])
                ->with('success', 'Data dosen telah diubah.');
    }

    // Delete Dosen
    public function destroy(Dosen $dosen)
    {
        if ($dosen->foto) {
            Storage::delete('public/' . $dosen->foto);
        }

        if ($dosen->studi->count() > 0) {
            return redirect()
                    ->route('dosen.show', ['dosen' => $dosen])
                    ->with('error', 'Dosen ini memiliki mata kuliah yang diajar.');
        }

        $dosen->user->delete();

        $dosen->delete();

        return redirect()
                ->route('dosen.index')
                ->with('success', 'Data dosen telah dihapus.');
    }

    // Store Image
    public function storeImage($dosen)
    {
        if (request()->has('foto')) {
            if ($dosen->foto) {
                Storage::delete('public/' . $dosen->foto);
            }

            $dosen->update(['foto' => request()->foto->store('img/uploads', 'public')]);

            $image = Image::make(public_path('storage/' . $dosen->foto))->fit(295, 295);

            $image->save();
        }
    }

    // Download Blanko
    public function blankoDosen()
    {
        return response()->download(public_path().'/files/Dosen.xlsx');
    }

    // Export Dosen
    public function exportDosen()
    {
        $kode = Str::upper(Str::random(5));

        return Excel::download(new DosenExport, $kode . '-DATA-DOSEN.xlsx');
    }

    // Import Dosen
    public function importDosen()
    {
        try {
            $collection = Excel::toCollection(new DosenImport, request()->file('excel'));

            $importedKodeDosen = $collection->first()->pluck('kode')->unique()->toArray();

            $kodeDosen = collect(Dosen::all())->pluck('kode')->unique()->toArray();

            $diffKodeDosen = array_map('unserialize', array_diff(array_map('serialize', $importedKodeDosen), array_map('serialize', $kodeDosen)));

            $dataDosen = $collection->first()->map(function ($item, $key) use ($diffKodeDosen) {
                $item['nomor_telepon']  = '+' . strval($item['nomor_telepon']);
                $item['nama']           = $item['nama_dosen'];

                $dosenRole  = Role::where('role', 'Dosen')->first();

                $item['remember_token']     = Str::random(10);
                $item['email_verified_at']  = now()->toDateTimeString();
                $item['role_id']            = $dosenRole->id;
                $item['password']           = bcrypt('dosen');

                return collect($item)->forget(['nama_dosen']);
            })->whereIn('kode', $diffKodeDosen)->toArray();

            if (count($importedDataDosen) <= 0) {
                return back()
                        ->with('warning', 'Tidak ada data dosen yang berbeda.');
            }

            foreach ($dataDosen as $dosen) {
                DB::transaction(function() use ($dosen) {
                    $ds = Dosen::create(Arr::except($dosen, [
                        'email',
                        'password',
                        'role_id',
                        'remember_token',
                        'email_verified_at'
                    ]));

                    $ds->user()->create(Arr::only($dosen, [
                        'email',
                        'password',
                        'role_id',
                        'remember_token',
                        'email_verified_at'
                    ]));
                });
            }
        } catch (\Exception $e) {
            return back()
                    ->with('error', 'Gagal membaca file. Silahkan sesuaikan field dengan blanko.');
        } catch (\Error $e) {
            return back()
                    ->with('error', 'Gagal membaca file. Silahkan sesuaikan field dengan blanko.');
        }

        return redirect()
                ->route('dosen.index')
                ->with('success', 'Data dosen berhasil diimport.');
    }
}
