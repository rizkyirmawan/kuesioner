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
                'kode'              => 'MN',
    			'nidn' 				=> '0826098201',
    			'nama' 				=> 'MINA ISMU RAHAYU, MT',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6281321131982',
    			'role_id' 			=> $dosenRole->id,
    			'email' 			=> 'ismurahayu@gmail.com',
    			'password' 			=> bcrypt('dosen'),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
    		[
                'kode'              => 'SY',
    			'nidn' 				=> '1017078801',
    			'nama' 				=> 'SITI YULIANTI, M.KOM',
    			'alamat' 			=> 'Bandung',
    			'nomor_telepon' 	=> '+6281785879875',
    			'role_id' 			=> $dosenRole->id,
    			'email' 			=> 'sitiyuliyanti@gmail.com',
    			'password' 			=> bcrypt('dosen'),
    			'remember_token' 	=> Str::random(10),
    			'email_verified_at'	=> Carbon::now()
    		],
            [
                'kode'              => 'RN',
                'nidn'              => '0020087901',
                'nama'              => 'RINI NURAINI SUKMANA, MT',
                'alamat'            => 'Bandung',
                'nomor_telepon'     => '+628882024236',
                'role_id'           => $dosenRole->id,
                'email'             => 'rnurainisukmana@gmail.com',
                'password'          => bcrypt('dosen'),
                'remember_token'    => Str::random(10),
                'email_verified_at' => Carbon::now()
            ],
            [
                'kode'              => 'UA',
                'nidn'              => '0403027304',
                'nama'              => 'URO ABDULROHIM, MT',
                'alamat'            => 'Bandung',
                'nomor_telepon'     => '+6287822988483',
                'role_id'           => $dosenRole->id,
                'email'             => 'uroabdulrohim@gmail.com',
                'password'          => bcrypt('dosen'),
                'remember_token'    => Str::random(10),
                'email_verified_at' => Carbon::now()
            ],
            [
                'kode'              => 'IM',
                'nidn'              => '10241184001',
                'nama'              => 'INDRA MAULANA YUSUP KUSUMAH, M.KOM',
                'alamat'            => 'Bandung',
                'nomor_telepon'     => '+6285659021234',
                'role_id'           => $dosenRole->id,
                'email'             => 'indramaulanayk@gmail.com',
                'password'          => bcrypt('dosen'),
                'remember_token'    => Str::random(10),
                'email_verified_at' => Carbon::now()
            ],
            [
                'kode'              => 'YJ',
                'nidn'              => '0410087711',
                'nama'              => 'YUS JAYUSMAN, MT',
                'alamat'            => 'Bandung',
                'nomor_telepon'     => '+628156037494',
                'role_id'           => $dosenRole->id,
                'email'             => 'yusjayusman@gmail.com',
                'password'          => bcrypt('dosen'),
                'remember_token'    => Str::random(10),
                'email_verified_at' => Carbon::now()
            ]
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
