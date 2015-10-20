<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoundDurationToRules extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rule_sets', function(Blueprint $table)
		{
			$table->integer('round_duration')->unsigned()->default(0);
			$table->decimal('denomination', 4, 2)->default(0.5);
			$table->decimal('movie_takings_duration', 3, 1)->default(8.0);
		});

		Schema::table('league_rules', function(Blueprint $table)
		{
			$table->integer('round_duration')->unsigned()->default(0);
			$table->decimal('denomination', 4, 2)->default(0.5);
			$table->decimal('movie_takings_duration', 3, 1)->default(8.0);
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
		Schema::table('rule_sets', function(Blueprint $table)
		{
			$table->dropColumn('round_duration');
			$table->dropColumn('denomination');
			$table->dropColumn('movie_takings_duration');
		});	

		Schema::table('league_rules', function(Blueprint $table)
		{
			$table->dropColumn('round_duration');
			$table->dropColumn('denomination');
			$table->dropColumn('movie_takings_duration');
		});	
	}

}
