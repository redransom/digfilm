<?php namespace App\Http\Controllers;
use Auth;
use DB;
use App\Models\User;
use App\Models\League;
use App\Models\Auction;
use App\Models\AuctionBid;
use App\Models\LeagueRoster;
use App\Models\LeagueUser;
use App\Models\LeagueMessage;
use App\Models\RuleSet;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieMedia;
use App\Models\SiteContent;

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

*/      //get front slider images
		$slider = SiteContent::where('type', 'F')->get();

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
			->with('slider', $slider)
			->with('public_count', $public)
			->with('next_film', $next_film)
			->with('trailers', $trailers)
			->with('frontpage', true)
			->with('opening_bid', $opening_bid)
			->with('authUser', $authUser);
	}

	public function about() {
		$authUser = Auth::user();

		//get content
		$content = SiteContent::where('section', 'ABT')->first();

		return view('about')
			->with('content', $content)
			->with('page_name', 'about')
			->with('page_title', 'About TheNextBigFilm')
			->with('authUser', $authUser);	
	}

	public function rules() {
		$content = SiteContent::where('section', 'RUL')->first();
		$authUser = Auth::user();
		return view('rules')
			->with('content', $content)
			->with('page_name', 'rules')
			->with('page_title', 'How to play')
			->with('authUser', $authUser);	
	}

	public function terms() {
		$authUser = Auth::user();
		$content = SiteContent::where('section', 'TER')->first();

		return view('terms')
			->with('content', $content)
			->with('page_name', 'terms')
			->with('page_title', 'Terms & Conditions')
			->with('authUser', $authUser);	
	}

	public function contact() {
		$authUser = Auth::user();
		return view('contact')
			->with('page_name', 'contact')
			->with('page_title', 'How to get in touch')
			->with('authUser', $authUser);	
	}

	public function privacy() {
		$authUser = Auth::user();
		$content = SiteContent::where('section', 'PRI')->first();
		return view('privacy')
			->with('content', $content)
			->with('page_name', 'privacy')
			->with('page_title', 'Your Privacy')
			->with('authUser', $authUser);	
	}

	public function leagues() {
		$authUser = Auth::user();

		if (!isset($authUser))
			//ensure auction stage is less than 4 as this means the league has ended
			$leagues = League::where('type', 'U')->where('enabled', 1)
	        	->Where(function ($query) {
	        		$query->whereNull('auction_stage')->orWhere('auction_stage', '<', '4');
	        	})->get();
		else
			$leagues = League::availableLeagues($authUser->id);

		return view('leagues')
			->with('page_name', (is_null($authUser) ? 'all-leagues' : 'all-leagues-loggedin'))
			->with('object', $authUser)
			->with('leagues', $leagues)
			->with('authUser', $authUser);	
	}

	/**
	 * Show league for playing
	 *
	 * @return void
	 */
	public function getLeaguePlay($id) {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$league = League::find($id);

		//dont show leagues that have been disabled.
		if ($league->enabled == 0)
			return redirect('/');

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
		return view('league-play')
			->with('currentLeague', $league)
			->with('page_name', 'league-show')
			->with('object', $league)
			->with('leagueUsers', $leagueUsers)
			->with('wonAuctions', $wonAuctions)
			->with('expiredAuctions', $expiredAuctions)
			->with('movies', $movies)
			->with('previous_bids', $previousBids)
			->with('currentLeagueUser', $currentLeagueUser)
			->with('authUser', $authUser);	
	}

	/**
	 * Show league for viewing
	 *
	 * @return void
	 */
	public function getLeague($id) {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$league = League::find($id);

		//dont show leagues that have been disabled.
		if ($league->enabled == 0)
			return redirect('/');

		/*
		Need to find the league pot size (based on balances)
		Player count
		Total league revenue i.e. box office revenue of all movies in league (if at that stage)
		Top two movies in league on revenue
		Highest paid film
		Highest bid (same as above?)
		Ranking table
		*/
		if ($league->auction_stage > 1 && $league->rosters()->count() > 0)
			var_dump($league->rosters()->max('bid_amount'));

		$rankings = array();
		if ($league->auction_stage == 3)
			$rankings = LeagueRoster::rankings($league->id);

		//$rankings = $league->rosters->rankings();

		$leagueUsers = LeagueUser::where('league_id', $league->id)->get();
		$currentLeagueUser = LeagueUser::where('user_id', $authUser->id)->
					where('league_id', $league->id)->first();

		return view('league-show')
			->with('currentLeague', $league)
			->with('page_name', 'league-show')
			->with('padding', true)
			->with('rankings', $rankings)
			->with('object', $league)
			->with('fullwidth', true)
			->with('leagueUsers', $leagueUsers)
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

	public function getProfile($username) {
		$authUser = Auth::user();

		$user = User::where('name', $username)->get();

		return view('profile')
			->with('fullwidth', true)
			->with('authUser', $authUser)
			->with('user', $user);	
	}

	public function getEditUser() {
		$authUser = Auth::user();

		return view('edit-profile')
			->with('fullwidth', false)
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

		$no_of_bids = array();
		$last_30 = array();
		$days = array();
		$bid_groups = array();

		if (isset($authUser->id)) {
			//get movie stats
			//list of all bids in last 30 days
			//TODO: Move all of this to the model
			$last_month = date("Y-m-d", strtotime("-30 days"));
			$sql = "SELECT COUNT(movies_id) AS no_of_bids, DAYOFMONTH(created_at) AS day_no FROM `auction_bids` ";
			$sql .= "WHERE `movies_id` = '".$movie->id."' AND created_at >= '".$last_month."' GROUP BY DAYOFMONTH(created_at), ";
			$sql .= "DAY(created_at) ORDER BY DAY(created_at)";

			$no_of_bids_data = DB::select(DB::raw($sql));

			for($i=1; $i<31; $i++)
				$days[] = $i;

			//get the data points
			foreach($days as $day_no) {
				$added = false;
				foreach ($no_of_bids_data as $bid) {
					if ($bid->day_no == $day_no) {
						$no_of_bids[$day_no] = $bid->no_of_bids;	
						$added = true;
						break;
					}
				}

				if (!$added)
					$no_of_bids[$day_no] = 0;
			}

			//list of bid value in last 30 days
			$sql = "SELECT bid_amount, COUNT(bid_amount) as no_of_bids FROM `auction_bids` WHERE `movies_id` = '".$movie->id;
			$sql .= "' AND created_at >= '".$last_month."' GROUP BY bid_amount ORDER BY bid_amount";
			$last_30_data = DB::select(DB::raw($sql));


			foreach($last_30_data as $bid) {
				$bid_groups['amount'][] = $bid->bid_amount;
				$bid_groups['totals'][] = $bid->no_of_bids;
			}

		}

		return view('movie-know')
			->with('authUser', $authUser)
			->with('fullwidth', true)
			->with('padding', true)
			->with('no_of_bids', $no_of_bids)
			->with('bid_groups', $bid_groups)
			->with('days', $days)
			->with('last_30', $last_30)
			->with('movie', $movie);	

	}

	public function movieGenre($id) {
		$authUser = Auth::user();

		$genre = Genre::find($id);
		if (is_null($genre)) {
			//try for the slug
			$genre = Genre::where('slug', $id)->first();
		}

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
			->with('page_name', 'roster')
			->with('object', $league)
			->with('rankings', $rankings)
			->with('currentLeagueUser', $currentLeagueUser)
			->with('authUser', $authUser);	
	}

	/**
	 * All new releases in the last month
	 *
	 * @return void
	 */
	public function movies() {
		$authUser = Auth::user();

		$movies = Movie::where('enabled', '1')->get();

		return view('all-movies')
			->with('page_name', 'movies')
			->with('page_title', 'The Next Big Film Database')
			->with('movies', $movies)
			->with('title', 'All Our Movies')
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
	 * News article detail
	 *
	 * @return void
	 */
	public function newsDetail($id) {
		$authUser = Auth::user();

		$content = SiteContent::find($id);
		if (is_null($content)) {
			//try for the slug
			$content = SiteContent::where('slug', $id)->first();
		}

		return view('news-article')
			->with('page_name', 'news')
			->with('object', $content)
			->with('page_title', '')
			->with('content', $content)
			->with('title', 'News')
			->with('authUser', $authUser);		
	}

	/**
	 * Made it in registering!
	 *
	 * @return void
	 */
	public function registerSuccessful() {
		return view('register-successful')
			->with('page_name', 'register-successful');	
	}

	/**
	 * Approved email
	 *
	 * @return void
	 */
	public function emailVerified() {
		return view('email-completed')
			->with('page_name', 'email-verified');	
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
