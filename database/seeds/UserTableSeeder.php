<?php 

use Illuminate\Database\Seeder;
use TeachMe\Entities\User;

/**
* Seeder for User
*/
class UserTableSeeder extends Seeder
{
	
	public function run()
	{
		$this->createAdmin();
	}

	public function createAdmin()
	{
		User::create([
			'name' => 'Yoel Monzon',
			'email' => 'yoelfme@hotmail.com',
			'password' => bcrypt('admin')
		]);
	}

}