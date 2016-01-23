<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitecontentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_content', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('owners_id')->unsigned()->nullable();
			$table->foreign('owners_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('section', 3)->default('');
			$table->string('type', 1)->default('C');
			$table->string('title', 200)->default('');
			$table->string('summary', 300)->nullable();
			$table->string('body', 4000)->default('');
			$table->string('thumbnail', 150)->default('');
			$table->string('main_image', 150)->nullable();
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
		Schema::drop('site_content');
	}

}
