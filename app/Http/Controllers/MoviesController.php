<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Movie;
use App\Models\Role;
use Session;
use Input;
use Redirect;
use App\Http\Requests\CreateDomainRequest;

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

		return Redirect::route('movies.show')->with('message', 'Movie created.');
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
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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

}
