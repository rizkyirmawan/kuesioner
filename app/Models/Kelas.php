<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $guarded = [];

    public function mahasiswa()
    {
    	return $this->hasMany(Mahasiswa::class);
    }

    public function studi()
    {
    	return $this->hasMany(Studi::class);
    }
}
