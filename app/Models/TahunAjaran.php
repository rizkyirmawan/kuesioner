<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $guarded = [];

    public function pembelajaran()
    {
    	return $this->hasOne(Pembelajaran::class);
    }
}
