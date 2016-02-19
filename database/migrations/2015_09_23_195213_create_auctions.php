<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuctions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('auctions', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->integer('leagues_id')->unsigned()->default(0);
			$table->foreign('leagues_id')->references('id')->on('leagues')->onDelete('cascade');
			$table->integer('movies_id')->unsigned()->default(0);
			$table->foreign('movies_id')->references('id')->on('movies')->onDelete('cascade');
			$table->integer('users_id')->unsigned()->nullable();
			$table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
			$table->decimal('bid_amount', 5, 2)->nullable();
			$table->time('auction_start_time')->nullable();
			$table->time('auction_end_time')->nullable();
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
		//
	}

}