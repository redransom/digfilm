<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWinnersIdToLeague extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('leagues', function(Blueprint $table)
		{
			$table->integer('winners_id')->unsigned()->nullable();
			$table->foreign('winners_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('leagues', function(Blueprint $table)
		{
			$table->dropColumn('winners_id');
		});
	}

}
