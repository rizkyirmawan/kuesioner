<?php

use App\Models\Alumni;
use App\Models\Jurusan;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class AlumniTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$jurusanIF = Jurusan::where('kode', 'IF')->first();

    	$jurusanSI = Jurusan::where('kode', 'SI')->first();

    	$alumniRole = Role::where('role', 'Alumni')->first();

    	$data = [
    		[
    			'nim' 				=> '1215008',
    			'nama' 				=> 'RADITYO YOGA PRATAMA',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6285702517067',
    			'angkatan' 			=> '2015',
    			'tahun_lulus'		=> '2018',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'role_id' 			=> $alumniRole->id,
    			'email' 			=> 'radityo.contact@gmail.com',
    			'password' 			=> bcrypt(1215008),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> '3216005',
    			'nama' 				=> 'RIZKY',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+628965200002',
    			'angkatan' 			=> '2016',
    			'tahun_lulus'		=> '2019',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'role_id' 			=> $alumniRole->id,
    			'email' 			=> 'jstrizky@gmail.com',
    			'password' 			=> bcrypt(3216005),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> '3216003',
    			'nama' 				=> 'FIKRI MUBARAK',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289444888222',
    			'angkatan' 			=> '2016',
    			'tahun_lulus'		=> '2019',
    			'jurusan_id' 		=> $jurusanSI->id,
    			'role_id' 			=> $alumniRole->id,
    			'email' 			=> 'fmubaraks@gmail.com',
    			'password' 			=> bcrypt(3216003),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
            [
                'nim'               => '1215002',
                'nama'              => 'BAYU BIMANTARA',
                'alamat'            => 'Bandung Barat',
                'nomor_telepon'     => '+62895332055486',
                'angkatan'          => '2015',
                'tahun_lulus'       => '2019',
                'jurusan_id'        => $jurusanSI->id,
                'role_id'           => $alumniRole->id,
                'email'             => 'bayubimantarar@gmail.com',
                'password'          => bcrypt(1215002),
                'remember_token'    => Str::random(10),
                'email_verified_at' => Carbon::now()
            ]
    	];

    	foreach ($data as $alumni) {
    		$alm = Alumni::create(Arr::except($alumni, [
    			'email',
    			'password',
    			'role_id',
    			'email_verified_at',
    			'remember_token'
    		]));

    		$alm->user()->create(Arr::only($alumni, [
    			'email',
    			'password',
    			'role_id',
    			'email_verified_at',
    			'remember_token'
    		]));
    	}
    }
}
