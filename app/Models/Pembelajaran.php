<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model
{
    protected $table = 'pembelajaran';

    protected $guarded = [];

    public function studi()
    {
    	return $this->belongsTo(Studi::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function pertanyaan()
    {
        return $this->morphMany(Pertanyaan::class, 'questionable');
    }

    public function responden()
    {
        return $this->morphMany(Responden::class, 'kuesionerable');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran');
    }

    public function respons()
    {
        return $this->hasManyThrough(Respons::class, Pertanyaan::class, 'questionable_id')->where('questionable_type', Pembelajaran::class);
    }
}
