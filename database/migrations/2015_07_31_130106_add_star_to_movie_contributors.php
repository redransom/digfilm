<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStarToMovieContributors extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movies_contributors', function(Blueprint $table)
		{
			//
			$table->string('star', 1)->default('N');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('movies_contributors', function(Blueprint $table)
		{
			//
		});
	}

}
