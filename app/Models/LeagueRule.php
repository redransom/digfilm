<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueRule extends Model {

    //
    protected $table = 'league_rules';
    protected $fillable = array('leagues_id', 'min_players', 'max_players', 'min_movies', 'max_movies', 'auction_duration');
}
