<?php

use App\Models\Dosen;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class DosenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$dosenRole = Role::where('role', 'Dosen')->first();

    	$data = [
    		[
    			'nip' 				=> 1315020100,
    			'nama' 				=> 'Lynch Dickinson',
    			'alamat' 			=> 'Bandung Timur',
    			'nomor_telepon' 	=> '+6285000000000',
    			'role_id' 			=> $dosenRole->id,
    			'email' 			=> 'lynch@example.com',
    			'password' 			=> bcrypt(1315020100),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nip' 				=> 1315020200,
    			'nama' 				=> 'Pakih Rottenface',
    			'alamat' 			=> 'Bandung Barat',
    			'nomor_telepon' 	=> '+6285000000000',
    			'role_id' 			=> $dosenRole->id,
    			'email' 			=> 'pakih@example.com',
    			'password' 			=> bcrypt(1315020200),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nip' 				=> 1315020300,
    			'nama' 				=> 'Eutik McMahon',
    			'alamat' 			=> 'Bandung Selatan',
    			'nomor_telepon' 	=> '+6285000000000',
    			'role_id' 			=> $dosenRole->id,
    			'email' 			=> 'eutik@example.com',
    			'password' 			=> bcrypt(1315020300),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
    			'nip' 				=> 1315020400,
    			'nama' 				=> 'Carlson Subagja',
    			'alamat' 			=> 'Bandung Utara',
    			'nomor_telepon' 	=> '+6285000000000',
    			'role_id' 			=> $dosenRole->id,
    			'email' 			=> 'carlson@example.com',
    			'password' 			=> bcrypt(1315020400),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    	];

    	foreach ($data as $dosen) {
    		$ds = Dosen::create(Arr::except($dosen, [
    			'email',
    			'password',
    			'role_id',
    			'remember_token',
    			'email_verified_at'
    		]));

    		$ds->user()->create(Arr::only($dosen, [
    			'email',
    			'password',
    			'role_id',
    			'remember_token',
    			'email_verified_at'
    		]));
    	}
    }
}
