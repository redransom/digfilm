<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LeagueUser;
use DB;
use Log;
use Mail;
use App\Models\Movie;
use App\Models\LeagueMovie;
use App\Models\User;

class League extends Model {

    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'users_id', 'enabled', 'auction_stage', 'auction_start_date', 'auction_close_date', 'file_name', 'description', 'rule_sets_id', 'meta_keywords', 'meta_description', 'type'];

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
        $leagueUsers = LeagueUser::where('user_id', $user_id)->lists('league_id');

        $leagues = League::where('users_id', '!=', $user_id)->
                where('enabled', '1')
                ->Where(function ($query) {
                    $query->whereNull('auction_stage')->orWhere('auction_stage', '<', '4');
                })->whereNotIn('id', $leagueUsers)->get();

        return $leagues;
    }

    public function stage() {
        $stage = "";
        if (is_null($this->auction_stage))
            $stage = "Awaiting Players";
        elseif ($this->auction_stage == 0)
            $stage = "Ready to start";
        elseif ($this->auction_stage == 1)
            $stage = "In Play";
        elseif ($this->auction_stage == 2)
            $stage = "Roster Time!";
        else
            $stage = "Game Over";

        return $stage;
    }

    public static function livePublicLeagues() {
        return League::where('type', 'U')->where('enabled', 1)
                ->Where(function ($query) {
                    $query->whereNull('auction_stage')->orWhere('auction_stage', '<', '4');
                })->get();
    }

    public function hasImage() {
        return (!is_null($this->file_name) && $this->file_name != "") ? true : false;
    }

    public function leagueImage() {
        if(!is_null($this->file_name))
            return asset($this->file_name);
        else
            return asset('/images/TNBF_league_image.jpg');        
    }

    public function populateMovies() {
        $rules = $this->rule;

        //need to find the required number of movies
        //get the minimum for now
        $min_movies = $rules->min_movies;
        $max_bid = $rules->max_bid;

        //TODO: Make this option as a rule maybe?
        $earliest_release_date = strtotime("+1 week", strtotime($this->auction_close_date));
        $latest_release_date = strtotime("+3 months", strtotime($this->auction_close_date));

        //randomly populate movies
        if (is_null($max_bid) || $max_bid == '')
            $max_bid = 100;
        
/*        $available_movies = Movie::where('release_at', '>', date("Y-m-d", $earliest_release_date))
            ->Where(function ($query) use ($max_bid) {
                $query->where('opening_bid', '<=', $max_bid)->orWhereNull('opening_bid');
            })->where('release_at', '<', date("Y-m-d", $latest_release_date))->lists('id');
*/
        $available_movies = Movie::availableMovies($this->auction_close_date, $max_bid);
        $available_movie_count = count($available_movies);
        
        //clear out movies if some already there
        LeagueMovie::where('leagues_id', $this->id)->delete();
        Log::info("Movie Check - Available: ".count($available_movies)." Min Required: ".$min_movies);

        //if Movie amount is less than what's required - we need to get an amount that is allowable based on 
        //the auction type. the auction movie release option determines if we can take all
        //available movies or a select amount
        $grouping = $rules->auction_movie_release;
        if (is_null($grouping) || $grouping == 0) {
            //all movies to be added
            if ($min_movies > $available_movie_count)
                $min_movies = $available_movie_count;

        } else {
            //make a calculation to determine which is the best set of movies to take
            /* this works as:
                max movies is 34 
                total required is 50 
                not possible so using grouping of 10
                34 / 10 = 3.4 which we then round down to 3
                3 * 10 = 30 movies that we can take
            */
            if ($min_movies > $available_movie_count) {
                $movie_multiplier = intval(count($available_movies) / $grouping);
                $min_movies = $movie_multiplier * $grouping;
            }
        }

        //need to make sure we have enough movies
        $chosen_movies = array();
        
        for($movie_no = 0; $movie_no<$min_movies; $movie_no++) {
            $random_pos = rand(0, ($available_movie_count - 1));

            $chosen_movies[$movie_no] = $available_movies[$random_pos];
            unset($available_movies[$random_pos]);
            $available_movies = array_values($available_movies);
            $available_movie_count--;
        }

        //we have the available movies lets add them to the league
        foreach ($chosen_movies as $movie_id) {
            $league_movie = new LeagueMovie();
            $league_movie->leagues_id = $this->id;
            $league_movie->movies_id = $movie_id;
            $league_movie->save();

            //Log::info("Movie - ".$movie_id." added to ".$league->name);

            unset($league_movie);
        }

        //can work out league end date now we have the list of movies
        $maxDate = Movie::whereIn('id', $chosen_movies)->max('release_at');
        $this->end_date = $maxDate;

        //only set this if there are movies added to the league
        //movies have been populated - set the auction stage to 1
        /*if (count($chosen_movies) > 0)
            $this->auction_stage = 1;*/

        $this->save();
        return $chosen_movies;
    }

    /***
     *
     * canJoin - is used to determine if the current user (or not) can join the league - keep the logic in the model rather than the view
     * Status return:
     * -1 = Not Logged In 
     * 0 = No Full
     * 1 = Yes 
     * 2 = Started
     * 3 = Already
     */
    public function canJoin($user = null) {
        if (!is_null($user)) {
            if ($user->id == $this->users_id) {
                return 3;
            } elseif (time() < strtotime($this->auction_start_date)) {
                if(count($this->players) == $this->rule->max_players) {
                    return 0;
                } else {
                    return 1;
                }
            } elseif(time() >= strtotime($this->auction_start_date)) {
                return 2;
            } 
        }
        return -1; //not logged in
    }

    public function value() {
        if ($this->type == 'U') {
            //public league owner does not take part in the game
            $playerCount = $this->players()->count() - 1;
            if ($playerCount == 0) 
                $playerCount = 1; //Needs to be a minimum of 1
        } else {
            //private league everyone is involved
            $playerCount = $this->players()->count();
        }
        $leagueValue = $playerCount * 100; //TODO: remove this into a rule for the league rule set or a league field
        return $leagueValue;
    }

    public function notifyWinner($winners_id) {
        $winner = User::find($winners_id);
        $leagueValue = $this->value();
        $newPlayerBalance = (is_null($winner->balance) ? 0 : $winner->balance) + $leagueValue;

        Log::info("Winner chosen as ".$winner->fullName()." to win ".$newPlayerBalance);

        //we should have the top placing user
        $data = ['winnerName' => $winner->fullName(),
                'leagueName' => $this->name,
                'leagueValue' => $leagueValue,
                'playerBalance' => $newPlayerBalance,
                'subject' => 'You have won the league!'];

        $winnerEmail = $winner->email;
        Mail::send('emails.league_winner', $data, function($message) use ($winnerEmail)
        {
            $message->from('leagues@thenextbigfilm.com', 'TheNextBigFilm Entertainment');
            $message->subject('You have won the league!');
            $message->to($winnerEmail);
        });
    
        //lets update the winners balance
        User::where('id', $winner->id)->update(['balance'=>$newPlayerBalance]);

        //update the league with the winner 
        $this->setWinner($winners_id);
    }

    public function setWinner($winner_id) {
        League::where('id', $this->id)->update(['enabled'=>'0', 'auction_stage'=>'5', 'winners_id'=>$winner_id]);
    }
}
