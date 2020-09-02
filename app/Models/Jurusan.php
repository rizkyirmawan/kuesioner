<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $guarded = [];

    public $timestamps = false;

    public function mahasiswa()
    {
    	return $this->hasMany(Mahasiswa::class);
    }

    public function matkul()
    {
    	return $this->belongsToMany(Matkul::class, 'program', 'jurusan_id', 'kode_matkul')->withTimestamps();
    }
}
