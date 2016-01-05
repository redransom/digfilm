<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBidincrementRules extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rule_sets', function(Blueprint $table)
		{
			$table->decimal('min_increment', 5, 2)->default(0.5);
			$table->decimal('max_increment', 5, 2)->default(1);
		});

		DB::statement('UPDATE rule_sets SET min_increment = denomination WHERE denomination IS NOT NULL');

		Schema::table('rule_sets', function(Blueprint $table)
		{
			$table->dropColumn('denomination');
		});

		Schema::table('league_rules', function(Blueprint $table)
		{
			$table->decimal('min_increment', 5, 2)->default(0.5);
			$table->decimal('max_increment', 5, 2)->default(1);
		});

		DB::statement('UPDATE league_rules SET min_increment = denomination WHERE denomination IS NOT NULL');

		Schema::table('league_rules', function(Blueprint $table)
		{
			$table->dropColumn('denomination');
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
		Schema::table('rule_sets', function(Blueprint $table)
		{
			$table->dropColumn('min_increment');
			$table->dropColumn('max_increment');
		});

		Schema::table('league_rules', function(Blueprint $table)
		{
			$table->dropColumn('min_increment');
			$table->dropColumn('max_increment');
		});
	}

}
