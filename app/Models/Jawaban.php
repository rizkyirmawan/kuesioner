<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban';

    protected $guarded = [];

    public function answerable()
    {
        return $this->morphTo();
    }

    public function pertanyaan()
    {
    	return $this->belongsTo(Pertanyaan::class);
    }

    public function respons()
    {
    	return $this->hasMany(Respons::class);
    }
}
