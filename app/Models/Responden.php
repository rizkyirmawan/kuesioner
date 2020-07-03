<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    protected $table = 'responden';

    protected $guarded = [];

    public function kuesionerable()
    {
    	return $this->morphTo();
    }

    public function respons()
    {
    	return $this->hasMany(Respons::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
