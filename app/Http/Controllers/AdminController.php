<?php namespace App\Http\Controllers;
use Auth;
use Session;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\League;
use App\Models\LeagueInvite;
use App\Models\LeagueUser;
use App\Models\RuleSet;
use App\Models\Movie;
use App\Models\MovieTaking;

class AdminController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Admin Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        $authUser = Auth::user();
        if (!isset($authUser))
            return redirect('/auth/login');

        $totals['takings'] = MovieTaking::dueTakings();

        //totals 
        $totals['liveAuctionTotal'] = Auction::where('ready_for_auction', '1')->count();
        $totals['liveLeaguesTotal'] = League::where('auction_stage', '>', '0')->where('auction_stage', '<', '3')->count();
        $totals['liveRostersTotal'] = League::where('auction_stage', '>', '2')->where('auction_stage', '<', '5')->count();
        $lastDay = strtotime("-1 day");
        $totals['bidsTodayTotal'] = AuctionBid::where('created_at', '>', date("Y-m-d", $lastDay))->count();
        $totals['liveAuctionsTotal'] = Auction::where('ready_for_auction', '<', '3')->count();

        //league types
        $rulesets = RuleSet::lists('name', 'id');
        foreach ($rulesets as $set_id => $set_name)
            $totals['RuleSetTotal'][$set_name] = League::where('rule_sets_id', $set_id)->where('enabled', '1')->count();
        $totals['LeagueTotal'] = League::where('enabled', '1')->count();

        //users 
        $admin_role = Role::where('name', 'Admin')->first();
        $admin_users = RoleUser::where('role_id', $admin_role->id)->lists('user_id');
        $totals['LivePlayers'] = User::where('enabled', '1')->whereNotIn('id', $admin_users)->count();

        //movies
        $totals['LiveMovies'] = Movie::where('enabled', '1')->count();
        $totals['TotalMovies'] = Movie::count();
        $totals['MoviesOnRelease'] = Movie::where('enabled', '1')->where('release_at', '<', date('Y-m-d'))->count();

        return View("admin.dashboard")
            ->with('use_graph', true)
            ->with('totals', $totals)
            ->with('authUser', $authUser)
            ->with('page_name', 'admin-dashboard')
            ->with('movies', Movie::lists('name', 'id'))
            ->with('title', 'Welcome to the TheNextBigFilm adminstration system Dashboard');
   }
}
