<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieTakings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('movie_takings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('amount', 10, 2)->nullable();
			$table->string('country', 3)->nullable();
			$table->date('takings_at')->nullable();
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
