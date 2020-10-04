<?php

namespace App\Http\Controllers;

use App\Models\Identitas;
use App\Models\Pembelajaran;
use App\Models\Kemahasiswaan;
use App\Models\TracerStudy;
use App\Models\Studi;

class DasborController extends Controller
{
    // Index
    public function index()
    {
    	$title = 'Dasbor';

    	$pembelajaran = Pembelajaran::all()->count();

    	$kemahasiswaan = Kemahasiswaan::all()->count();

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
                            ->count();
        }

        if (auth()->user()->role->role === 'Dosen') {
            $pembelajaranDosen = Pembelajaran::select('pembelajaran.*')
                            ->join('studi', 'pembelajaran.studi_id', '=', 'studi.id')
                            ->where('studi.dosen_id', auth()->user()->userable->id)
                            ->count();

            $studiDosen = Studi::where('dosen_id', auth()->user()->userable->id)->count();
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
    		'studiDosen'
    	));
    }
}
