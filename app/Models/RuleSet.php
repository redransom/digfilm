<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleSet extends Model {

    //
    protected $table = 'rule_sets';
    protected $fillable = array('name', 'description', 'min_players', 'max_players', 'min_movies', 'max_movies', 'auction_duration');
}
