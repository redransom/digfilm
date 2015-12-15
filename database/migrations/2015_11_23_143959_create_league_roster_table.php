<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueRosterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('league_roster', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('leagues_id')->unsigned()->nullable();
			$table->foreign('leagues_id')->references('id')->on('leagues')->onDelete('cascade');
			$table->integer('users_id')->unsigned()->nullable();
			$table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('movies_id')->unsigned()->nullable();
			$table->foreign('movies_id')->references('id')->on('movies')->onDelete('cascade');
			$table->decimal('bid_amount', 5, 2)->nullable();
			$table->decimal('total_gross', 15, 2)->nullable();
			$table->decimal('value_for_money', 15, 3)->nullable();
			$table->date('takings_end_date')->nullable();
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
		Schema::drop('league_roster');
	}

}
