<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    protected $table = 'matkul';

    protected $guarded = [];

    protected $primaryKey = 'kode';

    public $incrementing = false;

    public function getRouteKeyName()
    {
        return 'kode';
    }

    public function studi()
    {
        return $this->hasMany(Studi::class, 'kode_matkul');
    }

    public function jurusan()
    {
        return $this->belongsToMany(Jurusan::class, 'program', 'kode_matkul', 'jurusan_id')->withTimestamps();
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'peserta_didik', 'kode_matkul', 'nim')->withTimestamps();
    }
}
