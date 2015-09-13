<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueMovie extends Model {

    //
    protected $table = 'league_movies';
    protected $fillable = array('leagues_id', 'movies_id');
}
