<?php namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use App\Models\League;

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
	 * Create a league (if signed in)
	 *
	 * @return void
	 */
	public function create() {
		$authUser = Auth::user();
		return view('create-league')
			->with('authUser', $authUser);	
	}

	public function getProfile() {
		$authUser = Auth::user();

		return view('profile')
			->with('authUser', $authUser)
			->with('user', $authUser);	
	}

 }
