<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identitas extends Model
{
    protected $table = 'identitas';

    protected $guarded = [];

    public function tracerStudy()
    {
    	return $this->hasMany(TracerStudy::class);
    }
}
