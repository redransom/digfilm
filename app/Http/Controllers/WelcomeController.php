<?php namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use App\Models\League;
use App\Models\LeagueUser;
use App\Models\RuleSet;
use App\Models\Genre;
use App\Models\Movie;

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
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$authUser = Auth::user();

		return view('welcome')
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
			$leagues = League::all();
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


		$leagueUsers = LeagueUser::where('league_id', $league->id)->get();
		$currentLeagueUser = LeagueUser::where('user_id', $authUser->id)->where('league_id', $league->id)->first();
		return view('league-show')
			->with('currentLeague', $league)
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
		$rules = RuleSet::all();

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
		$users = User::whereIn('id', $availableUsers)->where('id', '!=', $authUser->id)->get();
		
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

		$currentLeagueUser = LeagueUser::where('user_id', $authUser->id)->where('league_id', $league->id)->first();
		return view('league-movie-roster')
			->with('currentLeague', $league)
			->with('currentLeagueUser', $currentLeagueUser)
			->with('authUser', $authUser);	
	}

}
