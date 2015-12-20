<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueRoster extends Model {

    //
    protected $table = 'league_roster';
    protected $fillable = array('leagues_id', 'movies_id', 'users_id', 'bid_amount', 'total_gross', 'value_for_money', 'takings_end_date');

    public function movie() {
        return $this->belongsTo("\App\Models\Movie", "movies_id");
    }

    public function league() {
        return $this->belongsTo("\App\Models\League", "leagues_id");
    }

    public function owner() {
        return $this->belongsTo("\App\Models\User", "users_id");
    }

    public function rankings($leagues_id) {
        $league_position_sql = "SELECT users_id, sum(ifnull(total_gross, 0)) AS total_gross, sum(ifnull(value_for_money, 0)) AS vfm 
        FROM league_roster WHERE leagues_id = '".$leagues_id."' GROUP BY users_id ORDER BY SUM(total_gross) DESC";



    }
}
