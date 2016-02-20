<?php namespace App\Http\Controllers;

use Log;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Movie;
use App\Models\Contributor;
use App\Models\ContributorType;
use App\Models\Role;
use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\League;
use App\Models\LeagueUser;
use App\Models\LeagueMovie;
use App\Models\LeagueRule;
use App\Models\LeagueRoster;
use Session;
use Input;
use Redirect;
use Flash;
use Illuminate\Http\Request;
use Mail;

class AuctionsController extends Controller {

    /**
     * Display a listing of the rule sets.
     *
     * @return Response
     */
    public function index($status = '')
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        if ($status == '')
            $leagues = League::whereIn('auction_stage', ['0', '1', '2', '3'])->get();
        elseif($status == '1')
            $leagues = League::whereIn('auction_stage', ['0', '1'])->get();
        elseif($status == '2')
            $leagues = League::where('auction_stage', '2')->get();
        elseif($status == '3')
            $leagues = League::where('auction_stage', '>', '3')->get();

        return View("auctions.all")
            ->with('leagues', $leagues)
            ->with('authUser', $authUser)
            ->with('page_name', 'auctions')
            ->with('instructions', 'All Auctions.')
            ->with('title', 'Auctions');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $types = ContributorType::lists('name', 'id');

        return View("contributors.add")
            ->with('authUser', $authUser)
            //->with('contributor_types', $types)
            ->with('page_name', 'contributor-add')
            ->with('instructions', 'Add New Contributor to Database')
            ->with('title', 'Add Contributor');
    }

    /**
     * Store new bid
     *
     * @return Response
     */
    public function store()
    {
        //      
        $input = Input::all();

        if ($request->file('thumbnail') != "") {
            $imageName = $contributor->id.str_replace(' ', '_', strtolower($input['first_name'])) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
            $request->file('thumbnail')->move(base_path() . '/public/images/contributors/', $imageName);

            $contributor->thumbnail = "/images/contributors/".$imageName;
            $contributor->save();
        }


        return Redirect::route('contributors.index')->with('message', 'Contributor created.');

    }

    /**
     * Display the specified resource.
     *  
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $contributor = Contributor::find($id);
        $title = "Contributor ".$contributor->name;

        return View("contributors.show")
            ->with('authUser', $authUser)
            ->with('contributor', $contributor)
            ->with('object', $contributor)
            ->with('page_name', 'contributor-show')
            ->with('title', $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $contributor = Contributor::find($id);
        $title = "Edit Contributor";

        return View("contributors.edit")
            ->with('authUser', $authUser)
            ->with('contributor', $contributor)
            ->with('object', $contributor)
            ->with('page_name', 'contributor-edit')
            ->with('title', $title);
    }

    /**
     * Update the auction
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        //
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $auction = Auction::find($id);
        $rule = $auction->league->rule;
        $blind = ($rule->blind_bid == 'Y');
        $input = $request->all();

        if($auction->bid_count != 0) {
            //some one else has bid on it previously
            $bid_refund = $auction->bid_amount;
            $prev_bid_user = $auction->users_id;
        } else {
            //record opening bid for analysis purposes
            $auction->initial_bid = $input['bid_amount'];
        }

        //add the new bid to the auction
        if ($blind)
            Log::info('Bid on blind auction:'.$auction->id.' by user:'.$authUser->id.' amount:'.$input['bid_amount']);
        else
            Log::info('Bid on auction:'.$auction->id.' by user:'.$authUser->id.' amount:'.$input['bid_amount']);

        $auction->users_id = $authUser->id;

        /* only update the auction bid_amount if its the first bid or if the bid amount is higher than the previous bid */
        if (is_null($auction->bid_amount) || $input['bid_amount'] > $auction->bid_amount)
            $auction->bid_amount = $input['bid_amount'];

        //check that the bid isnt the max allowed
        if(!$blind && $auction->bid_amount == $rule->max_bid) {
            //need to clear auction
            $auction->ready_for_auction = 4;
            Log::info('Closed auction off:'.$auction->id.' by user:'.$authUser->id.' amount:'.$input['bid_amount']);
        }

        //add minutes to bid
        if (!$blind) {
            if ($rule->ind_film_countdown != 0) {
                //$auction->auction_end_time = date("Y-m-d H:i:s", strtotime('+1 hour', strtotime('+'.intval($rule->ind_film_countdown).' minutes', time())));
                $auction->auction_end_time = date("Y-m-d H:i:s", strtotime('+'.intval($rule->ind_film_countdown).' minutes', time()));
            } else {
                //default it to 10 minutes
                //$auction->auction_end_time = date("Y-m-d H:i:s", strtotime('+1 hour', strtotime('+10 minutes', time())));
                $auction->auction_end_time = date("Y-m-d H:i:s", strtotime('+10 minutes', time()));
            }

            if($auction->timeout != 0) {
                //$auction->timeout_date = date("Y-m-d H:i:s", strtotime('+1 hour', strtotime('+'.intval($auction->timeout).' minutes', time())));
                $auction->timeout_date = date("Y-m-d H:i:s", strtotime('+'.intval($auction->timeout).' minutes', time()));
            }
        }

        $auction->bid_count++;
        $auction->save();

        //create new auction bid for history purposes
        AuctionBid::create(['auctions_id'=>$auction->id, 'users_id'=>$auction->users_id, 'movies_id'=>$auction->movies_id, 
            'bid_amount'=>$auction->bid_amount]);
/*        $bid = new AuctionBid();
        $bid->auctions_id = $auction->id;
        $bid->users_id = $auction->users_id;
        $bid->movies_id = $auction->movies_id;
        $bid->bid_amount = $auction->bid_amount;
        $bid->save();
        unset($bid);*/

        //remove amount from users balance / need to do a check to see if it overrides a previous users amount and gives it too them back
        Log::info('Reduce balance by user:'.$authUser->id.' amount:'.$input['bid_amount']);
        $leagueUser = LeagueUser::where('league_id', $auction->leagues_id)->where('user_id', $authUser->id)->first();
        $leagueUser->balance -= $input['bid_amount'];
        $leagueUser->save();
        unset($leagueUser);

        if (!$blind) {
            if (isset($bid_refund)) {
                Log::info('Refund user:'.$prev_bid_user.' amount:'.$bid_refund);
                $leagueUser = LeagueUser::where('league_id', $auction->leagues_id)->where('user_id', $prev_bid_user)->first();
                $leagueUser->balance += $bid_refund;
                $leagueUser->save();
            }
        }

        return Redirect::route('league-play', [$auction->leagues_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Close the auction
     *
     * @param  int  $id
     * @return Response
     */
    public function close($id)
    {
        //
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $auction = Auction::find($id);
            $message = "";
            if (!empty($auction)) {
                $movie = $auction->movie;
                $league = $auction->league;

                $message = "Auction " .$movie->name. " has been closed in league ".$league->name.".";
                Flash::message($message);
                $auction->ready_for_auction = 2;
                $auction->save();
            }
            return Redirect::route('auctions.index');
        }
        Flash::message('You don\'t have the permissions to complete this task.');
        return Redirect::route('auctions.index');
    }

    /**
     * Bid on auction
     *
     * @param  int  $id
     * @return Response
     */
    public function placeBid($id)
    {
        //
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $auction = Auction::find($id);
        $league = League::find($auction->leagues_id);
        $leagueUser = LeagueUser::where('league_id', $auction->leagues_id)->where('user_id', $authUser->id)->first();
        $rule = $league->rule;

        return View("auctions.placebid")
            ->with('authUser', $authUser)
            ->with('leagueUser', $leagueUser)
            ->with('auction', $auction)
            ->with('rule', $rule);
    }

    /**
     * Clear out auction movies who are live and whose end time is passed.
     *
     * @param  int  $id
     * @return Response
     */
    public function clearEndTimeAuctions($currentTime) 
    {
        //$currentTime = date("Y-m-d H:i:s"); 
        //Log::info("Current Time to clear out: ".$currentTime);
        $affected = Auction::where('ready_for_auction', '1')->where('auction_end_time', '<', $currentTime)->update(['ready_for_auction'=>'2']);
        Log::info("Auction End Time ".$currentTime. " Cleared: ".$affected.' auctions');
    }

    /**
     * Clear out auction movies who are live and whose last bid time was over the league rule
     *
     * @param  int  $id
     * @return Response
     */
    public function clearTimeoutAuctions($currentTime) 
    {    
        //$currentTime = date("Y-m-d H:i:s");
        //Log::info("Current Time to clear time out: ".$currentTime);
        $affected = Auction::where('ready_for_auction', '1')->where('timeout_date', '<', $currentTime)->update(['ready_for_auction'=>'2']);
        Log::info("Auction Time Out ".$currentTime." Cleared: ".$affected.' auctions');
    }

/*    private function getLeagueRule($rules, $league_id) {
        foreach ($rules as $rule) {
            if ($rule->league_id == $league_id)
                return $rule;
        }
    }*/

    /**
     * Set auction codes to 3 when the auction is closed and the auction has not been bidded on
     * Set auctuon code to 4 when the auction is closed and the auction has been bidded on 
     *
     * @param  int  $id
     * @return Response
     */
    public function prepareClearedAuctions() 
    {    
        $currentTime = date("Y-m-d H:i:s"); 
        $this->clearEndTimeAuctions($currentTime);
        $this->clearTimeoutAuctions($currentTime);
        Auction::where('ready_for_auction', '2')->where('bid_count', '0')->update(['ready_for_auction'=>3]);
        Auction::where('ready_for_auction', '2')->where('bid_count', '>', '0')->update(['ready_for_auction'=>4]);
    }


    /**
     * Set leagues to final stage when all auctions are complete
     *
     * @param  int  $id
     * @return Response
     */
    public function completeLeagues() 
    {    
        //clear out auctions that have completed nevermind if the auctions are still due to go on
        $currentTime = date("Y-m-d H:i:s"); 
        $leagues = League::where('auction_stage', 2)->where('auction_close_date', '<', $currentTime)->get();
        foreach($leagues as $league) {
            $league->auction_stage = 3;
            $league->save();

            $this->setRoster($league->id);
        }
    
        //look for leagues where the auction_stage = 2 and have got past the above
        $leagues = League::where('auction_stage', 2)->get();

        //loop through leagues
        foreach($leagues as $league) {
            //we will need to check for round here to make sure there aren't more rounds to add
            $total_auction_count = $league->auctions()->count();
            $movie_count = $league->movies()->count();

            if ($total_auction_count == $movie_count) {
                $auction_count = $league->auctions()->where('ready_for_auction', '<', '2')->count();

                if ($auction_count == 0) {
                    //stage = 3 / auctions are over
                    $league->auction_stage = 3;
                    $league->save();

                    //copy all rosters across
                    $this->setRoster($league->id);
                }
            }
        }


    }


    /**
     * Populate the rosters for a league
     *
     * @param  int  $league_id
     * @return Response
     */
    private function setRoster($league_id) 
    {   
        $created_at = date("Y-m-d H:i:s");

        $league = League::find($league_id);

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

    /**
     * Auctions have started with stage = 1 to see if they need more movies moved in
     * Need to close the movies that are in there
     *
     * @param  int  $id
     * @return Response
     */
    public function loadNextMovies() 
    {
        DB::connection()->enableQueryLog();
        //get all leagues where there are more rounds to play and the end date(start) is less than the current date
        $leaguesStarted = League::where('auction_stage', 2)->where('enabled', '1')
            ->whereRaw('round_amount > current_round')
            ->where('round_start_date', '<', date("Y-m-d H:i"))->get();
        $queries = DB::getQueryLog();
        
        foreach ($leaguesStarted as $league) {
            $rule = $league->rule;

            $movie_no = $rule->auction_movie_release;
            $league_movies_count = $league->movies->count();

            $league->current_round = $league->current_round + 1;
            echo "Round Duration: ".$league->rule->round_duration."<br/>";
            $round_duration = ($league->rule->round_duration != 0) ? $league->rule->round_duration : 1;
            echo "Round: ".$round_duration."<br/>";
            if ($round_duration >= 1)
                $league->round_start_date = date("Y-m-d H:i:s", strtotime("+".$round_duration." hours"));
            else {
                //round duration needs to be multiplied by 100 as it's the number of minutes in decimal 
                //so 0.15 * 100  is 15 mins
                $league->round_start_date = date("Y-m-d H:i:s", strtotime("+".($round_duration * 100)." mins"));            
            }
            echo "Start Date: ".$league->round_start_date."<br/>";
            //clear out auctions that are being superceeded by the new round
            //$this->prepareClearedAuctions();
            //TODO: move this to above function with - all parameter
            Auction::where('leagues_id', $league->id)->whereIn('ready_for_auction', ['1', '2'])
                ->where('bid_count', '0')->update(['ready_for_auction'=>3]);
            Auction::where('leagues_id', $league->id)->whereIn('ready_for_auction', ['1', '2'])
                ->where('bid_count', '>', '0')->update(['ready_for_auction'=>4]);

            $chosen_movies = array();
            $movies = $league->movies()->where('chosen', '0')->get();
            $available_movies = $movies->lists('id');
            $available_movie_count = count($available_movies);

            if ($rule->randomizer == 'Y') {
                //choose random movies
                //randomly choose the order of the first lot
                Log::info("Add Random Movies to league: ".$league->id." - ".$league->name);
                if ($available_movie_count > 0) {
                    for($movie_cnt = 0; $movie_cnt<$movie_no; $movie_cnt++) {

                        $random_pos = rand(0, ($available_movie_count - 1));
                        if(isset($available_movies[$random_pos])) {
                            $chosen_movies[] = $available_movies[$random_pos];

                            unset($available_movies[$random_pos]);
                            $available_movies = array_values($available_movies);
                            $available_movie_count--;
                        }
                    }
                } else
                    Log::info("Error with auction - no more movies to read in..");

            } else {
                Log::info("Add Movies to league: ".$league->id." - ".$league->name);
                //if not randomizer need to add find next group of films to add
                for($movie_cnt = 0; $movie_cnt<$movie_no; $movie_cnt++) {
                    $chosen_movies[] = $available_movies[$movie_cnt];
                }
            }

            //we have only added the ones that have been chosen so can quit easily
            foreach ($chosen_movies as $movie) {
                $this->addAuction($league, $movie, $rule);
            }

            //check that this next round is final round - if so - add any movies that missed out in previous rounds
            if ($league->current_round == $league->round_amount) {
                $auction_start_time = date("Y-m-d H:i:s", time());
                $auction_end_time = date("Y-m-d H:i:s", time() + ($rule->ind_film_countdown * 60));

                Auction::where('leagues_id', $league->id)->where('ready_for_auction', '3')
                    ->update(['ready_for_auction'=>'1', 'auction_start_time'=>$auction_start_time, 
                            'auction_end_time'=>$auction_end_time]);                
            }


            //update league movies to set to current round
            LeagueMovie::where('leagues_id', $league->id)->whereIn('movies_id', $chosen_movies)->where('chosen', '0')
                    ->update(['chosen'=>($league->current_round - 1)]);
            $league->save();
            
        }

    } //end loadNextMovies

    private function addAuction($league, $movie, $rule) {
        $auction = new Auction();
        $auction->leagues_id = $league->id;
        if(is_numeric($movie))
            $auction->movies_id = $movie;
        else
            $auction->movies_id = $movie->id;

        //$start_date = $league->auction_start_date;
        //based on the auction start date we need to work out the auction start time and end time
        $auction_start_time = date("Y-m-d H:i:s", time());
        $auction_end_time = date("Y-m-d H:i:s", time() + ($rule->ind_film_countdown * 60));
        $auction->auction_start_time = $auction_start_time;
        $auction->auction_end_time = $auction_end_time;
        //save us having to go back to the rules table for this
        if ($rule->auction_timeout != 0) {
            $auction->timeout = $rule->auction_timeout;
            $auction->timeout_date = date("Y-m-d H:i:s", strtotime('+'.intval($auction->timeout).' minutes', strtotime($auction->auction_end_time)));
        }

        $auction->ready_for_auction = 1;
        $auction->save();

        Log::info("Add Auction: ".(!is_numeric($movie)? $movie->name : $movie)." to ".$league->name." from ".$auction->auction_start_time." to ".$auction->auction_end_time);
        unset($auction);
    }

    /**
     * Auctions have started so look for all movies that have auction 
     * Set stage to 1 - as its open
     * Set first ten movies if necessary - 
     *
     * @param  int  $id
     * @return Response
     */
    public function executeAuctions() 
    {
        //only populate auctions when the time has passed
        $leaguesStarted = League::whereNotNull('auction_start_date')->
            where('auction_start_date', '<=', date("Y-m-d H:i"))
            ->where('auction_stage', 1)->where('enabled', '1')->get();

        foreach ($leaguesStarted as $league) {
            //set that the auction has started
            $league->auction_stage = 2;

            $rule = $league->rule;

            //clear the league balances in case this league has been re-run
            //LeagueUser::clearBalances($league->id);
            LeagueUser::where('league_id', $league->id)->update(['balance'=>100]);
            //clear out old auctions
            Auction::where('leagues_id', $league->id)->delete();

            Log::info("Adding Auctions for league ".$league->name);
            if (is_null($rule->auction_movie_release) || $rule->auction_movie_release == '') {
                //TODO: Put this into model / controller of auction

                //all movies to be enabled
                foreach ($league->movies as $movie) {
                    $this->addAuction($league, $movie, $rule);
                }

            } else {
                //we need to split the movies
                $movie_group = $rule->auction_movie_release;

                //work out the rounds necessary
                $movie_cnt = $league->movies->count();
                $league->round_amount = $movie_cnt / $movie_group;
                $league->current_round = 1;
                //TODO: this is a botch job as I have named the column wrongly - should be round_end_date
                //add round duration to the current time at the start
                //default to 1 in case this has been overlooked
                $round_duration = ($league->rule->round_duration != 0) ? $league->rule->round_duration : 1;
                $league->round_start_date = date("Y-m-d H:i:s", strtotime("+".$round_duration." hours"));

                if ($rule->randomizer == 'Y') {
                    //choose random movies
                    //randomly choose the order of the first lot
                    $chosen_movies = array();

                    $auctioned_movies = Auction::where('leagues_id', $league->id)->lists('id');
                    if (!is_null($auctioned_movies)) 
                        $movies = $league->movies()->whereNotIn('movies_id', $auctioned_movies)->get();
                    else
                        $movies = $league->movies;

                    $available_movies = $movies->lists('id');

                    $movie_add_count = 1;
                    $available_movie_count = count($available_movies);

                    for($movie_no = 0; $movie_no<$movie_group; $movie_no++) {

                        $random_pos = rand(0, ($available_movie_count - 1));
                        $chosen_movies[$movie_no] = $available_movies[$random_pos];
                        unset($available_movies[$random_pos]);
                        $available_movies = array_values($available_movies);
                        $available_movie_count--;

                    }

                    //update league movies to set to current round
                    LeagueMovie::where('leagues_id', $league->id)->whereIn('movies_id', $chosen_movies)
                            ->update(['chosen'=>$league->current_round]);

                    //we have only added the ones that have been chosen so can quit easily
                    foreach ($chosen_movies as $movie) {
                        $this->addAuction($league, $movie, $rule);
                    }


                    //update chosen movies so that we don't select them again
                    LeagueMovie::where('leagues_id', $league->id)->whereIn('movies_id', $chosen_movies)->where('chosen', '0')
                        ->update(['chosen'=>1]);

                } else {
                    //enable first movies
                    $league_movies_count = $league->movies->count();
                    $movie_add_count = 1;
                    if ($movie_group < $league_movies_count) {
                        foreach ($league->movies as $movie) {
                            $this->addAuction($league, $movie, $rule);
                            if (($movie_add_count++) == $movie_group)
                                break;
                        }

                    }
                }

            } // end auction movie release check

            $league->save();
            
            //now send email to players to tell them the auction is live
             //need to pass in the league details for the owner
            foreach ($league->players as $player) {
                $subject = 'League '.$league->name.' has started!';
                $data = ['playerName' => $player->fullName(),
                        'leagueName' => $league->name,
                        'leagueId' => $league->id,
                        'subject' => $subject];

                $playerEmail = $player->email;
                Mail::send('emails.auction_started', $data, function($message) use ($playerEmail, $subject)
                {
                    $message->from('leagues@thenextbigfilm.com', 'TheNextBigFilm Entertainment');
                    $message->subject($subject);
                    $message->to($playerEmail);
                });

            }            
        }

    } //execute auctions
}
