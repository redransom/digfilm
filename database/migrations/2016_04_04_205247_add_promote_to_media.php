<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPromoteToMedia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movie_media', function(Blueprint $table)
		{
			$table->string('image_type', 1)->default('F');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('movie_media', function(Blueprint $table)
		{
			$table->dropColumn('image_type');
		});
	}

}
