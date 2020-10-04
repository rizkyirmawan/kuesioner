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
    			'nim' 				=> '1213666',
    			'nama' 				=> 'RONX BANGKANANG',
    			'alamat' 			=> 'Bandung',
    			'jenis_kelamin'		=> 'Laki-laki',
    			'nomor_telepon' 	=> '+6289444888666',
    			'angkatan' 			=> '2013',
    			'tahun_lulus'		=> '2017',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'role_id' 			=> $alumniRole->id,
    			'email' 			=> 'ronx@example.com',
    			'password' 			=> bcrypt(1213666),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> '1213777',
    			'nama' 				=> 'UYAN WALKER',
    			'alamat' 			=> 'Bandung',
    			'jenis_kelamin'		=> 'Laki-laki',
    			'nomor_telepon' 	=> '+6289444888000',
    			'angkatan' 			=> '2013',
    			'tahun_lulus'		=> '2018',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'role_id' 			=> $alumniRole->id,
    			'email' 			=> 'uyan@example.com',
    			'password' 			=> bcrypt(1213777),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> '1213888',
    			'nama' 				=> 'KARMANAH O\' BRIEN',
    			'alamat' 			=> 'Bandung',
    			'jenis_kelamin'		=> 'Perempuan',
    			'nomor_telepon' 	=> '+6289444888222',
    			'angkatan' 			=> '2013',
    			'tahun_lulus'		=> '2017',
    			'jurusan_id' 		=> $jurusanSI->id,
    			'role_id' 			=> $alumniRole->id,
    			'email' 			=> 'karmanah@example.com',
    			'password' 			=> bcrypt(1213888),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
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
