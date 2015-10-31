<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Log;
use DB;
use App\Models\User;
use App\Models\League;
use App\Models\Movie;
use App\Models\LeagueUser;
use App\Models\LeagueMovie;
use App\Models\Role;
use App\Models\RuleSet;
use App\Models\Auction;
use App\Models\LeagueRule;
use Session;
use Input;
use Redirect;
use App\Http\Requests\CreateLeagueRequest;
use App\Http\Requests\UpdateLeagueRequest;
use App\Http\Requests\AddPlayerToLeagueRequest;
use App\Http\Requests\AddMovieToLeagueRequest;
use Illuminate\Http\Request;
use Flash;
use Mail;

class LeaguesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        //$leagues = League::all();
        $leagues = League::orderBy('auction_stage', 'asc')->paginate(10);

        return View("leagues.all")
            ->with('leagues', $leagues)
            ->with('authUser', $authUser)
            ->with('page_name', 'leagues')
            ->with('instructions', 'All Leagues registered in the site.')
            ->with('title', 'Leagues');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $rulesets = RuleSet::lists('name', 'id');

        return View("leagues.add")
            ->with('authUser', $authUser)
            ->with('users', $this->get_players())
            ->with('page_name', 'league-add')
            ->with('sets', $rulesets)
            ->with('instructions', 'Add New League')
            ->with('title', 'Add League');
    }

    private function get_players() {
        $users = User::with(['role' => function($q){
            $q->where('name', 'Player');
        }])->lists('name', 'id');

        $role = Role::where('name', 'Player')->first();
        $user_ids = DB::table('role_user')->where('role_id', $role->id)->lists('user_id');

        return User::whereIn('id', $user_ids)->lists('name', 'id');
    }

    /**
     * Store a newly created league.
     *
     * @return Response
     */
    public function store(\App\Http\Requests\CreateLeagueRequest $request)
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');
        //
        $input = Input::all();
        $league = League::create( $input );

        if (!isset($input['rule_set'])) {
            //if no rule set is provided - just create a blank rule set
            $ruleset = RuleSet::first();
        } else {
            $ruleset = RuleSet::find($input['rule_set']);
        }

        //add rule set for future reference
        $league->rule_sets_id = $ruleset->id;
        $league->save();        

        //TODO: Move this to the league rule model?
        if (!empty($ruleset) && is_numeric($ruleset->id)) {
            //copy rule details into the rule for the league
            $leaguerule = new LeagueRule();
            $leaguerule->blind_bid = $ruleset->blind_bid;
            $leaguerule->min_players = $ruleset->min_players;
            $leaguerule->max_players = $ruleset->max_players;
            $leaguerule->min_movies = $ruleset->min_movies;
            $leaguerule->max_movies = $ruleset->max_movies;
            $leaguerule->auction_duration = $ruleset->auction_duration;
            $leaguerule->ind_film_countdown = $ruleset->ind_film_countdown;
            $leaguerule->joint_ownership = $ruleset->joint_ownership;
            $leaguerule->auction_timeout = $ruleset->auction_timeout;
            $leaguerule->min_bid = $ruleset->min_bid;
            $leaguerule->max_bid = $ruleset->max_bid;
            $leaguerule->randomizer = $ruleset->randomizer;
            $leaguerule->auction_movie_release = $ruleset->auction_movie_release;
            $leaguerule->start_time = $ruleset->start_time;
            $leaguerule->close_time = $ruleset->close_time;
            $leaguerule->league_type = $ruleset->league_type;
            $leaguerule->auto_select = $ruleset->auto_select;

            //add league id
            $leaguerule->leagues_id = $league->id;
            $leaguerule->save();
        }

        $direction = isset($input['source']) ? $input['source'] : "A";

        if ($direction == "A") {
            //user comes from admin - get league owner and add as a league player
            $leagueuser = LeagueUser::create( ['user_id'=>$league->users_id, 'league_id'=>$league->id] );

            Flash::message('League created.');
            return Redirect::route('leagues.index');
        } else {
            /* come by customer create league so go to select movies page */
            //user comes from admin - get league owner and add as a league player
            $leagueuser = LeagueUser::create( ['user_id'=>$authUser->id, 'league_id'=>$league->id] );

            return Redirect::route('choose-movies', [$league->id]);
        }
        
    }

    /**
     * Display the league details.
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

        $league = League::find($id);
        $title = "League ".$league->name." details";
        $players = $league->Players;

        return View("leagues.show")
            ->with('authUser', $authUser)
            ->with('league', $league)
            ->with('players', $players)
            ->with('object', $league)
            ->with('page_name', 'league-show')
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
        //
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $league = League::find($id);
        $title = "Edit League";
        $rulesets = RuleSet::lists('name', 'id');

        return View("leagues.edit")
            ->with('authUser', $authUser)
            ->with('users', $this->get_players())
            ->with('league', $league)
            ->with('sets', $rulesets)
            ->with('object', $league)
            ->with('page_name', 'league-edit')
            ->with('title', $title);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateLeagueRequest $request)
    {
        //get movie
        $league = League::find($id);
        $input = $request->all();

        $league->name = $input['name'];
        $league->users_id = $input['users_id'];
        
        if($input['auction_start_date'] != '')
            $league->auction_start_date = $input['auction_start_date'];
        if($input['auction_close_date'] != '')
            $league->auction_close_date = $input['auction_close_date'];
        if($input['auction_stage'] != '')
            $league->auction_stage = $input['auction_stage'];

        //add rule set for future reference
        if ($input['rule_set'] != '')
            $league->rule_sets_id = $input['rule_set'];
        $league->save();

        if (isset($input['rule_set']) && is_null($league->rule)) {
            //just find out there isn't already a rule defined for this league
            $rules = $league->rule;
            //only look for a rule set if there isn't already rules in place
            if (is_null($rules)) {
                $ruleset = RuleSet::find($input['rule_set']);    
            }
        }

        if (isset($ruleset) && is_numeric($ruleset->id)) {
            //copy rule details into the rule for the league
            $leaguerule = new LeagueRule();
            $leaguerule->blind_bid = $ruleset->blind_bid;
            $leaguerule->min_players = $ruleset->min_players;
            $leaguerule->max_players = $ruleset->max_players;
            $leaguerule->min_movies = $ruleset->min_movies;
            $leaguerule->max_movies = $ruleset->max_movies;
            $leaguerule->auction_duration = $ruleset->auction_duration;
            $leaguerule->ind_film_countdown = $ruleset->ind_film_countdown;
            $leaguerule->joint_ownership = $ruleset->joint_ownership;
            $leaguerule->auction_timeout = $ruleset->auction_timeout;
            $leaguerule->min_bid = $ruleset->min_bid;
            $leaguerule->max_bid = $ruleset->max_bid;
            $leaguerule->randomizer = $ruleset->randomizer;
            $leaguerule->auction_movie_release = $ruleset->auction_movie_release;
            $leaguerule->start_time = $ruleset->start_time;
            $leaguerule->close_time = $ruleset->close_time;
            $leaguerule->league_type = $ruleset->league_type;
            $leaguerule->auto_select = $ruleset->auto_select;

            //add league id
            $leaguerule->leagues_id = $league->id;
            $leaguerule->save();
        }
        Flash::message('League has been updated');
        return Redirect::route('leagues.index');
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
     * Disable the league
     *
     * @param  int  $id
     * @return Response
     */
    public function disable($id)
    {
        //
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $league = League::find($id);
            $message = "";
            if (!empty($league)) {
                $message = "League " .$league->name. " has been disabled.";
                Flash::message($message);
                $league->enabled = false;
                $league->save();
            }
            return Redirect::route('leagues.index');
        }
        Flash::message('You don\'t have the permissions to complete this task.');
        return Redirect::route('leagues.index');
    }

    /**
     * Enable the user
     *
     * @param  int  $id
     * @return Response
     */
    public function enable($id)
    {
        //
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $league = League::find($id);
            $message = "";
            if (!empty($league)) {
                $message = "League " .$league->name. " has been enabled.";
                Flash::message($message);
                $league->enabled = true;
                $league->save();
            }
            return Redirect::route('leagues.index');
        }
        Flash::message('You don\'t have the permissions to complete this task.');
        return Redirect::route('leagues.index');
    }
    /**
     * Add player to league
     *
     * @param  int  $id
     * @return Response
     */
    public function addPlayer($id) {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $league = League::find($id);
        $title = "Add League to ".$league->name." movie";
        $players = $this->get_players();

        return View("leagues.player")
            ->with('authUser', $authUser)
            ->with('league', $league)
            ->with('object', $league)
            ->with('players', $players)
            ->with('page_name', 'league-player')
            ->with('title', $title);
    }

    /**
     * Save player to league table
     *
     * @param  int  $id
     * @return Response
     */
    public function postPlayer($id, AddPlayerToLeagueRequest $request) {
        $input = Input::all();

        //test that player hasn't already been added
        $leagueUsers = LeagueUser::where('league_id', $input['league_id'])->lists('user_id');

        if (!in_array($input['user_id'], $leagueUsers)) {
            $leagueuser = LeagueUser::create( $input );
    
            //add 100 dollars to the account
            $leagueuser->balance = 100;
            $leagueuser->save();
            Flash::message('Player added.');
        } else {
            Flash::message('Player already exists in this league.');
        }

        return Redirect::route('leagues.show', array($id));
    }

    /**
     * Join  player to league - this will depend on rules eventally
     *
     * @param  int  $id
     * @return Response
     */
    public function join($id) {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $league = League::find($id);

        //join league
        $success = false;
        if (is_numeric($league->id)) {
            $leagueUser = new LeagueUser;
            $leagueUser->league_id = $league->id;
            $leagueUser->user_id = $authUser->id;
            $leagueUser->save();

            $success = is_numeric($leagueUser->id);
        }

        return View("join")
            ->with('authUser', $authUser)
            ->with('join_success', $success)
            ->with('league', $league);
    }

    public function addMovie($id) {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $league = League::find($id);
        $title = "Add Movie to ".$league->name." movie";

        //need to restrict to movies not already added to league
        $linkedMovies = LeagueMovie::where('leagues_id', $id)->lists('movies_id');
        $movies = Movie::whereNotIn('id', $linkedMovies)->where('enabled', 1)->orderBy('name', 'asc')->lists('name', 'id');

        return View("leagues.movie")
            ->with('authUser', $authUser)
            ->with('league', $league)
            ->with('object', $league)
            ->with('movies', $movies)
            ->with('page_name', 'league-movie')
            ->with('title', $title);
    }

    public function postMovie($id, AddMovieToLeagueRequest $request) {
        $input = Input::all();
        $leaguemovie = LeagueMovie::create( $input );

        Flash::message('Movie added to league.');
        return Redirect::route('leagues.show', array($id));
    }

    /**
     * add selection of movies to players league
     *
     * @param  int  $id
     * @return Response
     */
    public function postMultipleMovies() {
        $input = Input::all();

        if (!empty($input['movies_id'])) {

            $leagues_id = $input['leagues_id'];
            //add movies for this league
            foreach ($input['movies_id'] as $movie_id) {
                $leaguemovie = new LeagueMovie();

                $leaguemovie->leagues_id = $leagues_id;
                $leaguemovie->movies_id = $movie_id;
                $leaguemovie->save();

            }
            return Redirect::route('select-participants', array($leagues_id));
        }
        //issue here - put warning message?
        return Redirect::route('dashboard');
    }


    /**
     * Reove movie from league
     *
     * @param  int  $id
     * @return Response
     */
    public function removeMovie($id)
    {
        //
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $lm = LeagueMovie::find($id);
            if (!empty($lm)) {
                $movie = Movie::find($lm->movies_id);
                $league = League::find($lm->leagues_id);
                $message = "Movie ".$movie->name." has been removed from ".$league->name;
                Flash::message($message);

                //check this is correct
                $lm->delete();
            }
            return Redirect::route('leagues.show', $league->id);
        } else
            Flash::message("You don\'t have the permissions to complete this task.");

                return Redirect::route('leagues.index');
    }

    /**
     * Select Known players to join league
     * TODO: Would be better obviously if the player is invited and it appears in a messages section somewhere
     *
     * @return Response
     */
    public function postSelectParticipants()
    {
        $authUser = Auth::user();

        $input = Input::all();

        if (isset($input['leagues_id']) && isset($input['users_id']) && !empty($input['users_id'])) {
            //we have league id so we can continue
            $league_id = $input['leagues_id'];
            foreach ($input['users_id'] as $user_id) {
                $lu = new LeagueUser();
                $lu->league_id = $league_id;
                $lu->user_id = $user_id;
                $lu->save();
                unset($lu);//clear out to start afresh
            }
            return Redirect::route('select-participants', [$league_id])->with('message', 'Players have been invited to the league');
        }
        return Redirect::route('dashboard');
    }

    /**
     * Invite non-player to join league
     *
     * @param  int  $id
     * @return Response
     */
    public function postInvitePlayer() 
    {
        $authUser = Auth::user();

        $input = Input::all();
        $league = League::find($input['leagues_id']);

        /* Take details and send it as an email invite */
        $nonplayerName = $input['name'];
        $nonplayerEmail = $input['email_address'];

        $data = ['inviteName' => $nonplayerName,
                'inviteEmail' => $nonplayerEmail,
                'user' => $authUser];

        //TODO: need to check if invited player is currently a player of the site who is not part of the group of friends the user currently has.
        //send invite email to new player
        Mail::send('emails.invite', $data, function($message) use ($nonplayerEmail)
        {
            $message->from('invite@digfilm.com', 'DigFilm Entertainment');
            $message->to($nonplayerEmail);
        });

        $success_message = $nonplayerName." has been invited to your league!";
        /* route back to the invite page */
        return Redirect::route('select-participants', [$league->id])->with('message', $success_message);
    }

    /**
     * Invite non-player to join league
     *
     * @param  int  $id
     * @return Response
     */
    public function getLeague($id) 
    {
        $authUser = Auth::user();
        $league = League::find($id);

        $movies = $league->movies;
        $rule = $league->rule;

        return view('leagues.manage')
            ->with('league', $league)
            ->with('authUser', $authUser);  
    }

    /**
     * Adjust the rules for the league
     *
     * @param  int  $id
     * @return Response
     */
    public function getRules($id) 
    {
        $authUser = Auth::user();
        $league = League::find($id);

        return view('leagues.rules')
            ->with('league', $league)
            ->with('object', $league)
            ->with('page_name', 'league-rule')
            ->with('title', 'Edit League Rules')
            ->with('authUser', $authUser);  
    }

    /**
     * Save changes to the rules
     *
     * @param  int  $id
     * @return Response
     */
    public function postRules($id) 
    {
        $authUser = Auth::user();
        $leaguerule = LeagueRule::find($id);

        $input = Input::all();

        $leaguerule->min_players = $input['min_players'];
        $leaguerule->max_players = $input['max_players'];
        $leaguerule->min_movies = $input['min_movies'];
        $leaguerule->max_movies = $input['max_movies'];
        $leaguerule->auction_duration = $input['auction_duration'];
        $leaguerule->ind_film_countdown = $input['ind_film_countdown'];
        $leaguerule->joint_ownership = $input['joint_ownership'];
        $leaguerule->min_bid = $input['min_bid'];
        $leaguerule->max_bid = $input['max_bid'];
        $leaguerule->randomizer = $input['randomizer'];
        $leaguerule->auction_movie_release = $input['auction_movie_release'];
        $leaguerule->start_time = $input['start_time'];
        $leaguerule->close_time = $input['close_time'];
        $leaguerule->league_type = $input['league_type'];
        $leaguerule->auto_select = $input['auto_select'];
        $leaguerule->save();
        
        Flash::message('League rules have been updated.');
        return Redirect::route('league-rules', [$leaguerule->leagues_id]);
    }

    /**
     * Loop through all leagues that aren't running and setup ready to run
     *
     * @param  int  $id
     * @return Response
     */
    public function startAuctions() 
    {
        //TODO: Move to  command
        $leaguesToReview = League::whereNull('auction_start_date')->where('enabled', '1')->get();

        //need to make sure each league has rules!
        foreach ($leaguesToReview as $league) {
            
            if (!is_null($league->rule)) {
                //ok we have rules find out the number of players
                $player_count = $league->players->count();
                $rules = $league->rule;
                
                if ($player_count >= $rules->min_players && $player_count <= $rules->max_players) {
                    Log::info("League ".$league->name." has the players - ". $player_count);
                    $start_time = $rules->start_time;
                    $time_to_start = time() + (60 * 60 * 4); //60 secs * 60 mins * 4 = 4hours
                    Log::info("Time dif: $time_to_start - ".strtotime($start_time));
                    if ($time_to_start > strtotime($start_time)) {
                        //the new date is no good so set the time for the next day
                        $league->auction_start_date = date("Y-m-d G:i:s", strtotime('+1 day', strtotime((date("Y-m-d")." ".$start_time))));
                    } else {
                        $auction_start_date = date("Y-m-d G:i:s", strtotime($start_time));
                        // ok we are fine to go ahead with this date today - so lets set the time to it
                        $league->auction_start_date = $auction_start_date;
                    }

                    //need to create close date for auction
                    $close_date = $league->auction_start_date;
                    $auction_duration = $rules->auction_duration;
                    $league->auction_close_date = date("Y-m-d G:i:s", strtotime('+'.$auction_duration.' hours', strtotime($close_date)));

                    $league->auction_stage = 0;
                    $league->save();
                } else {
                    //TODO: Send out reminder to league players to find more players to get involved
                    Log::info('League '.$league->id.' - '.$league->name.' needs more players.');
                }
            }
        }

    }

    /**
     * Loop through all leagues that aren't running and have auction date set
     * to determine whether to send out updates to say auctions about to start
     *
     * @param  int  $id
     * @return Response
     */
    public function preparePlayersForAuctions() 
    {
        $leaguesToNotify = League::whereNotNull('auction_start_date')
            ->where('auction_start_date', '>', date("Y-m-d H:i:s"))
            ->where('enabled', '1')->where('auction_stage', '0')->get();

        //need to make sure each league has rules!
        foreach ($leaguesToNotify as $league) {
            $rules = $league->rule;

            //if league auction is 12 hours away send reminder
            Log::info("Name: ".$league->name." Auto: ".$rules->auto_select);
            //if league auction is 6 hours away send reminder and populate the movies if required
            if ($rules->auto_select == 'Y') {
                //need to find the required number of movies
                //get the minimum for now
                $min_movies = $rules->min_movies;
                //TODO: WIll need to add time on to this date to give leeway
                $earliest_release_date = $league->auction_close_date;

                //randomly populate movies
                $available_movies = Movie::where('release_at', '>', $earliest_release_date)->lists('id');
                $available_movie_count = count($available_movies);
                
                Log::info("Movie Check - Available: ".count($available_movies)." Min Required: ".$min_movies);
                //need to make sure we have enough movies
                if (count($available_movies) > $min_movies) {
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
                        $league_movie->leagues_id = $league->id;
                        $league_movie->movies_id = $movie_id;
                        //var_dump($league_movie);
                        $league_movie->save();

                        Log::info("Movie - ".$movie_id." added to ".$league->name);

                        unset($league_movie);
                    }

                    //only set this if there are movies added to the league
                    if (count($chosen_movies) > 0)
                        $league->auction_stage = 1;
                } else {
                    Log::info("There aren't enough movies for this league: ".$league->id." - ".$league->name);
                }

                //movies have been populated - set the auction stage to 1
                $league->save();
                
            } elseif ($rules->auto_select != 'Y') {
                //TODO: this needs an email to be sent to the league owner if the movies are empty
                if ($league->movies->count() == 0) {
                    //SEND EMAIL 
                }

            }

            //if league auction is 10 minutes away send final reminder

            //TODO: perhaps ther should be options in the profile to restrict this?
        }
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

                    //echo "Total Allowed Movie Number:$movie_group<br/>";
                    for($movie_no = 0; $movie_no<$movie_group; $movie_no++) {

                        $random_pos = rand(0, ($available_movie_count - 1));
                        $chosen_movies[$movie_no] = $available_movies[$random_pos];
                        unset($available_movies[$random_pos]);
                        $available_movies = array_values($available_movies);
                        $available_movie_count--;

                    }

                    //we have only added the ones that have been chosen so can quit easily
                    foreach ($chosen_movies as $movie) {
                        $this->addAuction($league, $movie, $rule);
                    }
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
        $leaguesStarted = League::where('auction_stage', 2)->where('enabled', '1')->get();

        foreach ($leaguesStarted as $league) {
            //set that the auction has started
            //$league->auction_stage = 2;

            $rule = $league->rule;

            if (!(is_null($rule->auction_movie_release) && $rule->auction_movie_release != '')) {
                //we need to split the movies
                $movie_no = $rule->auction_movie_release;

                //get list of movies currently chosen
                //$auction_movies = Auction::where('leagues_id', $league->id)->where('auction_end_time', '>', time())->get();
                $auction_movies_count = $league->auctions()->where('ready_for_auction', 1)->count();
                if ($auction_movies_count > 0) {
                    //do nowt - carry on
                    Log::info('League '.$league->id.' - '.$league->name.' has auctions '.$auction_movies_count.' live.');
                } else {
                    //ok the end time has come - do we need to add more movies?
                    $auctioned_movies_count = $league->auctions()->count();
                    $league_movies_count = $league->movies->count();

                    //DB::connection()->enableQueryLog();
                    Log::info('League '.$league->id.' - '.$league->name.' has auctions '.$auctioned_movies_count.' and has '.$league_movies_count.' chosen movies.');
                    if ($auctioned_movies_count < $league_movies_count) {
                        
                        //brilliant - lets add some more movies
                        $chosen_movies = array();

                        $auctioned_movies = Auction::where('leagues_id', $league->id)->lists('movies_id');    
                        if (!empty($auctioned_movies))
                            $movies = $league->movies()->whereNotIn('movies_id', $auctioned_movies)->get();
                        else
                            $movies = $league->movies;

                        $available_movies = $movies->lists('id');
                        $available_movie_count = count($available_movies);

                        if ($rule->randomizer == 'Y') {
                            //choose random movies
                            //randomly choose the order of the first lot
                            //$movie_add_count = 1;
                            Log::info("Add Random Movies to league: ".$league->id." - ".$league->name);
                            for($movie_cnt = 0; $movie_cnt<$movie_no; $movie_cnt++) {

                                $random_pos = rand(0, ($available_movie_count - 1));
                                $chosen_movies[$movie_cnt] = $available_movies[$random_pos];

                                unset($available_movies[$random_pos]);
                                $available_movies = array_values($available_movies);
                                $available_movie_count--;
                            }

                        } else {
                            Log::info("Add Movies to league: ".$league->id." - ".$league->name);
                            //if not randomizer need to add find next group of films to add
                            for($movie_cnt = 0; $movie_cnt<$movie_no; $movie_cnt++) {
                                $chosen_movies[$movie_cnt] = $available_movies[$movie_cnt];
                            }
                            /*$movie_add_count = 1;
                            if ($movie_no < $available_movie_count) {
                                foreach ($league->movies as $movie) {
                                    $this->addAuction($league, $movie, $rule);

                                    if (($movie_add_count++) == $movie_no)
                                        break;
                                }

                            }*/
                        }

                        //we have only added the ones that have been chosen so can quit easily
                        foreach ($chosen_movies as $movie) {
                            $this->addAuction($league, $movie, $rule);
                        }

                    }
                }

            } // end auction movie release check

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


}
