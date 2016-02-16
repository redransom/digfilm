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
    protected $fillable = ['name', 'users_id', 'enabled', 'auction_stage', 'auction_start_date', 'auction_close_date', 'file_name', 'description'];

    public function owner() {
        return $this->belongsTo("\App\Models\User", "users_id");
    }

    public function players() {
        return $this->belongsToMany("\App\Models\User", "league_users", "league_id", "user_id")->withPivot(['balance', 'id']);
    }

    public function movies() {
        return $this->belongsToMany("\App\Models\Movie", "league_movies", "leagues_id", "movies_id")->withPivot(['id', 'chosen']);
    }

    public function rule() {
        return $this->hasOne("\App\Models\LeagueRule", "leagues_id");
    }

    public function auctions() {
        return $this->belongsToMany("\App\Models\Movie", "auctions", "leagues_id", "movies_id")->withPivot(['bid_amount', 'auction_start_time', 'auction_end_time', 'users_id', 'id', 'ready_for_auction', 'created_at', 'updated_at', 'initial_bid']);
    }

    public function rosters() {
        return $this->hasMany("\App\Models\LeagueRoster", 'leagues_id', 'id');
    }

    public function rule_set() {
        return $this->belongsTo("\App\Models\RuleSet", "rule_sets_id");
    }

    public function messages() {
        return $this->hasMany("\App\Models\LeagueMessage", 'leagues_id', 'id');
    }

    /**
     * Model function to determine if a user can register with a league
     * Need to make sure that they are not owners of a league and also not in the league users table.
     *
     * @var array
     */
    public static function availableLeagues($user_id) {
        $leagueUsers = LeagueUser::where('user_id', $user_id)->lists('id');

        $leagues = League::where('users_id', '!=', $user_id)->
                where('enabled', '1')
                ->Where(function ($query) {
                    $query->whereNull('auction_stage')->orWhere('auction_stage', '<', '4');
                })->whereNotIn('id', $leagueUsers)->get();
        return $leagues;
    }
}
