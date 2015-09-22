<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueRules extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('league_rules', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('leagues_id')->unsigned()->default(0);
			$table->foreign('leagues_id')->references('id')->on('leagues')->onDelete('cascade');
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
