<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeoMetaFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('site_content', function(Blueprint $table)
		{
			$table->string('meta_keywords', 200)->default('');
			$table->string('meta_description', 200)->default('');
		});

		Schema::table('contributors', function(Blueprint $table)
		{
			$table->string('meta_keywords', 200)->default('');
			$table->string('meta_description', 200)->default('');
		});

		Schema::table('movies', function(Blueprint $table)
		{
			$table->string('meta_keywords', 200)->default('');
			$table->string('meta_description', 200)->default('');
		});

		Schema::table('leagues', function(Blueprint $table)
		{
			$table->string('meta_keywords', 200)->default('');
			$table->string('meta_description', 200)->default('');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('site_content', function(Blueprint $table)
		{
			$table->dropColumn('meta_keywords');
			$table->dropColumn('meta_description');
		});
		Schema::table('contributors', function(Blueprint $table)
		{
			$table->dropColumn('meta_keywords');
			$table->dropColumn('meta_description');
		});
		Schema::table('movies', function(Blueprint $table)
		{
			$table->dropColumn('meta_keywords');
			$table->dropColumn('meta_description');
		});
		Schema::table('leagues', function(Blueprint $table)
		{
			$table->dropColumn('meta_keywords');
			$table->dropColumn('meta_description');
		});
	}

}
