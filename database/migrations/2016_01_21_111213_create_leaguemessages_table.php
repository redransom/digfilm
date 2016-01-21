<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguemessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('league_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('leagues_id')->unsigned()->nullable();
			$table->foreign('leagues_id')->references('id')->on('leagues')->onDelete('cascade');
			$table->integer('owners_id')->unsigned()->nullable();
			$table->foreign('owners_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('message', 500)->default('');
			$table->date('read_date')->nullable();
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
		Schema::drop('league_messages');
	}

}
