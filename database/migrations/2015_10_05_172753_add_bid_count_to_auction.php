<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBidCountToAuction extends Migration {

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
			$table->integer('bid_count')->unsigned()->default(0);
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
			$table->dropColumn('bid_count');
		});

	}

}
