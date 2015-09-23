<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleSet extends Model {

    //
    protected $table = 'rule_sets';
    protected $fillable = array('name', 'description', 'min_players', 'max_players', 'min_movies', 'max_movies', 'auction_duration', 'ind_film_countdown', 'min_bid', 'max_bid',
        'randomizer', 'auction_movie_release', 'start_time', 'close_time', 'league_type', 'auto_select', 'joint_ownership');
}