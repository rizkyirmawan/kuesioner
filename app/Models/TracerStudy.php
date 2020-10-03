<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TracerStudy extends Model
{
    protected $table = 'tracer_study';

    protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function identitas()
    {
    	return $this->belongsTo(identitas::class);
    }

    public function pertanyaan()
    {
        return $this->morphMany(Pertanyaan::class, 'questionable');
    }

    public function responden()
    {
        return $this->morphMany(Responden::class, 'kuesionerable');
    }

    public function respons()
    {
        return $this->hasManyThrough(Respons::class, Pertanyaan::class, 'questionable_id')->where('questionable_type', TracerStudy::class);
    }
}
