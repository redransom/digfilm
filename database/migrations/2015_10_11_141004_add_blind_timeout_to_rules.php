<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlindTimeoutToRules extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('league_rules', function(Blueprint $table)
		{
			$table->string('blind_bid', 1)->default('N');
			$table->integer('auction_timeout')->unsigned()->default(0);
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
		Schema::table('league_rules', function(Blueprint $table)
		{
			$table->dropColumn('blind_bid');
			$table->dropColumn('auction_timeout');
		});		
	}

}
