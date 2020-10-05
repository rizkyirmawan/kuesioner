<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Jurusan;
use App\Models\Role;
use App\Http\Requests\AlumniRequest;
use App\Http\Requests\UserRequest;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AlumniController extends Controller
{
    // Index
    public function index()
    {
        $alumni = Alumni::all();

        $title = 'Data Alumni';

        return view('alumni.index', compact('alumni', 'title'));
    }

    // Create
    public function create()
    {
        $title = 'Tambah Data Alumni';

        $alumni = new Alumni();

        $jurusan = Jurusan::all();

        return view('alumni.create', compact('title', 'jurusan', 'alumni'));
    }

    // Store
    public function store(AlumniRequest $request, UserRequest $userReq)
    {
        $currentYear = Str::of(strval(Carbon::now()->year))->substr(0, 2);
        $tahunAngkatan = Str::of($request->nim)->substr(2, 2);
        $angkatan = $currentYear . $tahunAngkatan;

        $alumniRole = Role::where('role', 'Alumni')->first();
        
        $request->request->add([
            'jurusan_id' => $request->jurusan,
            'nomor_telepon' => '+62' . $request->nomor_telepon,
            'angkatan' => $angkatan,
            'tahun_lulus' => $request->tahun_lulus,
            'email' => $userReq->email,
            'password' => bcrypt($request->nim),
            'role_id' => $alumniRole->id,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10)
        ]);

        $alumni = Alumni::create($request->only([
            'nim', 'nama', 'alamat', 'nomor_telepon', 'angkatan', 'jurusan_id', 'tahun_lulus'
        ]));

        $this->storeImage($alumni);

        $user = $alumni->user()->create($request->only([
            'email', 'password', 'role_id', 'email_verified_at', 'remember_token'
        ]));

        return redirect()
                ->route('alumni.show', ['alumni' => $alumni->id])
                ->with('success', 'Data alumni telah ditambahkan.');
    }

    // Show
    public function show(Alumni $alumni)
    {
        $title = 'Detail dari ' . $alumni->nama;

        return view('alumni.show', compact('alumni', 'title'));
    }

    // Edit
    public function edit(Alumni $alumni)
    {
        $title = 'Ubah Data Alumni: ' . $alumni->nama;

        $jurusan = Jurusan::all();

        return view('alumni.edit', compact('alumni', 'jurusan', 'title'));
    }

    // Update
    public function update(
        AlumniRequest $request,
        UserRequest $userReq,
        Alumni $alumni
    ) {
        $currentYear = Str::of(strval(Carbon::now()->year))->substr(0, 2);
        $tahunAngkatan = Str::of($request->nim)->substr(2, 2);
        $angkatan = $currentYear . $tahunAngkatan;

        $alumniRole = Role::where('role', 'Alumni')->first();

        $request->request->add([
            'jurusan_id' => $request->jurusan,
            'kelas_id' => $request->kelas,
            'nomor_telepon' => '+62' . $request->nomor_telepon,
            'angkatan' => $angkatan,
            'tahun_lulus' => $request->tahun_lulus,
            'email' => $userReq->email,
            'password' => bcrypt($request->nim),
            'role_id' => $alumniRole->id,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10)
        ]);

        $alumni->update($request->only([
            'nim', 'nama', 'alamat', 'nomor_telepon', 'angkatan', 'tahun_lulus'
        ]));

        $this->storeImage($alumni);

        $user = $alumni->user()->update($request->only([
            'email', 'password', 'role_id', 'email_verified_at', 'remember_token'
        ]));

        return redirect()
                ->route('alumni.show', ['alumni' => $alumni])
                ->with('success', 'Data alumni telah diubah.');
    }

    // Delete
    public function destroy(Alumni $alumni)
    {
        if ($alumni->foto) {
            Storage::delete('public/' . $alumni->foto);
        }

        $alumni->user->delete();

        $alumni->delete();

        return redirect()
                ->route('alumni.index')
                ->with('success', 'Data alumni telah dihapus.');
    }

    // Store Image
    public function storeImage($alumni)
    {
        if (request()->has('foto')) {
            if ($alumni->foto) {
                Storage::delete('public/' . $alumni->foto);
            }

            $alumni->update(['foto' => request()->foto->store('img/uploads', 'public')]);

            $image = Image::make(public_path('storage/' . $alumni->foto))->fit(295, 295);

            $image->save();
        }
    }
}
