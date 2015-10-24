<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRulesetIdToLeagues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('leagues', function(Blueprint $table)
		{
			$table->integer('rule_sets_id')->unsigned()->default(1);
			$table->foreign('rule_sets_id')->references('id')->on('rule_sets')->onDelete('cascade');
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
			$table->dropColumn('rule_sets_id');
		});	
	}

}
