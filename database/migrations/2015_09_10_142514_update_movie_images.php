<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMovieImages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//rename as its not just movie images in this table now
		Schema::rename('movie_images', 'movie_media');

		Schema::table('movie_media', function(Blueprint $table)
		{
			//
			$table->string('description', 500)->nullable();
			$table->string('url', 500)->nullable();
			$table->string('type', 20)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//#
		Schema::drop('movie_media');
	}

}
