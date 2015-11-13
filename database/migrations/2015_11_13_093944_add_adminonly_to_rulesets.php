<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminonlyToRulesets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rule_sets', function(Blueprint $table)
		{
			$table->string('admin_only', 1)->default('N');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('rule_sets', function(Blueprint $table)
		{
			$table->dropColumn('admin_only');
		});	
	}

}
