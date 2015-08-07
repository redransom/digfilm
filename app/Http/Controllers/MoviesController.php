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
			->with('page_name', 'add_movie')
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

		return View("movies.show")
			->with('authUser', $authUser)
			->with('movie', $movie)
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
		$movie->save();

		return Redirect::route('movies.index');

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
