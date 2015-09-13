<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueMovies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('league_movies', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('leagues_id')->unsigned()->default(0);
			$table->foreign('leagues_id')->references('id')->on('leagues')->onDelete('cascade');
			$table->integer('movies_id')->unsigned()->default(0);
			$table->foreign('movies_id')->references('id')->on('movies')->onDelete('cascade');
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
