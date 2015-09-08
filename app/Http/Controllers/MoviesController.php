<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Movie;
use App\Models\Contributor;
use App\Models\MovieContributor;
use App\Models\ContributorType;
use App\Models\Role;
use Session;
use Input;
use Redirect;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\AddContributorToMovieRequest;
use Illuminate\Http\Request;
use Flash;

class MoviesController extends Controller {

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

		$movies = Movie::all();

		return View("movies.all")
			->with('movies', $movies)
			->with('authUser', $authUser)
			->with('page_name', 'movies')
			->with('instructions', 'All Movies registered in the site.')
			->with('title', 'Movies');
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
		return View("movies.add")
			->with('authUser', $authUser)
			->with('page_name', 'movie-add')
			->with('instructions', 'Add New Movie to Database')
			->with('title', 'Add Movie');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(\App\Http\Requests\CreateMovieRequest $request)
	{
		//
		$input = Input::all();
		$movie = Movie::create( $input );

		return Redirect::route('movies.index')->with('message', 'Movie created.');
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

		$movie = Movie::find($id);
		$title = "Movie ".$movie->name." details";

		$contributor_types = ContributorType::lists('name', 'id');

		return View("movies.show")
			->with('authUser', $authUser)
			->with('movie', $movie)
			->with('types', $contributor_types)
			->with('object', $movie)
			->with('page_name', 'movie-show')
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

		$movie = Movie::find($id);
		$title = "Edit Movie";

		return View("movies.edit")
			->with('authUser', $authUser)
			->with('movie', $movie)
			->with('object', $movie)
			->with('page_name', 'movie-edit')
			->with('title', $title);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, UpdateMovieRequest $request)
	{
		//get movie
		$movie = Movie::find($id);
		$input = $request->all();

		$movie->name = $input['name'];
		$movie->summary = $input['summary'];
		$movie->genre = $input['summary'];
		$movie->rating = $input['rating'];
		$movie->budget = $input['budget'];
		$movie->release_at = $input['release_at'];
		$movie->save();

		return Redirect::route('movies.index');

	}

/**
	 * Disable the user
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
			$movie = Movie::find($id);
			$user_message = "";
			if (!empty($movie)) {
				$message = "Movie " .$movie->name. " has been disabled.";
				Flash::message($message);
				$movie->enabled = false;
				$movie->save();
			}
			
		} else
        	Flash::message('You don\'t have the permissions to complete this task.');

        return Redirect::route('movies.index');
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
			$movie = Movie::find($id);
			$message = "";
			if (!empty($movie)) {
				$message = "Movie " .$movie->name. " has been enabled.";
				Flash::message($message);
				$movie->enabled = true;
				$movie->save();
			}
		}
        	Flash::message('You don\'t have the permissions to complete this task.');

        return Redirect::route('movies.index');
	}

	public function addContributor($id) {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$movie = Movie::find($id);
		$title = "Add Contributor to ".$movie->name." movie";
		$contributors = Contributor::all();

		$new_contributors = array();
		foreach ($contributors as $contributor)
			$new_contributors[$contributor->id] = $contributor->first_name." ".$contributor->surname;

		$contributor_types = ContributorType::lists('name', 'id');

		return View("movies.contributor")
			->with('authUser', $authUser)
			->with('movie', $movie)
			->with('object', $movie)
			->with('contributors', $new_contributors)
			->with('types', $contributor_types)
			->with('page_name', 'movie-contributor')
			->with('title', $title);
	}

	public function postContributor($id, AddContributorToMovieRequest $request) {
		$input = Input::all();
		$movie = MovieContributor::create( $input );

		return Redirect::route('movies.show', array($id))->with('message', 'Movie created.');
	}
}
