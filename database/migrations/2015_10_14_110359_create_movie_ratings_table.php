<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movie_ratings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('movies_id')->unsigned()->default(0);
			$table->foreign('movies_id')->references('id')->on('movies')->onDelete('cascade');
			$table->integer('ratings_id')->unsigned()->default(0);
			$table->foreign('ratings_id')->references('id')->on('ratings')->onDelete('cascade');
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
		Schema::drop('movie_ratings');
	}

}
