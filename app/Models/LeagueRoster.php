<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\League;
use DB;

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

    public static function rankings($leagues_id) {

        $rankings = LeagueRoster::selectRaw('users_id, sum(ifnull(total_gross, 0)) AS total_gross, sum(ifnull(value_for_money, 0)) AS vfm')
            ->groupBy('users_id')->where('leagues_id', $leagues_id);

        //echo($rankings->toSql());
        return $rankings;
    }

    public static function populate($league_id) {
        $league = League::find($league_id);
        $created_at = date("Y-m-d H:i:s");

        if ($league->rule->blind_bid == 'N') {
            DB::insert(DB::raw("INSERT INTO league_roster
    (leagues_id, users_id, movies_id, bid_amount, takings_end_date, created_at)
    SELECT A.leagues_id, users_id, movies_id, bid_amount, DATE_ADD(M.release_at, INTERVAL LR.movie_takings_duration WEEK), '".$created_at."' 
    FROM auctions A INNER JOIN league_rules LR ON A.leagues_id = LR.leagues_id
    INNER JOIN movies M ON A.movies_id = M.id
    WHERE A.leagues_id = '".$league_id."' AND bid_count > 0"));

        } else {
            $sql = "INSERT INTO league_roster
    (leagues_id, users_id, movies_id, bid_amount, takings_end_date, created_at)
    SELECT A.leagues_id, ab.users_id, A.movies_id, A.bid_amount, DATE_ADD(M.release_at, INTERVAL LR.movie_takings_duration WEEK), '".$created_at."' 
    FROM auctions A 
        INNER JOIN league_rules LR ON A.leagues_id = LR.leagues_id
        INNER JOIN movies M ON A.movies_id = M.id 
        INNER JOIN auction_bids ab ON A.id = ab.auctions_id 
        INNER JOIN (SELECT min(ab.created_at) as created_at, ab.movies_id, ab.bid_amount FROM auction_bids ab 
                INNER JOIN auctions a ON ab.auctions_id = a.id and a.bid_amount = ab.bid_amount
                WHERE a.leagues_id = ".$league_id." GROUP BY movies_id, bid_amount) ab2
                ON ab.created_at = ab2.created_at and ab.movies_id = ab2.movies_id and ab.bid_amount = ab2.bid_amount
        WHERE A.leagues_id = '".$league_id."'";

            DB::insert(DB::raw($sql));

        }
    }
}
