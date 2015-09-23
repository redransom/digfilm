<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRuleSet extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('rule_sets', function(Blueprint $table)
		{
			//
			$table->decimal('ind_film_countdown', 3)->nullable();
			$table->string('joint_ownership', 1)->default('N');
			$table->decimal('min_bid', 3 , 2)->nullable();
			$table->decimal('max_bid', 3 , 2)->nullable();
			$table->string('randomizer', 1)->default('N');
			$table->string('auction_movie_release', 1)->nullable();
			$table->time('start_time')->nullable();
			$table->time('close_time')->nullable();
			$table->string('league_type', 1)->default('R');
			$table->string('auto_select', 1)->default('Y');
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
