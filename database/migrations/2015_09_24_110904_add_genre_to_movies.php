<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenreToMovies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('movies', function(Blueprint $table)
		{
			// need to remove the current genre field added previously
			$table->dropColumn('votes');

			//add link to new genres table
			$table->integer('genres_id')->unsigned()->default(0);
			$table->foreign('genres_id')->references('id')->on('genres')->onDelete('cascade');
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
