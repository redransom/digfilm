<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoviesToSitecontent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('site_content', function(Blueprint $table)
		{
			$table->integer('movies_id')->unsigned()->nullable();
			$table->foreign('movies_id')->references('id')->on('movies')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('site_content', function(Blueprint $table)
		{
			$table->dropColumn('movies_id');
		});
	}

}
