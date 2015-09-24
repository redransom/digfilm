<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\User;
use App\Models\League;
use App\Models\Movie;
use App\Models\LeagueUser;
use App\Models\LeagueMovie;
use App\Models\Role;
use App\Models\RuleSet;
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
        $leagues = League::paginate(10);

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
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(\App\Http\Requests\CreateLeagueRequest $request)
    {
        //
        $input = Input::all();
        $league = League::create( $input );

        if (!isset($input['rule_set'])) {
            //if no rule set is provided - just create a blank rule set
            $ruleset = RuleSet::first();
        } else {
            $ruleset = RuleSet::find($input['rule_set']);
        }

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
            Flash::message('League created.');
            return Redirect::route('leagues.index');
        } else {
            /* come by customer create league so go to select movies page */
            //return Redirect::route('choose-movies', [$league->id]);
            return Redirect::route('select-participants', [$league->id]);
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

        return View("leagues.edit")
            ->with('authUser', $authUser)
            ->with('users', $this->get_players())
            ->with('league', $league)
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
        $league->save();

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
        return Redirect::route('leagues.index')->with('message', 'You don\'t have the permissions to complete this task.');
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
        return Redirect::route('leagues.index')->with('message', 'You don\'t have the permissions to complete this task.');
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
        $movie = LeagueUser::create( $input );

        return Redirect::route('leagues.show', array($id))->with('message', 'Player added.');
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
        } else
            Flash::message("You don\'t have the permissions to complete this task.");

        return Redirect::route('leagues.show', $league->id);

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
            return Redirect::route('league', [$league_id])->with('message', 'Players have been invited to the league');
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
        $rule = LeagueRule::find($id);

        $input = Input::all();
        
    }

}
