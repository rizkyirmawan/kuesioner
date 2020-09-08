<?php

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MahasiswaTableSeeder extends Seeder
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

    	$kelasRegPagi = Kelas::where('kode', 'REG-A')->first();

    	$kelasRegSore = Kelas::where('kode', 'REG-B')->first();

    	$mahasiswaRole = Role::where('role', 'Mahasiswa')->first();

    	$data = [
    		[
    			'nim' 				=> 1216003,
    			'nama' 				=> 'Rizky Irmawan Rahayu',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2016',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung Barat',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'rizky@example.com',
    			'password' 			=> bcrypt(1216003),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215004,
    			'nama' 				=> 'Muhamad Fajar Sidiq',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'fajar@example.com',
    			'password' 			=> bcrypt(1215004),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215011,
    			'nama' 				=> 'Fahmi Ari Guntara',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'fahmi@example.com',
    			'password' 			=> bcrypt(1215011),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215602,
    			'nama' 				=> 'Nasratul Hasnah',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'nasratul@example.com',
    			'password' 			=> bcrypt(1215602),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215604,
    			'nama' 				=> 'Ari Julianto',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'ari@example.com',
    			'password' 			=> bcrypt(1215604),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215605,
    			'nama' 				=> 'Dani Ramdhani',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'dani@example.com',
    			'password' 			=> bcrypt(1215605),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215606,
    			'nama' 				=> 'M. Ghozali',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'ghozali@example.com',
    			'password' 			=> bcrypt(1215606),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215607,
    			'nama' 				=> 'Syaiful Fitrawan',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'syaiful@example.com',
    			'password' 			=> bcrypt(1215607),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215613,
    			'nama' 				=> 'Angga Muhammad Fauzi',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'angga@example.com',
    			'password' 			=> bcrypt(1215613),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215614,
    			'nama' 				=> 'Sukamdi',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'sukamdi@example.com',
    			'password' 			=> bcrypt(1215614),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215615,
    			'nama' 				=> 'Rangga Reza Noviadi',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'rangga@example.com',
    			'password' 			=> bcrypt(1215615),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215705,
    			'nama' 				=> 'Fikalis Nong Emu',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'fikalis@example.com',
    			'password' 			=> bcrypt(1215705),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215709,
    			'nama' 				=> 'Mora Nur Akbar T',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'mora@example.com',
    			'password' 			=> bcrypt(1215709),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nim' 				=> 1215712,
    			'nama' 				=> 'Marulitua Situmorang',
    			'jurusan_id' 		=> $jurusanIF->id,
    			'kelas_id' 			=> $kelasRegPagi->id,
    			'angkatan' 			=> '2015',
    			'jenis_kelamin' 	=> 'Laki-laki',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6289000000000',
    			'role_id' 			=> $mahasiswaRole->id,
    			'email' 			=> 'marulitua@example.com',
    			'password' 			=> bcrypt(1215712),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		]
    	];

    	foreach ($data as $mahasiswa) {
    		$mhs = Mahasiswa::create(Arr::except($mahasiswa, [
    			'email',
    			'password',
    			'role_id',
    			'email_verified_at',
    			'remember_token'
    		]));

    		$mhs->user()->create(Arr::only($mahasiswa, [
    			'email',
    			'password',
    			'role_id',
    			'email_verified_at',
    			'remember_token'
    		]));
    	}
    }
}
