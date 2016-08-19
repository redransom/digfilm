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
use App\Models\LeagueInvite;
use App\Models\LeagueRoster;
use App\Models\LeagueMessage;
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
     * Status now allows Enabled/Disabled leagues view
     *
     * @return Response
     */
    public function index($status = 100, $col = 'name', $order = 'asc')
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $paginate = true;

        if (is_numeric($status)) {
            if ($status == 100)
                $leagues = League::orderBy('auction_stage', 'asc')->where('enabled', '1')->orderBy('created_at', $order)->paginate(10);
            else {
                if($status == 0)
                    $leagues = League::whereNull('auction_stage')->where('enabled', '1')->orderBy('created_at', $order)->get();
                elseif ($status < 6)
                    $leagues = League::where('auction_stage', ($status - 1))->where('enabled', '1')->orderBy('created_at', $order)->orderBy('created_at', 'desc')->get();
                else
                    $leagues = League::where('auction_stage', ($status - 1))->orderBy('created_at', $order)->orderBy('created_at', 'desc')->get();

                $paginate = false;
            }
        } else {
            if ($status == 'enabled')
                $leagues = League::orderBy('auction_stage', 'asc')->where('enabled', '1')->orderBy('created_at', $order)->paginate(10);
            else
                $leagues = League::orderBy('auction_stage', 'asc')->where('enabled', '0')->orderBy('created_at', $order)->paginate(10);
        }


        return View("leagues.all")
            ->with('leagues', $leagues)
            ->with('authUser', $authUser)
            /*->with('use_graph', true)*/
            ->with('order', $order)
            ->with('col', $col)
            ->with('status', $status)
            ->with('page_name', 'leagues')
            ->with('paginate', $paginate)
            ->with('instructions', 'All Leagues registered in the site.')
            ->with('title', 'Leagues');
    }

    /**
     * Show the form for creating a new league
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

    /**
     * get players to use in drop down
     *
     * @return Response
     */
    private function get_players($league_id = 0) {
        $role = Role::where('name', 'Player')->first();
        $user_ids = DB::table('role_user')->where('role_id', $role->id)->lists('user_id');

        // if league id is provided we need to restrict to those not selected so far
        if ($league_id != 0) {
            $league = League::find($league_id);
            $league_users = $league->players()->lists('user_id');
            
            return User::whereIn('id', $user_ids)->whereNotIn('id', $league_users)->where('enabled', '1')->orderBy('name', 'asc')->lists('name', 'id');
        } else {
            return User::whereIn('id', $user_ids)->where('enabled', '1')->orderBy('name', 'asc')->lists('name', 'id');
        }        
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


        if (!isset($input['rule_sets_id'])) {
            //if no rule set is provided - just create a blank rule set
            $ruleset = RuleSet::first();
        } else {
            $ruleset = RuleSet::find($input['rule_sets_id']);
        }

        //add meta data
        $league->meta_keywords = strtolower($league->name).' rules '.strtolower($ruleset->name);
        if ($league->description != "")
            $league->meta_description = strtolower($league->description);
        else {
            $league->description = "You Be The Judge";
            $league->meta_description = "you be the judge";
        }

        //add rule set for future reference
        $league->rule_sets_id = $ruleset->id;

        //TODO: Move this to the league rule model?
        if (!empty($ruleset) && is_numeric($ruleset->id)) {
            //copy rule details into the rule for the league
            $leaguerule = new LeagueRule();
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

            if(isset($input['auto_select']))
                $leaguerule->auto_select = $input['auto_select'];
            else
                $leaguerule->auto_select = $ruleset->auto_select;

            $leaguerule->blind_bid = $ruleset->blind_bid;
            $leaguerule->auction_timeout = $ruleset->auction_timeout;
            $leaguerule->round_duration = $ruleset->round_duration;
            $leaguerule->min_increment = $ruleset->min_increment;
            $leaguerule->max_increment = $ruleset->max_increment;
            $leaguerule->movie_takings_duration = $ruleset->movie_takings_duration;

            //add league id
            $leaguerule->leagues_id = $league->id;
            $leaguerule->save();
        }

        if (!isset($input['auction_close_date']) || $input['auction_close_date'] == '') {
            $close_date = $league->auction_start_date;
            $auction_duration = $leaguerule->auction_duration;
            $league->auction_close_date = date("Y-m-d G:i:s", strtotime('+'.$auction_duration.' hours', strtotime($close_date)));
        }

        $file_name = $request->file('file_name');
        if (!empty($file_name)) {
            $imageName = $league->id.str_replace(' ', '_', strtolower($input['name'])) . '.' . $request->file('file_name')->getClientOriginalExtension();
            $request->file('file_name')->move(base_path() . '/public/images/leagues/', $imageName);

            $league->file_name = "/images/leagues/".$imageName;
        } else
            $league->file_name = null;

        $league->save(); 

        $direction = isset($input['source']) ? $input['source'] : "A";

        if ($direction == "A") {
            //user comes from admin - get league owner and add as a league player
            /*if ($league->type != 'U')
                $leagueuser = LeagueUser::create( ['user_id'=>$league->users_id, 'league_id'=>$league->id, 'balance'=>100] );*/

            Flash::message('League created.');
            return redirect()->route('league', [$league->id]);
        } else {
            /* come by customer create league so go to select movies page */
            /*if ($league->type != 'U')
                $leagueuser = LeagueUser::create( ['user_id'=>$authUser->id, 'league_id'=>$league->id, 'balance'=>100] );*/

            //need to make sure the league is private for players (invite only)
            $league->type = 'R';
            $league->save();

            $rules = LeagueRule::where('leagues_id', $league->id)->first();

            if (isset($leaguerule)) {
                //check if the auto complete is chosen go to the choose participants
                if ($leaguerule->auto_select == 'Y')
                    return Redirect::route('config-rules', [$league->id]);
            }
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
            ->with('page_name', 'league-details')
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
        $league->description = $input['description'];
        $league->users_id = $input['users_id'];
        $league->type = $input['type'];
        
        if($input['auction_start_date'] != '')
            $league->auction_start_date = $input['auction_start_date'];
        if($input['auction_close_date'] != '')
            $league->auction_close_date = $input['auction_close_date'];
        if($input['auction_stage'] != '')
            $league->auction_stage = $input['auction_stage'];

        //add rule set for future reference
        if ($input['rule_sets_id'] != '')
            $league->rule_sets_id = $input['rule_sets_id'];

        if ($input['auction_stage'] == '-1')
            $league->auction_stage = null;

        $file_name = $request->file('file_name');
        if (!empty($file_name)) {
            $imageName = str_random(10).str_replace(' ', '_', strtolower($input['name'])) . '.' . $request->file('file_name')->getClientOriginalExtension();
            $request->file('file_name')->move(base_path() . '/public/images/leagues/', $imageName);

            $league->file_name = "/images/leagues/".$imageName;
        }

        //var_dump($league);
        $league->save();

        //check the rule set has been provided
        if (isset($input['rule_sets_id'])) {
            $ruleset = RuleSet::find($input['rule_sets_id']);
        } 

        if (isset($ruleset) && is_numeric($ruleset->id)) {
            //copy rule details into the rule for the league
            //allow current rule set to be replaced if required
            if (!is_null($league->rule)) {
                $leaguerule = $league->rule;
            } else {
                $leaguerule = new LeagueRule();
                //add league id
                $leaguerule->leagues_id = $league->id;
            }
    
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
            $leaguerule->auto_select = $ruleset->auto_select;
            $leaguerule->blind_bid = $ruleset->blind_bid;
            $leaguerule->auction_timeout = $ruleset->auction_timeout;
            $leaguerule->round_duration = $ruleset->round_duration;
            $leaguerule->min_increment = $ruleset->min_increment;
            $leaguerule->max_increment = $ruleset->max_increment;
            $leaguerule->movie_takings_duration = $ruleset->movie_takings_duration;
            $leaguerule->save();
        }

        Flash::message('League has been updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $authUser = Auth::user();
        if (!isset($authUser) || !$authUser->hasRole("Admin"))
            return redirect('/auth/login');

        //not sure if this is a function...
        if (League::exists($id)) {
            $league = League::find($id);
            Flash::message('League '.$league->name.' has been removed from the system.');
            $league->delete();
            
            //return Redirect::route('leagues.index');
        } else 
            Flash::message('You don\'t have the permissions to complete this task.');

        return redirect()->back();
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
            //return Redirect::route('leagues.index');
        } else 
            Flash::message('You don\'t have the permissions to complete this task.');

        return redirect()->back();
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
            //return Redirect::route('leagues.index');
        } else 
            Flash::message('You don\'t have the permissions to complete this task.');

        return redirect()->back();
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
        $players = $this->get_players($id);

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

        return redirect()->route('league', [$id]);
    }

    /**
     * Update player rules when the league hasn't started
     *
     * @param  int  $id
     * @return Response
     */
    public function postPlayerRules($id) {
        $input = Input::all();
        $location = isset($input['location']) ? $input['location'] : "N";

        //update min players/movies and start date
        $league = League::find($id);
        if(is_numeric($league->id)) {
            $rule = $league->rule;

            $movies_cnt = $league->movies->count();
            $players_cnt = $league->players->count();

            //now we can update the rules
            $rule->min_movies = $input['min_movies'];
            if ($movies_cnt < $input['max_movies'])
                $rule->max_movies = $input['max_movies'];

            $rule->min_players = $input['min_players'];
            if ($players_cnt < $input['max_players'])
                $rule->max_players = $input['max_players'];

            $rule->save();

            if(isset($input['auction_start_date']) && $input['auction_start_date'] != '') 
                $league->auction_start_date = $input['auction_start_date'];
            $league->save();

            if ($location != 'R')
                Flash::success('League rules have been updated.');
        }

        //if we have come from the create league process go on to the add participants 
        if ($location == 'R')
            return Redirect::route('select-participants', [$league->id]);

        return redirect()->back();
    }

    /**
     * Join  player to league - this will depend on rules eventally
     *
     * @param  int  $id
     * @return Response
     */
    public function join($id, $route=0) {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $league = League::find($id);

        //join league
        if (is_numeric($league->id)) {
            //need to check this user isn't already in this league
            $inLeague = LeagueUser::where('user_id', $authUser->id)->where('league_id', $league->id)->first();
            if (is_null($inLeague)) {
                //should move this process to the Model? 
                $leagueUser = new LeagueUser;
                $leagueUser->league_id = $league->id;
                $leagueUser->user_id = $authUser->id;
                $leagueUser->balance = 100;
                $leagueUser->save();

                $this->sendWelcomeEmail($authUser->id, $league);

                Flash::success('You have successfully managed to join the '.$league->name.' league!');
            }
        } else
            Flash::warning('You have not been able to join the '.$league->name.' league!');

        if ($route == 0)
            return redirect()->back();
        else 
            return redirect()->route('dashboard');
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
        return redirect()->route('leagues', [$id]);
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
     * Remove movie from league
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
        } else
            Flash::message("You don\'t have the permissions to complete this task.");

        return redirect()->back();
    }

    /**
     * Remove player from league
     *
     * @param  int  $id
     * @return Response
     */
    public function removePlayer($id)
    {
        //
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $lu = LeagueUser::find($id);
            if (!empty($lu)) {
                $user = User::find($lu->user_id);
                $league = League::find($lu->league_id);
                $message = "User ".$user->name." has been removed from ".$league->name;
                Flash::message($message);

                $lu->delete();
            }
        } else
            Flash::message("You don\'t have the permissions to complete this task.");

        return redirect()->back();
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
            $league = League::find($league_id);

            //work out allowed number of players
            $allowed_player_number = $league->rule->max_players - $league->players->count();
            Log::info('Adding players to league '.$league->id.' allowed number is: '.$allowed_player_number);
            $selected_cnt = 1;
            foreach ($input['users_id'] as $user_id) {
                /*$lu = new LeagueUser();
                $lu->league_id = $league_id;
                $lu->user_id = $user_id;
                $lu->balance = 100; //TODO: Put this in the league rules
                $lu->save();
                unset($lu);*///clear out to start afresh

                //do invite as well
                $invite = new LeagueInvite();
                $invite->leagues_id = $league_id;
                $invite->users_id = $user_id;
                $invite->save();
                
                $this->sendInvite($league_id, $invite->id);
                unset($invite);

                //we can only select a pre-determind amount of players currently
                $selected_cnt++;

                if($selected_cnt > $allowed_player_number)
                    break;
            }
            Flash::success('Players have been added to the league');
            return Redirect::route('league-made', [$league_id]);
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
        $invite_message = "";

        if (!is_null($authUser->forenames)) {
            $ownerName = $authUser->forenames. "(".$authUser->name.")";
        } else
            $ownerName = $authUser->name;

        /* Take details and send it as an email invite */
        for($name_count=0; $name_count<count($input['name']); $name_count++) {

            $nonplayerName = isset($input['name'][$name_count]) ? $input['name'][$name_count] : "";
            $nonplayerEmail = isset($input['email_address'][$name_count]) ? $input['email_address'][$name_count] : "";
            $currentUser = User::where('email', $nonplayerEmail)->first();

            if ($nonplayerEmail != "") {

                //do this check to make sure you can't invite yourself as you are already added as the owner
//                if ((!is_null($authUser) && $currentUser->id != $authUser->id) || is_null($authUser)) {
                if (is_null($currentUser) || 
                        is_null($authUser) || 
                        (!is_null($authUser) && !is_null($currentUser) && $currentUser->id != $authUser->id)) {
                    //do invite as well
                    $invite = new LeagueInvite();
                    $invite->leagues_id = $league->id;

                    if (!isset($currentUser->id)) {
                        $invite->name = $nonplayerName;
                        $invite->email = $nonplayerEmail;

                        $invite_message .= "New Player (".$invite->name.") has been invited to join the site.<br/>";

                    } else {
                        $invite->users_id = $currentUser->id;

                        $invite_message .= "Current Player (".$currentUser->fullName().") has been invited to join the league.<br/>";
                    }

                    $invite->save();
                    $invite_id = $invite->id;
                    unset($invite);

                    $this->sendInvite($league->id, $invite_id);
                }

            }

        }

        Flash::success('Players have been invited to the league:<br/>'.$invite_message);
        return Redirect::route('league-made', [$league->id]);
    }

    private function sendInvite($league_id, $invite_id = 0) {
        $authUser = Auth::user();

        //get invite details
        $invite = LeagueInvite::find($invite_id);
        $league = $invite->league;

        if (!is_null($invite->users_id)) {
            $user = User::find($invite->users_id);
            $playerName = $user->fullName();
            $playerEmail = $user->email;
        } else {
            $playerName = $invite->name;
            $playerEmail = $invite->email;
        }

        $subject = "You've been invited to join the ".$league->name." league!";
        $data = ['inviteName' => $playerName,
                'inviteEmail' => $playerEmail,
                'user' => $authUser,
                'ownerName' =>$league->owner->fullName(),
                'league'=>$league,
                'subject'=>$subject,
                'invite_id'=>$invite_id];

        Log::info('Send invite to '.$playerName.' for '.$league->name.' league');

        //send invite email to new player
        try
        {
            Mail::send('emails.invite', $data, function($message) use ($playerEmail, $subject) {
                $message->from('invite@thenextbigfilm.com', 'TheNextBigFilm Entertainment');
                $message->subject($subject);
                $message->to($playerEmail);
            });
        }
        catch (\Exception $e)
        {
            dd($e->getMessage());
        }
    }

    /**
     * Player has accepted invitation
     * Update LeagueInvite with success
     * Take the player to the registration page
     * On registration check that the player has accepted an invitation and add them to the league if they have.
     *
     * @param  int  $id
     * @return Response
     */
    public function acceptInvite($inviteId) 
    {
         if( ! $inviteId) {
            throw new InvalidInviteCodeException;
        }

        $invite = LeagueInvite::find($inviteId);
        $league = League::find($invite->leagues_id);

        //update invite to say it's been accepted
        $invite->status = 'A';
        $invite->save();

        $authUser = Auth::user();
        //if this is the case we need to let them know its too late
        if(is_null($league->auction_stage) || $league->auction_stage < 1) {
            if (!is_null($invite->users_id)) {
                //this is already a player - add them to the league and direct them to it

                Flash::success('Thank you for accepting '.$league->owner->name.' invitation to join the '.$league->name.' league.');

                //just make sure the player isn't already a player in the league
                $player = LeagueUser::where('league_id', $league->id)->where('user_id', $invite->users_id)->first();
                if (is_null($player)) {
                    $lu = new LeagueUser();
                    $lu->league_id = $league->id;
                    $lu->user_id = $invite->users_id;
                    $lu->balance = 100;
                    $lu->save();
                }

                //we send an email out
                $this->sendWelcomeEmail($invite->users_id, $league);

                if(!is_null($authUser))
                    return Redirect::route('dashboard');
                else
                    return Redirect::route('login');
            } else {
                //a new player - redirect to the registration page
                Flash::success('Thank you for accepting '.$league->owner->name.' invitation to join the '.$league->name.' league. You will now need to register to take part in the league.');
                return Redirect::route('register');
            }
        } else {
            Flash::success('We are sorry but the league '.$league->name.' has already started.');
            if (!is_null($invite->users_id) && !is_null($authUser))
                return Redirect::route('dashboard');
            return Redirect::route('home');
        }
    }

    private function sendWelcomeEmail($user_id, &$league) {
        $user = User::find($user_id);
        $subject = 'Welcome to the '.$league->name.' league!';
        $data = ['playerName' => $user->fullName(), 
                'leagueName' => $league->name,
                'subject' => $subject];

        if (!is_null($league->movies) && $league->movies->count() > 0)
            $data['leagueMovies'] = $league->movies()->orderBy('name', 'ASC')->get();
        
        $playerEmail = $user->email;
        Mail::send('emails.league_welcome', $data, function($message) use ($playerEmail, $subject)
        {
            $message->from('leagues@thenextbigfilm.com', 'TheNextBigFilm Entertainment');
            $message->to($playerEmail);
            $message->subject($subject);
        });    
    }

    /**
     * Player has declined invitation
     * Update the player invite to decline
     *
     * @param  int  $id
     * @return Response
     */
    public function declineInvite($inviteId=0) 
    {
         if( ! $inviteId) {
            throw new InvalidInviteCodeException;
        }

        $invite = LeagueInvite::find($inviteId);//whereInvite($confirmation_code)->first();
        $league = League::find($invite->leagues_id);

        //update invite to say it's been accepted
        $invite->status = 'D';
        $invite->save();

        if (!is_null($invite->users_id)) {
            Flash::warning('We are sorry you have declined '.$league->owner->name.' invitation to join the '.$league->name.' league. Perhaps there are other leagues you are interested in joining?');
        } else {
            Flash::warning('We are sorry you have declined '.$league->owner->name.' invitation to join the '.$league->name.' league. You can still join the website if you want to?');            
        }
        return Redirect::route('home');
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
        $leaguerule->auto_select = $input['auto_select'];
        $leaguerule->blind_bid = $input['blind_bid'];
        $leaguerule->auction_timeout = $input['auction_timeout'];
        $leaguerule->round_duration = $input['round_duration'];
        $leaguerule->min_increment = $input['min_increment'];
        $leaguerule->max_increment = $input['max_increment'];
        $leaguerule->movie_takings_duration = $input['movie_takings_duration'];
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
        $leaguesToReview = League::whereNull('auction_stage')->where('enabled', '1')->get();

        //need to make sure each league has rules!
        foreach ($leaguesToReview as $league) {
            
            if (!is_null($league->rule)) {
                //ok we have rules find out the number of players
                $player_count = $league->players->count();
                $rules = $league->rule;
                
                if ($player_count >= $rules->min_players) { //} && $player_count <= $rules->max_players) { //NOTE: Remove this restriction to allow the auction to start
                    Log::info("League ".$league->name." has the players - ". $player_count);

                    if(is_null($league->auction_start_date)) {
                        $start_time = $rules->start_time;
                        $time_to_start = time() + (60 * 60 * 4); //60 secs * 60 mins * 4 = 4hours
                        //Log::info("Time dif: $time_to_start - ".strtotime($start_time));
                        if ($time_to_start > strtotime($start_time)) {
                            //the new date is no good so set the time for the next day
                            $league->auction_start_date = date("Y-m-d G:i:s", strtotime('+1 day', strtotime((date("Y-m-d")." ".$start_time))));
                        } else {
                            $auction_start_date = date("Y-m-d G:i:s", strtotime($start_time));
                            // ok we are fine to go ahead with this date today - so lets set the time to it
                            $league->auction_start_date = $auction_start_date;
                        }

                    }

                    if(is_null($league->auction_close_date)) {
                        //need to create close date for auction
                        $close_date = $league->auction_start_date;
                        $auction_duration = $rules->auction_duration;
                        $league->auction_close_date = date("Y-m-d G:i:s", strtotime('+'.$auction_duration.' hours', strtotime($close_date)));

                    }

                    $league->auction_stage = 0;
                    $league->save();
                } else {
                    //send email to league owner to find more players
                    Log::info('League '.$league->id.' - '.$league->name.' needs more players.');

                    if (is_null($league->next_email_send) || ($league->email_limit < 5 && strtotime($league->next_email_send) < time())) {

                        $data = ['ownerName' => $league->owner->fullName(), //(!is_null($league->owner->forenames) ? $league->owner->forenames : $league->owner->name),
                                'leagueName' => $league->name,
                                'subject' => 'More Players Needed!'];

                        $ownerEmail = $league->owner->email;
                        Mail::send('emails.players_needed', $data, function($message) use ($ownerEmail)
                        {
                            $message->from('leagues@thenextbigfilm.com', 'TheNextBigFilm Entertainment');
                            $message->to($ownerEmail);
                            $message->subject('More Players Needed!');
                        });
                    }

                    //update email req
                    $league->email_limit = $league->email_limit + 1;
                    $league->next_email_send = strtotime("+3 hours", strtotime($league->next_email_send));

                    $league->save();

                    //TODO: Find more players to see if there are any that can be invited
                    

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
        /*DB::connection()->enableQueryLog();*/
        $leaguesToNotify = League::whereNotNull('auction_start_date')
            ->where('auction_start_date', '>', date("Y-m-d H:i:s"))
            ->where('enabled', '1')->where('auction_stage', '0')->get();

        //need to make sure each league has rules!
        foreach ($leaguesToNotify as $league) {
            $rules = $league->rule;

            //if league auction is 12 hours away send reminder
            Log::info("Name: ".$league->name." Auto: ".$rules->auto_select);
            //if league auction is 6 hours away send reminder and populate the movies if required
            //need to make sure there aren't already movies added to the league
            if ($rules->auto_select == 'Y') {
                //need to find the required number of movies
                if ($league->movies->count() == 0) {
                    $chosen_movies = $league->populateMovies();
                    $movies_count = count($chosen_movies);
                } else
                    $movies_count = $league->movies->count();

                //only set this if there are movies added to the league
                //if (count($chosen_movies) > 0)
                if($movies_count > 0)
                    $league->auction_stage = 1;

                $subject = "League ".$league->name." auctions will start at: ".date("j M y g:iA", strtotime($league->auction_start_date));
                foreach($league->players as $player) {

                    $data = ['playerName' => $player->fullName(), 
                            'leagueName' => $league->name,
                            'subject' => $subject,
                            'leagueMovies' =>$league->movies()->orderBy('name', 'ASC')->get()];

                    $playerEmail = $player->email;

                    Mail::send('emails.league_ready', $data, function($message) use ($playerEmail, $subject) {
                        $message->from('leagues@thenextbigfilm.com', 'TheNextBigFilm Entertainment');
                        $message->subject($subject);
                        $message->to($playerEmail);
                    });
                }

                //movies have been populated - set the auction stage to 1
                $league->save();
                
            } elseif ($rules->auto_select != 'Y') {
                if ($league->movies->count() == 0) {

                    //need to check that we haven't overdone it on the movies needed email
                    if ($league->email_limit < 10 && (strtotime($league->next_email_send) < time() || is_null($league->next_email_send))) {

                        //need to pass in the league details for the owner
                        $data = ['ownerName' => (!is_null($league->owner->forenames) ? $league->owner->forenames : $league->owner->name),
                                'leagueName' => $league->name];

                        $ownerEmail = $league->owner->email;
                        Mail::send('emails.movies_needed', $data, function($message) use ($ownerEmail)
                        {
                            $message->from('leagues@thenextbigfilm.com', 'TheNextBigFilm Entertainment');
                            $message->subject('More movies are needed');
                            $message->to($ownerEmail);
                        });

                        //update email req
                        $league->email_limit = $league->email_limit + 1;
                        if ($league->email_limit < 10)
                            $league->next_email_send = strtotime("+3 hours", strtotime($league->next_email_send));

                        $league->save();
                    }
                }

            }

            //if league auction is 10 minutes away send final reminder

            //TODO: perhaps ther should be options in the profile to restrict this?
        }
    }


    /**
     * Close leagues where the start date has passed and the auction stage is not at least 1
     *
     * @param  int  $id
     * @return Response
     */
    public function closeLeaguesWhereStartDatePassed() 
    {
        /*DB::connection()->enableQueryLog();*/
        $leagues = League::where('enabled', '1')->where('auction_start_date', '<', date("Y-m-d H:i"))
            ->Where(function ($query) {
                $query->where('auction_stage', 0)->orWhereNull('auction_stage');
            })->get(); //update(['enabled'=>'0']);

        foreach($leagues as $league_to_close) {
            //need to disable each league and also disable the league users whilst sending out an email
            League::where('id', $league_to_close->id)->update(['enabled'=>'0']);
            
            //disable league user
            LeagueUser::where('league_id', $league_to_close->id)->update(['enabled'=>'0']);

            //send email about closed league
            $subject = "League ".$league_to_close->name." has been closed.";
            foreach ($league_to_close->players as $player) {
                $playerEmail = $player->email;
                $data = ['playerName' => $player->fullName(),
                        'leagueName' => $league_to_close->name,
                        'subject' => $subject];

                Mail::send('emails.league_disabled', $data, function($message) use ($playerEmail, $subject)
                {
                    $message->from('leagues@thenextbigfilm.com', 'TheNextBigFilm Entertainment');
                    $message->subject($subject);
                    $message->to($playerEmail);
                });

            }
        }

        //now delete those disabled that have been disabled over a day
        League::where('enabled', '0')->where('updated_at', '<', date("Y-m-d H:i", strtotime("-1 day")))->delete();
    /*    $queries = DB::getQueryLog();
        print_r($queries);    */
    }

    /**
     * End leagues doing the following:
     1) Close the league - set status to 5
     2) Disable the league
     3) Send Confirmation email to determine winner
     *
     * @return Response
     */
    public function endLeagueWithWinners() 
    {
        //DB::connection()->enableQueryLog();
        //get all leagues where league state is < 5 and league close date has passed
        $leagues = League::where('auction_stage', '<', '5')->whereNotNull('end_date')->where('end_date', '<', date("Y-m-d H:i"))->where('enabled', '1')->get();
        /*$queries = DB::getQueryLog();
        print_r($queries);    */
        //work out the winner 
        if ($leagues->count() > 0) {
            foreach ($leagues as $league) {
                $placings = LeagueRoster::rankings($league->id)->orderBy('total_gross', 'DESC')->get();

                //echo "Reviewing ".$league->name." league<br/>";
                //work out total balance won
                $winnerChosen = false;
                $winner = null;
                $leagueValue = $league->value();
                $newPlayerBalance = 0;

                foreach ($placings as $placing) {
                    if (!$winnerChosen) {
                        //winners details
                        $league->setWinner($placing->users_id);

                        /*$winner = User::find($placing->users_id);
                        $newPlayerBalance = (is_null($winner->balance) ? 0 : $winner->balance) + $leagueValue;

                        Log::info("Winner chosen as ".$winner->fullName()." to win ".$newPlayerBalance);

                        //we should have the top placing user
                        $data = ['winnerName' => $winner->fullName(),
                                'leagueName' => $league->name,
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
                        User::where('id', $winner->id)->update(['balance'=>$newPlayerBalance]);*/

                        $winnerChosen = true;
                    } else {
                        // loser emails
                        $loser = User::find($placing->users_id);
                        $data = ['loserName' => $loser->fullName(),
                                'leagueName' => $league->name,
                                'subject' => 'You are unlucky this time!'];

                        echo "Loser is chosen as <strong>".$loser->fullName()."</strong><br/>";
                        $loserEmail = $loser->email;
                        Mail::send('emails.league_loser', $data, function($message) use ($loserEmail)
                        {
                            $message->from('leagues@thenextbigfilm.com', 'TheNextBigFilm Entertainment');
                            $message->subject('You are unlucky this time!');
                            $message->to($loserEmail);
                        });
                    }
                }

                //disable the league
                if (!is_null($winner))
                    $league->setWinner($winner->id);
                    //League::where('id', $league->id)->update(['enabled'=>'0', 'auction_stage'=>'5', 'winners_id'=>$winner->id]);
            }   
        } else {
            echo "No leagues found for ending.";
        }
    }    

    /**
     * Add message to league for chat
     *
     * @return Response
     */
    public function addMessage(\App\Http\Requests\CreateLeagueMessageRequest $request) {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');
        
        $input = Input::all();
        $message = LeagueMessage::create( $input );
        return redirect()->back();        
    }

    /**
     * Find Leagues that dont have rosters even though they are set to auction stage 3
     */
    public function closeLeaguesWithoutRosters() {
        //get leagues who are going to be disabled and then make sure all users are disabled in the leagues as well
        $rosterLeagues = League::where('auction_stage', '3')->where('enabled', '1')->lists('id');

        //got list of live leagues - now find out which dont have rosters
        $inRosters = LeagueRoster::whereIn('leagues_id', $rosterLeagues)->lists('leagues_id');

        //ok we have a list of leagues that have rosters we can now work out which leagues dont have rosters
        $missingLeagues = array_diff($rosterLeagues, $inRosters);

        //close the leagues which are missing rosters
        League::whereIn('id', $missingLeagues)->update(['auction_stage'=>'5', 'enabled'=>'0']);

        //disable the league/users where the leagues are now disabled
        LeagueUser::whereIn('league_id', $missingLeagues)->update(['enabled'=>'0']);

        //keep a record of leagues closed 
        $leagues = League::whereIn('id', $missingLeagues)->get();
        foreach($leagues as $closeLeague) {
            Log::info('League '.$closeLeague->name.' ('.$closeLeague->id.') closed as there are no rosters for it.');
        }
    }
}