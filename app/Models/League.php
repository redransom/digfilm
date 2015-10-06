<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LeagueUser;

class League extends Model {

    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'users_id', 'enabled'];


    public function owner() {
        return $this->belongsTo("\App\Models\User", "users_id");
    }

    public function players() {
        return $this->belongsToMany("\App\Models\User", "league_users", "league_id", "user_id");
    }

    public function movies() {
        return $this->belongsToMany("\App\Models\Movie", "league_movies", "leagues_id", "movies_id")->withPivot('id');
    }

    public function rule() {
        return $this->hasOne("\App\Models\LeagueRule", "leagues_id");
    }

    public function auctions() {
        return $this->belongsToMany("\App\Models\Movie", "auctions", "leagues_id", "movies_id")->withPivot(['bid_amount', 'auction_start_time', 'auction_end_time', 'users_id', 'id', 'ready_for_auction']);
    }

    /**
     * Model function to determine if a user can register with a league
     * Need to make sure that they are not owners of a league and also not in the league users table.
     *
     * @var array
     */
    public static function availableLeagues($user_id) {
        $leagueUsers = LeagueUser::where('user_id', '=', $user_id)->lists('id');

        $leagues = League::where('users_id', '!=', $user_id)->whereNotIn('id', $leagueUsers)->get();

        /*$leagues = League::with(['league_users' => function($query) {
            $query->where('user_id', '!=', $user_id);
        }])->where('users_id', '!=', $user_id)->get();*/
        return $leagues;
    }
}
