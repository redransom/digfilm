<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueRule extends Model {

    //
    protected $table = 'league_rules';
    protected $fillable = array('leagues_id', 'min_players', 'max_players', 'min_movies', 'max_movies', 'auction_duration', 'ind_film_countdown', 'min_bid', 'max_bid',
        'randomizer', 'auction_movie_release', 'start_time', 'close_time', 'league_type', 'auto_select', 'joint_ownership');
}
