<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
	protected $table = 'dosen';

	protected $guarded = [];

	public function user()
	{
		return $this->morphOne(User::class, 'userable');
	}

	public function dosen()
	{
		return $this->hasOne(Matkul::class);
	}

	public function studi()
	{
		return $this->hasMany(Studi::class);
	}
}
