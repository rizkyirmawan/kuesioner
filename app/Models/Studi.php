<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studi extends Model
{
    protected $table = 'studi';

    protected $guarded = [];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran');
    }

    public function kelas()
    {
    	return $this->belongsTo(Kelas::class);
    }

    public function matkul()
    {
    	return $this->belongsTo(Matkul::class, 'kode_matkul');
    }

    public function dosen()
    {
    	return $this->belongsTo(Dosen::class, 'kode_dosen');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'peserta_didik')->withTimestamps();
    }

    public function pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class);
    }
}
