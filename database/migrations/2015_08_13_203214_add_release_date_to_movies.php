<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReleaseDateToMovies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('movies', function(Blueprint $table)
		{
			//
			$table->date('release_at')->nullable();
			$table->boolean('enabled')->default(1);
			$table->smallInteger('availability')->default(40);
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
