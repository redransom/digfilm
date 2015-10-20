<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Movie;
use App\Models\Contributor;
use App\Models\ContributorType;
use App\Models\Role;
use App\Models\RuleSet;
use App\Models\LeagueRule;
use Session;
use Input;
use Redirect;
use Flash;
use App\Http\Requests\CreateRuleSetRequest;
use App\Http\Requests\UpdateRuleSetRequest;

use Illuminate\Http\Request;

class RuleSetsController extends Controller {

    /**
     * Display a listing of the rule sets.
     *
     * @return Response
     */
    public function index()
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $rulesets = RuleSet::all();

        return View("rulesets.all")
            ->with('rulesets', $rulesets)
            ->with('authUser', $authUser)
            ->with('page_name', 'rulesets')
            ->with('instructions', 'All Rule Sets setup in the site.')
            ->with('title', 'Rule Sets');
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

        
        return View("rulesets.add")
            ->with('authUser', $authUser)
            ->with('page_name', 'ruleset-add')
            ->with('instructions', 'Add New Rule Set to Database')
            ->with('title', 'Add Rule Set');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateRuleSetRequest $request)
    {
        //      
        $input = Input::all();
        $ruleset = RuleSet::create( $input );
        Flash::message('Rule set '.$ruleset->name. ' has been created successfully.');
        return Redirect::route('rulesets.index');

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

        $ruleset = RuleSet::find($id);
        $title = "Edit Rule Set";

        return View("rulesets.edit")
            ->with('authUser', $authUser)
            ->with('ruleset', $ruleset)
            ->with('object', $ruleset)
            ->with('page_name', 'ruleset-edit')
            ->with('title', $title);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateRuleSetRequest $request)
    {
        //
        $ruleset = RuleSet::find($id);
        $input = $request->all();

        $ruleset->name = $input['name'];
        $ruleset->description = $input['description'];
        $ruleset->blind_bid = $input['blind_bid'];
        $ruleset->min_players = $input['min_players'];
        $ruleset->max_players = $input['max_players'];
        $ruleset->min_movies = $input['min_movies'];
        $ruleset->max_movies = $input['max_movies'];
        $ruleset->auction_duration = $input['auction_duration'];
        $ruleset->ind_film_countdown = $input['ind_film_countdown'];
        $ruleset->joint_ownership = $input['joint_ownership'];
        $ruleset->auction_timeout = $input['auction_timeout'];
        $ruleset->min_bid = $input['min_bid'];
        $ruleset->max_bid = $input['max_bid'];
        $ruleset->randomizer = $input['randomizer'];
        $ruleset->auction_movie_release = $input['auction_movie_release'];
        $ruleset->start_time = $input['start_time'];
        $ruleset->close_time = $input['close_time'];
        $ruleset->league_type = $input['league_type'];
        $ruleset->auto_select = $input['auto_select'];
        $ruleset->save();

        Flash::message('Rule set '.$ruleset->name. ' has been updated successfully.');
        return Redirect::route('rulesets.index');
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
        if (!isset($authUser))
            return redirect('/auth/login');

        //not sure if this is a function...
        if (RuleSet::exists($id)) {
            $ruleset = RuleSet::find($id);
            Flash::message('Rule Set '.$ruleset->name.' has been removed from the system.');

            if ($ruleset->delete()) {
                LeagueRule::where('ruleset_id', $id)->update(['ruleset_id'=>'0']);
            }
            
            return Redirect::route('rulesets.index');
        }
    }

}
