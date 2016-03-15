<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnableToContent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('site_content', function(Blueprint $table)
		{
			$table->boolean('enabled')->default(1);
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
			$table->dropColumn('enabled');
		});
	}

}
