<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\User;
use App\Models\League;
use App\Models\LeagueUser;
use App\Models\Role;
use Session;
use Input;
use Redirect;
use App\Http\Requests\CreateLeagueRequest;
use App\Http\Requests\UpdateLeagueRequest;
use App\Http\Requests\AddPlayerToLeagueRequest;
use Illuminate\Http\Request;

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

        $leagues = League::all();

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
/*
        $users = User::with(['role' => function($q){
            $q->where('name', 'Player');
        }])->lists('name', 'id');

        $role = Role::where('name', 'Player')->first();
        $user_ids = DB::table('role_user')->where('role_id', $role->id)->lists('user_id');

        $users = User::whereIn('id', $user_ids)->lists('name', 'id');
*/
        return View("leagues.add")
            ->with('authUser', $authUser)
            ->with('users', $this->get_players())
            ->with('page_name', 'league-add')
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

        return Redirect::route('leagues.index')->with('message', 'League created.');
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
     * Disable movie from use
     *
     * @param  int  $id
     * @return Response
     */
    public function disable($id)
    {
        //
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
}
