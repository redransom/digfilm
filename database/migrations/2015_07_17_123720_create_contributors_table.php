<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contributor_types', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->string('name', 50)->default('');
			$table->timestamps();
		});

		Schema::create('contributors', function(Blueprint $table)
		{
			//
			$table->increments('id');
			
			$table->string('first_name', 20)->default('');
			$table->string('surname', 20)->default('');
			$table->timestamps();
		});

		Schema::create('contributor_contributor_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contributors_id')->unsigned()->default(0);
			$table->foreign('contributors_id')->references('id')->on('contributors')->onDelete('cascade');
			$table->integer('contributor_types_id')->unsigned()->default(0);
			$table->foreign('contributor_types_id')->references('id')->on('contributor_types')->onDelete('cascade');
			$table->timestamps();
		});


		Schema::create('movies_contributors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('movies_id')->unsigned()->default(0);
			$table->foreign('movies_id')->references('id')->on('movies')->onDelete('cascade');
			$table->integer('contributors_id')->unsigned()->default(0);
			$table->foreign('contributors_id')->references('id')->on('contributors')->onDelete('cascade');
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
		Schema::drop('contributors');
		Schema::drop('contributor_types');
		Schema::drop('contributor_contributor_types');
		Schema::drop('movies_contributors');
	}

}
