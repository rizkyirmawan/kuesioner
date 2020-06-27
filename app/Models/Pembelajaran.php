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
}
