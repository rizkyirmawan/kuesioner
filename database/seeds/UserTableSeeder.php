<?php

use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$adminRole = Role::where('role', 'Admin')->first();

		User::insert([
			[
				'email' => 'admin@example.com',
				'password' => bcrypt('password'),
				'remember_token' => Str::random(10),
				'email_verified_at' => Carbon::now(),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
				'role_id' => $adminRole->id
			]
		]);
	}
}
