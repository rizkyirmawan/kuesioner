<?php

use Carbon\Carbon;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class TahunAjaranTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TahunAjaran::insert([
        	[
        		'semester' => 'Genap',
        		'tahun_ajaran' => '2020/2021',
                'aktif' => 0,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'semester' => 'Ganjil',
        		'tahun_ajaran' => '2020/2021',
                'aktif' => 0,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
            [
                'semester' => 'Genap',
                'tahun_ajaran' => '2019/2020',
                'aktif' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'semester' => 'Ganjil',
                'tahun_ajaran' => '2019/2020',
                'aktif' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
