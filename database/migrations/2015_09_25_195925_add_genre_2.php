<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenre2 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movies', function(Blueprint $table)
		{
			// need to remove the limit field as it's not necessary now
			//$table->dropColumn('genre');

			//add genres link
			$table->integer('genres_id')->unsigned()->default(1);
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
