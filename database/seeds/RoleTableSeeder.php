<?php

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Role::insert([
			[
				'role' => 'Admin',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'role' => 'Mahasiswa',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'role' => 'Dosen',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'role' => 'Alumni',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]
		]);
	}
}
