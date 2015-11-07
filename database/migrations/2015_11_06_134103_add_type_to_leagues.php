<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToLeagues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leagues', function(Blueprint $table)
		{
			$table->string('type', 1)->default('U');
		});

		DB::statement('UPDATE leagues, league_rules SET leagues.type = league_rules.league_type WHERE leagues.id = league_rules.leagues_id');
		//DB::table('leagues')->join('league_rules', 'leagues.id', '=', 'league_rules.leagues_id')->update(['type'=>'league_rules.league_type']);

		Schema::table('rule_sets', function(Blueprint $table)
		{
			$table->dropColumn('league_type');
		});

		Schema::table('league_rules', function(Blueprint $table)
		{
			$table->dropColumn('league_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('leagues', function(Blueprint $table)
		{
			$table->dropColumn('type');
		});
	}

}
