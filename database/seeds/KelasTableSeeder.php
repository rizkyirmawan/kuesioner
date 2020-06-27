<?php

use Carbon\Carbon;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kelas::insert([
        	[
        		'kode' => 'REG-A',
        		'kelas' => 'Reguler Pagi',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'kode' => 'REG-B',
        		'kelas' => 'Reguler Sore',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	],
        	[
        		'kode' => 'EKS-A',
        		'kelas' => 'Eksekutif',
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	]
        ]);
    }
}
