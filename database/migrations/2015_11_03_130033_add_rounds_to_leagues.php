<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoundsToLeagues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leagues', function(Blueprint $table)
		{
			$table->smallInteger('round_amount')->nullable();
			$table->smallInteger('current_round')->nullable();
			$table->date('round_start_date')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table->dropColumn('round_amount');
		$table->dropColumn('current_round');
		$table->dropColumn('round_start_date');
	}

}
