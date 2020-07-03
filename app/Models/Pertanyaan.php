<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
	protected $table = 'pertanyaan';

    protected $guarded = [];

    public function questionable()
    {
    	return $this->morphTo();
    }

    public function jawaban()
    {
    	return $this->hasMany(Jawaban::class);
    }

    public function respons()
    {
        return $this->hasMany(Respons::class);
    }
}
