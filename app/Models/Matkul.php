<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    protected $table = 'matkul';

    protected $guarded = [];

    public function studi()
    {
        return $this->hasMany(Studi::class);
    }

    public function jurusan()
    {
        return $this->belongsToMany(Jurusan::class, 'program')->withTimestamps();
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'peserta_didik')->withTimestamps();
    }
}
