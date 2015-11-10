<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctionBidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('auction_bids', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('auctions_id')->unsigned()->default(0);
			$table->foreign('auctions_id')->references('id')->on('auctions')->onDelete('cascade');
			$table->integer('users_id')->unsigned()->default(0);
			$table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
			$table->decimal('bid_amount', 5, 2)->nullable();
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
		Schema::drop('auction_bids');
	}

}
