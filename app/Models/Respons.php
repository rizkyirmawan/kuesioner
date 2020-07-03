<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respons extends Model
{
    protected $table = 'respons';

    protected $guarded = [];

    public function responden()
    {
    	return $this->belongsTo(Responden::class);
    }

    public function pertanyaan()
    {
    	return $this->belongsTo(Pertanyaan::class);
    }

    public function jawaban()
    {
        return $this->belongsTo(Jawaban::class);
    }
}
