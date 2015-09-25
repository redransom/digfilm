<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuctionStartToLeague extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leagues', function(Blueprint $table)
		{
			// need to remove the limit field as it's not necessary now
			//$table->dropColumn('limit');

			//add auction dates to the leagues table
			$table->datetime('auction_start_date')->nullable();
			$table->datetime('auction_close_date')->nullable();
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
