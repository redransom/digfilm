<?php namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use App\Models\League;
use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\LeagueRoster;
use App\Models\LeagueUser;
use App\Models\RuleSet;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieMedia;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');

		//TODO: Set page logic here?
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$authUser = Auth::user();

		$earliest_release_date = strtotime("+1 week");

        //randomly populate movies
        $next_film = Movie::where('release_at', '>', date("Y-m-d", $earliest_release_date))->first();

/*        $available_movies = Movie::where('release_at', '>', date("Y-m-d", $earliest_release_date))
            ->Where(function ($query) use ($max_bid) {
                $query->where('opening_bid', '<', $max_bid)->orWhereNull('opening_bid');
            })->lists('id');

*/      
		if (isset($authUser)) {
			$public = League::availableLeagues($authUser)->count();
		} else 
			$public = League::where('type', 'U')->where('enabled', 1)
	        	->Where(function ($query) {
	        		$query->whereNull('auction_stage')->orWhere('auction_stage', '<', '2');
	        	})->count();



        $opening_bid = Movie::where('opening_bid_date', '<=', date("Y-m-d"))->whereNotNull('opening_bid_date')->
        	where('opening_bid', '>', 0)->orderBy('updated_at', 'DESC')->first();

        //new trailers
        $trailers = MovieMedia::where('type', 'T')->orderBy('created_at', 'DESC')->limit(4)->get();

		return view('welcome')
			->with('public_count', $public)
			->with('next_film', $next_film)
			->with('trailers', $trailers)
			->with('opening_bid', $opening_bid)
			->with('authUser', $authUser);
	}

	public function about() {
		$authUser = Auth::user();
		return view('about')
			->with('authUser', $authUser);	
	}

	public function rules() {
		$authUser = Auth::user();
		return view('rules')
			->with('authUser', $authUser);	
	}

	public function terms() {
		$authUser = Auth::user();
		return view('terms')
			->with('authUser', $authUser);	
	}

	public function contact() {
		$authUser = Auth::user();
		return view('contact')
			->with('authUser', $authUser);	
	}

	public function privacy() {
		$authUser = Auth::user();
		return view('privacy')
			->with('authUser', $authUser);	
	}

	public function leagues() {
		$authUser = Auth::user();

		if (!isset($authUser))
			$leagues = League::where('type', 'U')->where('enabled', 1)
	        	->Where(function ($query) {
	        		$query->whereNull('auction_stage')->orWhere('auction_stage', '<', '2');
	        	})->get();
		else
			$leagues = League::availableLeagues($authUser->id);

		return view('leagues')
			->with('leagues', $leagues)
			->with('authUser', $authUser);	
	}

	/**
	 * Show league details
	 *
	 * @return void
	 */
	public function getLeague($id) {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$league = League::find($id);

		if ($league->auction_stage == '3') {
			//redirect to the roster page
			return redirect('/roster/'.$league->id);
		}

		$movies = array();
		if ($league->movies()->count() > 0) {
			$movies_attached = $league->movies()->get();

			$movie_ids = array();
			foreach($movies_attached as $attach) {
				$movie_ids[] = $attach->id;
			}

			$movies = Movie::whereIn('id', $movie_ids)->orderBy('name', 'asc')->get();
		}

		//work out auctions
		$wonAuctions = $league->auctions()->where('ready_for_auction', '4')->orderBy('name', 'asc')->get();
		$expiredAuctions = $league->auctions()->whereIn('ready_for_auction', ['2', '3'])->orderBy('name', 'asc')->get();

		//TODO: get list of bids made by user for this auction
		$availableAuctions = Auction::where('leagues_id', $id)->lists('id');
		$previousBids = AuctionBid::where('users_id', $authUser->id)->whereIn('auctions_id', $availableAuctions)->lists('bid_amount', 'auctions_id');

		$leagueUsers = LeagueUser::where('league_id', $league->id)->get();
		$currentLeagueUser = LeagueUser::where('user_id', $authUser->id)->where('league_id', $league->id)->first();
		return view('league-show')
			->with('currentLeague', $league)
			->with('leagueUsers', $leagueUsers)
			->with('wonAuctions', $wonAuctions)
			->with('expiredAuctions', $expiredAuctions)
			->with('movies', $movies)
			->with('previous_bids', $previousBids)
			->with('currentLeagueUser', $currentLeagueUser)
			->with('authUser', $authUser);	
	}

	/**
	 * Create a league (if signed in)
	 *
	 * @return void
	 */
	public function create() {
		$authUser = Auth::user();
		$rules = RuleSet::where('admin_only', 'N')->get();

		return view('create-league')
			->with('rules', $rules)
			->with('authUser', $authUser);	
	}

	/**
	 * Add movies to the new league
	 *
	 * @return void
	 */
	public function addMovies($id) {
		$authUser = Auth::user();

		$league = League::find($id);
		$movies = \App\Models\Movie::where('enabled', 1)->where('release_at', '>', date("Y-m-d"))->get();

		return view('choose-movie')
			->with('league', $league)
			->with('movies', $movies)
			->with('authUser', $authUser);	
	}

	/**
	 * Add participants to league
	 *
	 * @return void
	 */
	public function addParticipants($id) {
		$authUser = Auth::user();

		$league = League::find($id);

		//need to get a list of all people who are on leagues that this user is on
		$leaguesOwned = $authUser->leagues->lists('id');
		//get players from league the user owns
		$userLeaguesOwns = LeagueUser::whereIn('league_id', $leaguesOwned)->lists('user_id');

		//get players from leagues that user plays in
		$leaguesPlayedIn = $authUser->inLeagues->lists('id'); //get league ids

		$userLeaguesPlayedIn = LeagueUser::whereIn('league_id', $leaguesPlayedIn)->lists('user_id');

		$availableUsers = $userLeaguesOwns + $userLeaguesPlayedIn;
		$playersInLeague = $league->players;
		$notInThisLeague = $playersInLeague->lists('id');

		$users = User::whereIn('id', $availableUsers)->where('id', '!=', $authUser->id)->whereNotIn('id', $notInThisLeague)->get();
		
		return view('choose-participants')
			->with('league', $league)
			->with('users', $users)
			->with('authUser', $authUser);	
	}

	public function getProfile() {
		$authUser = Auth::user();

		return view('profile')
			->with('authUser', $authUser)
			->with('user', $authUser);	
	}

	public function movieKnow($id) {
		$authUser = Auth::user();

		$movie = Movie::find($id);
		if (is_null($movie)) {
			//try for the slug
			$movie = Movie::where('slug', $id)->first();
		}

		return view('movie-know')
			->with('authUser', $authUser)
			->with('movie', $movie);	

	}

	public function movieGenre($id) {
		$authUser = Auth::user();

		$genre = Genre::find($id);
/*		if (is_null($movie)) {
			//try for the slug
			$movie = Movie::where('slug', $id)->first();
		}
*/
		return view('movie-genre')
			->with('authUser', $authUser)
			->with('genre', $genre);	

	}

	/**
	 * Show league details
	 *
	 * @return void
	 */
	public function getRoster($id) {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$league = League::find($id);
		$rankings = LeagueRoster::rankings($id);
		
		$currentLeagueUser = LeagueUser::where('user_id', $authUser->id)->where('league_id', $league->id)->first();
		return view('league-movie-roster')
			->with('currentLeague', $league)
			->with('rankings', $rankings)
			->with('currentLeagueUser', $currentLeagueUser)
			->with('authUser', $authUser);	
	}

	/**
	 * All new releases in the last month
	 *
	 * @return void
	 */
	public function newreleases() {
		$authUser = Auth::user();

		$movies = Movie::where('release_at', '>', date('Y-m-d', strtotime("-4 weeks")))->
			where('release_at', '<=', date('Y-m-d'))->get();

		return view('newreleases')
			->with('description', 'Here is a list of all movies have come out in the last 4 weeks.')
			->with('movies', $movies)
			->with('title', 'New Releases')
			->with('authUser', $authUser);		
	}
	
	/**
	 * All films due to be released in coming month
	 *
	 * @return void
	 */
	public function comingsoon() {
		$authUser = Auth::user();

		$movies = Movie::where('release_at', '<', date('Y-m-d', strtotime("+4 weeks")))
			->where('release_at', '>', date('Y-m-d'))->get();

		return view('comingsoon')
			->with('movies', $movies)
			->with('description', 'Here is a list of all movies that are coming out in the next 4 weeks.')
			->with('title', 'Coming Soon')
			->with('authUser', $authUser);		
	}

	/**
	 * Made it in registering!
	 *
	 * @return void
	 */
	public function registerSuccessful() {
		return view('register-successful');	
	}

	/**
	 * Approved email
	 *
	 * @return void
	 */
	public function emailVerified() {
		return view('email-completed');	
	}

	/**
     * Invite non-player to join league
     *
     * @param  int  $id
     * @return Response
     */
    public function manageLeague($id) 
    {
    	if( ! $id) {
            return redirect('/');
        }

        $authUser = Auth::user();
        $league = League::find($id);
/*
        $movies = $league->movies;
        $rule = $league->rule;
*/
        return view('league-manage')
            ->with('league', $league)
            ->with('authUser', $authUser);  
    }
}
