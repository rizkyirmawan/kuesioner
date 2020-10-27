<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Identitas;
use App\Models\Pembelajaran;
use App\Models\Kemahasiswaan;
use App\Models\TahunAjaran;
use App\Models\TracerStudy;
use App\Models\Studi;

class DasborController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Dasbor';

        $today = Carbon::now();

        $tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first();

    	$pembelajaran = Pembelajaran::all()->count();

    	$kemahasiswaan = Kemahasiswaan::where('tahun_ajaran', $tahunAjaranAktif->id)
                            ->whereDate('awal', '<=', $today->format('Y-m-d'))
                            ->whereDate('akhir', '>=', $today->format('Y-m-d'))
                            ->count();

    	$identitas = Identitas::all()->count();

        $identitasAlumni = '';

        $tracerStudyAlumni = '';

        $pembelajaranMahasiswa = '';

        $pembelajaranDosen = '';

        $studiDosen = '';

        if (auth()->user()->role->role === 'Alumni') {
            $identitasAlumni = Identitas::where('tahun_lulus', auth()->user()->userable->tahun_lulus)->count();
            $tracerStudyAlumni = TracerStudy::where('user_id', auth()->user()->id)->count();
        }

        if (auth()->user()->role->role === 'Mahasiswa') {
        	$pembelajaranMahasiswa = Pembelajaran::select('pembelajaran.*')
                            ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                            ->join('matkul', 'studi.kode_matkul', '=', 'matkul.kode')
                            ->join('peserta_didik', 'matkul.kode', '=', 'peserta_didik.kode_matkul')
                            ->join('kelas', 'studi.kelas_id', '=', 'kelas.id')
                            ->join('mahasiswa', 'peserta_didik.nim', '=', 'mahasiswa.nim')
                            ->where('studi.kelas_id', auth()->user()->userable->kelas_id)
                            ->where('peserta_didik.nim', auth()->user()->userable->nim)
                            ->whereDate('awal', '<=', $today->format('Y-m-d'))
                            ->whereDate('akhir', '>=', $today->format('Y-m-d'))
                            ->count();
        }

        if (auth()->user()->role->role === 'Dosen') {
            $pembelajaranDosen = Pembelajaran::select('pembelajaran.*')
                            ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                            ->where('studi.kode_dosen', auth()->user()->userable->kode)
                            ->count();

            $studiDosen = Studi::where('kode_dosen', auth()->user()->userable->kode)->count();
        }

    	return view('auth.dasbor', compact(
    		'title',
    		'pembelajaran',
    		'kemahasiswaan',
    		'identitas',
    		'identitasAlumni',
    		'tracerStudyAlumni',
    		'pembelajaranMahasiswa',
    		'pembelajaranDosen',
    		'studiDosen',
            'tahunAjaranAktif'
    	));
    }
}
