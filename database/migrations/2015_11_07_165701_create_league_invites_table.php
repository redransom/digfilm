<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueInvitesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('league_invites', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('leagues_id')->unsigned()->default(0);
			$table->foreign('leagues_id')->references('id')->on('leagues')->onDelete('cascade');
			$table->integer('users_id')->unsigned()->default(0);
			$table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('name', 50)->nullable();
			$table->string('email', 100)->nullable();
			$table->string('status', 1)->default('I');
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
		Schema::drop('league_invites');
	}

}
