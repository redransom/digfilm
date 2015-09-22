<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuleSets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rule_sets', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->string('name', 100);
			$table->string('description', 500)->nullable();
			$table->integer('min_players')->unsigned()->default(4);
			$table->integer('max_players')->unsigned()->default(10);
			$table->integer('min_movies')->unsigned()->default(40);
			$table->integer('max_movies')->unsigned()->default(40);
			$table->integer('auction_duration')->unsigned()->default(6);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
