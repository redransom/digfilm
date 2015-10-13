<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOpeningBidToAuction extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('auctions', function(Blueprint $table)
		{
			$table->decimal('opening_bid', 5, 2)->nullable();
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
		Schema::table('auctions', function(Blueprint $table)
		{
			$table->dropColumn('opening_bid');
		});
	}

}
