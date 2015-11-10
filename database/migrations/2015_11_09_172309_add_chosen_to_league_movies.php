<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChosenToLeagueMovies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('league_movies', function(Blueprint $table)
		{
			$table->tinyInteger('chosen')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('league_movies', function(Blueprint $table)
		{
			$table->dropColumn('chosen');
		});
	}

}
