<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Requests\DosenRequest;
use App\Http\Requests\UserRequest;

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
            'nidn', 'nama', 'alamat', 'nomor_telepon'
        ]));

        $this->storeImage($dosen);

        $user = $dosen->user()->create($dosenReq->only([
            'email', 'password', 'role_id', 'email_verified_at', 'remember_token'
        ]));

        return redirect()
                ->route('dosen.show', ['dosen' => $dosen->id])
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
            'nidn', 'nama', 'alamat', 'nomor_telepon'
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
}
