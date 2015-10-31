<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOpeningbidToInitialbidAuctions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('auctions', function(Blueprint $table)
		{
			$table->renameColumn('opening_bid', 'initial_bid');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('auctions', function(Blueprint $table)
		{
			$table->renameColumn('initial_bid', 'opening_bid');
		});
	}

}
