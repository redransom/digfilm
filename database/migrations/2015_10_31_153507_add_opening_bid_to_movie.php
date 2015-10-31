<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOpeningBidToMovie extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movies', function(Blueprint $table)
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
		Schema::table('movies', function(Blueprint $table)
		{
			$table->dropColumn('opening_bid');
		});			
	}

}
