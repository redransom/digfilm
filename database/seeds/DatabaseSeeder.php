<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('RoleTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('ContributorTypeTableSeeder');
		$this->call('GenreTableSeeder');
		$this->call('MovieTableSeeder');
		$this->call('RuleSetTableSeeder');
	}

}
