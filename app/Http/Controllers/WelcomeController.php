<?php namespace App\Http\Controllers;
use Auth;
use DB;
use Input;
use Mail;
use Flash;
use Redirect;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
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
		$content = SiteContent::section('HOM');

		if (isset($authUser)) {
			$count_array['public'] = League::availableLeagues($authUser)->count();
		} else 
			$count_array['public'] = League::where('type', 'U')->where('enabled', 1)
	        	->Where(function ($query) {
	        		$query->whereNull('auction_stage')->orWhere('auction_stage', '<', '2');
	        	})->count();

	    $count_array['newreleases'] = Movie::where('release_at', '>', date('Y-m-d', strtotime("-4 weeks")))->
			where('release_at', '<=', date('Y-m-d'))->count();
		$count_array['comingsoon'] = Movie::where('release_at', '<', date('Y-m-d', strtotime("+4 weeks")))
			->where('release_at', '>', date('Y-m-d'))->count();
		/* Move to User Model maybe? */
		$playerRole = Role::where('name', 'Player')->first();
		$player_role_ids = RoleUser::where('role_id', $playerRole->id)->lists('user_id');
		$count_array['player'] = User::where('enabled', '1')->whereIn('id', $player_role_ids)->count();

	    $count_array['private'] = League::where('type', 'R')->where('enabled', 1)->count();
        $opening_bids = Movie::where('opening_bid_date', '<=', date("Y-m-d"))->whereNotNull('opening_bid_date')->
        	where('opening_bid', '>', 0)->orderBy('updated_at', 'DESC')->limit(5)->get();

        $recent_leagues = League::where('enabled', '1')->Where(function ($query) {
	        		$query->whereNull('auction_stage')->orWhere('auction_stage', '<', '2');
	        	})->orderBy('created_at', 'DESC')->limit(10)->get();

        //new trailers
        $trailers = MovieMedia::where('type', 'T')->orderBy('created_at', 'DESC')->limit(5)->get();

		return view('welcome')
			->with('slider', $slider)
			->with('content', $content)
			->with('count_array', $count_array)
			->with('recent_leagues', $recent_leagues)
			->with('next_film', $next_film)
			->with('trailers', $trailers)
			->with('frontpage', true)
			->with('opening_bids', $opening_bids)
			->with('authUser', $authUser)
			->with('meta', $this->get_meta($content))
			->with('title', (!is_null($content) ? $content->title : 'Welcome to TheNextBigFilm'));
	}

	public function about() {
		$authUser = Auth::user();

		//get content
		$content = SiteContent::section('ABT');
		return view('about')
			->with('content', $content)
			->with('page_name', 'about')
			->with('meta', $this->get_meta($content))
			->with('title', (!is_null($content) ? $content->title : ''))
			->with('authUser', $authUser);	
	}

	public function rules() {
		$content = SiteContent::section('RUL');

		$authUser = Auth::user();
		return view('rules')
			->with('content', $content)
			->with('page_name', 'rules')
			->with('meta', $this->get_meta($content))
			->with('title', (!is_null($content) ? $content->title : ''))
			->with('authUser', $authUser);	
	}

	public function terms() {
		$authUser = Auth::user();
		$content = SiteContent::section('TER');

		return view('terms')
			->with('content', $content)
			->with('page_name', 'terms')
			->with('meta', $this->get_meta($content))
			->with('title', (!is_null($content) ? $content->title : ''))
			->with('authUser', $authUser);	
	}

	/**
	 * Take post details and compile an email / need to avoid spam somehow
	 *
	 * @return void
	 */
	public function postContact() {
		$input = Input::all();

		$data = ['contact_name'=>$input['name'], 
				'contact_email'=>$input['email'],
				'contact_reason'=>$input['reason'],
				'contact_message'=>$input['message'],
				'subject'=>'Contact from website'];

		Mail::send('emails.contact', $data, function($message) {
            $message->to(env('CONTACT_EMAIL'), env('CONTACT_NAME'))
                ->subject('Verify your email address');
        });
		Flash::success('Thank you for your message - we will get in touch soon!');
		return Redirect::route('contact');

	}

	public function contact() {
		$authUser = Auth::user();
		$content = SiteContent::section('CON');

		return view('contact')
			->with('page_name', 'contact')
			->with('content', $content)
			->with('fullwidth', true)
			->with('meta', $this->get_meta($content))
			->with('title', (!is_null($content) ? $content->title : ''))
			->with('authUser', $authUser);	
	}

	private function get_meta($content) {
		$meta = array();
		if(!is_null($content)) {
			if ($content->meta_keywords != '')
				$meta['meta_keywords'] = $content->meta_keywords;
			if ($content->meta_description != '')
				$meta['meta_description'] = $content->meta_description;
		}
		return $meta;
	}

	public function privacy() {
		$authUser = Auth::user();
		$content = SiteContent::section('PRI');

		return view('privacy')
			->with('content', $content)
			->with('page_name', 'privacy')
			->with('meta', $this->get_meta($content))
			->with('title', (!is_null($content) ? $content->title : ''))
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
			->with('authUser', $authUser)
			->with('title', 'Public Leagues to Join');	
	}

	/**
	 * Show league for playing
	 *
	 * @return void
	 */
	public function getLeaguePlay($id, $col="name", $order = "asc") {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$league = League::find($id);

		//dont show leagues that have been disabled.
		if ($league->enabled == 0) {
			Flash::message('League '.$league->name.' has been closed unexpectedly - we are sorry for any inconvienence.');
			return redirect('dashboard');
		}

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
			->with('order', $order)
			->with('col', $col)
			->with('leagueUsers', $leagueUsers)
			->with('wonAuctions', $wonAuctions)
			->with('expiredAuctions', $expiredAuctions)
			->with('movies', $movies)
			->with('previous_bids', $previousBids)
			->with('currentLeagueUser', $currentLeagueUser)
			->with('authUser', $authUser)
			->with('title', 'Play League');	
	}

	/**
	 * Show league for viewing
	 *
	 * @return void
	 */
	public function getLeague($id) {
		$authUser = Auth::user();
		/*if (!isset($authUser))
			return redirect('/auth/login');*/

		$league = League::find($id);

		//dont show leagues that have been disabled.
		if ($league->enabled == 0)
			return redirect('/');

		if ($league->auction_stage == '2') {
			//redirect to the in play page
			return redirect('league-play/'.$league->id);
		}

		/*
		Need to find the league pot size (based on balances)
		Player count
		Total league revenue i.e. box office revenue of all movies in league (if at that stage)
		Top two movies in league on revenue
		Highest paid film
		Highest bid (same as above?)
		Ranking table
		*/
		$highest_bid = null;
		if ($league->auction_stage > 1 && $league->rosters()->count() > 0) {
			$max_bid = $league->rosters()->max('bid_amount');
			$highest_bid = $league->rosters()->where('bid_amount', $max_bid)->first();
		}

		$rankings = array();
		if ($league->auction_stage == 3)
			$rankings = LeagueRoster::rankings($league->id);

		//$rankings = $league->rosters->rankings();

		$leagueUsers = LeagueUser::where('league_id', $league->id)->get();
		if (!is_null($authUser))
			$currentLeagueUser = LeagueUser::where('user_id', $authUser->id)->
					where('league_id', $league->id)->first();
		else
			$currentLeagueUser = null;

		return view('league-show')
			->with('currentLeague', $league)
			->with('page_name', 'league-show')
			->with('padding', true)
			->with('rankings', $rankings)
			->with('highest_bid', $highest_bid)
			->with('object', $league)
			->with('fullwidth', true)
			->with('leagueUsers', $leagueUsers)
			->with('currentLeagueUser', $currentLeagueUser)
			->with('authUser', $authUser)
			->with('title', 'League Details');	
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
			->with('page_name', 'league-create')
			->with('authUser', $authUser)
			->with('title', 'Create League');	
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
			->with('authUser', $authUser)
			->with('title', 'Add Movies to your league');	
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
			->with('authUser', $authUser)
			->with('title', 'Choose who you want to play with');	
	}

	public function getProfile($username) {
		$authUser = Auth::user();

		$user = User::where('name', $username)->get();

		return view('profile')
			->with('fullwidth', true)
			->with('authUser', $authUser)
			->with('meta', $this->get_meta($content))
			->with('user', $user)
			->with('title', $user->fullName().'\'s Profile');	
	}

	public function getEditUser() {
		$authUser = Auth::user();
		$content = SiteContent::section('PRO');

		return view('edit-profile')
			->with('fullwidth', false)
			->with('content', $content)
			->with('authUser', $authUser)
			->with('page_name', 'edit-profile')
			->with('object', $authUser)
			->with('user', $authUser)
			->with('title', 'Your Profile');	
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

		$legend1 = null;
		$bid_history = null;

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

			//no of bids in time on this movie
			//TOOD: Move this to Movie function
			$sql = "SELECT MONTHNAME(created_at) AS month_nm, COUNT(*) AS no_of_bids FROM `auction_bids` ";
			$sql .= " WHERE movies_id = '".$movie->id."' GROUP BY MONTHNAME(created_at) ORDER BY created_at";
			$bid_history = DB::select(DB::raw($sql));

			//list of bid value in last 30 days
			$sql = "SELECT bid_amount, COUNT(bid_amount) as no_of_bids FROM `auction_bids` WHERE `movies_id` = '".$movie->id;
			$sql .= "' AND created_at >= '".$last_month."' GROUP BY bid_amount ORDER BY bid_amount";
			$last_30_data = DB::select(DB::raw($sql));

			foreach($last_30_data as $bid) {
				$bid_groups['amount'][] = $bid->bid_amount;
				$bid_groups['totals'][] = $bid->no_of_bids;
			}

			$legend1 = "<ul class='".strtolower($movie->name)."-legend'>";
			$legend1 .= "<li><span style='background-color:#ddd'></span>No Of Bids</li>";
			$legend1 .= "</ul>";

		}

		return view('movie-know')
			->with('authUser', $authUser)
			->with('fullwidth', true)
			->with('padding', true)
			->with('legend1', $legend1)
			->with('bid_history', $bid_history)
			->with('no_of_bids', $no_of_bids)
			->with('bid_groups', $bid_groups)
			->with('days', $days)
			->with('last_30', $last_30)
			->with('movie', $movie)
			->with('title', 'The movie knowledge for '.$movie->name);	

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
			->with('genre', $genre)
			->with('title', 'Movies in the '.$genre->name.' Genre');	
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
			->with('authUser', $authUser)
			->with('title', 'Roster for '.$league->name);	
	}

	/**
	 * All movies in db
	 *
	 * @return void
	 */
	public function movies() {
		$authUser = Auth::user();

		$movies = Movie::where('enabled', '1')->paginate(12);

		//highlights
		//ten most popular movies
		$highlights = Movie::where('opening_bid', '>', '10')->get();

		return view('all-movies')
			->with('page_name', 'all-movies')
			->with('highlights', $highlights)
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
			->with('page_title', 'New releases from last 4 weeks')
			->with('page_name', 'newreleases')
			->with('title', 'New Releases in last 4 weeks')
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
			->with('page_title', 'Coming up in next 4 weeks')
			->with('page_name', 'comingsoon')
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
			->with('title', $content->name)
			->with('authUser', $authUser);		
	}

	/**
	 * News article detail
	 *
	 * @return void
	 */
	public function newsArticles() {
		$authUser = Auth::user();

		$articles = SiteContent::articles(10);

		return view('news')
			->with('page_name', 'news-articles')
			->with('page_title', 'News Articles')
			->with('articles', $articles)
			->with('title', 'News Articles')
			->with('authUser', $authUser);
	}

	/**
	 * Made it in registering!
	 *
	 * @return void
	 */
	public function registerSuccessful() {
		return view('register-successful')
			->with('page_name', 'register-successful')
			->with('title', 'You have registered successfully.');	
	}

	/**
	 * Approved email
	 *
	 * @return void
	 */
	public function emailVerified() {
		return view('email-completed')
			->with('page_name', 'email-verified')
			->with('title', 'Your email address has been verified!');	
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
            ->with('page_name', 'manage-league')
            ->with('object', $league)
            ->with('authUser', $authUser)
			->with('title', 'Manage your league here');  
    }

	/**
     * Search site
     *
     * @return Response
     */
    public function postSearch() 
    {
    	$authUser = Auth::user();
    	$input = Input::all();
    	$results = array();
    	if (!empty($input['search_text'])) {
    		$title = 'You searched for ('.$input['search_text'].')';
    		$search = '%'.$input['search_text'].'%';
    		$results['movies'] = Movie::where('name', 'like', $search)->limit(5)->get();
    	} else {
    		$title = 'You searched for (nothing here)';
    	}

        return view('search-results')
        	->with('results', $results)
            ->with('page_name', 'search-results')
           	->with('authUser', $authUser)
			->with('title', $title);  
    }
}