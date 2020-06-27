<?php

use Carbon\Carbon;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jurusan::insert([
        	[
        		'kode' => 'IF',
        		'jurusan' => 'Teknik Informatika',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'kode' => 'SI',
        		'jurusan' => 'Sistem Informasi',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	]
        ]);
    }
}
