<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContributorTypeToMovieContributors extends Migration {

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
			$table->integer('contributor_types_id')->unsigned()->default(0);
			$table->foreign('contributor_types_id')->references('id')->on('contributor_types')->onDelete('cascade');

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
