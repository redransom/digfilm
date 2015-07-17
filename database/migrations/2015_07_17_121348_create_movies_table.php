<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movies', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->string('name', 200)->default('');
			$table->string('summary', 500)->default('');
			$table->timestamps();
		});

		/*Schema::create('leagues_movies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('leagues_id')->unsigned()->default(0);
			$table->foreign('leagues_id')->references('id')->on('leagues')->onDelete('cascade');
			$table->integer('movies_id')->unsigned()->default(0);
			$table->foreign('movies_id')->references('id')->on('movies')->onDelete('cascade');
			$table->timestamps();
		});*/

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('movies');
	}

}
