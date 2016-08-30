<?php namespace App\Http\Controllers;

use Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\User;
use App\Models\Movie;
use App\Models\Contributor;
use App\Models\MovieContributor;
use App\Models\ContributorType;
use App\Models\Role;
use App\Models\MovieTaking;
use App\Models\MovieMedia;
use App\Models\Genre;
use App\Models\Rating;
use App\Models\MovieRating;
use Session;
use Input;
use Redirect;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\AddContributorToMovieRequest;
use App\Http\Requests\AddTakingsToMovieRequest;
use App\Http\Requests\AddMediaToMovieRequest;
use Illuminate\Http\Request;
use Flash;

class MoviesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($status = '1', $col = 'release_at', $order = 'asc')
	{
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$input = Input::all();
		$search = "";
		if (isset($input['movies-search-text'])) {
			$search_text = '%'.$input['movies-search-text'].'%';
			$movies = Movie::where('name', 'LIKE', $search_text)->orderBy($col, $order)->paginate();
			$search = $input['movies-search-text'];
		} else {
			if ($status == 'all')
				$movies = Movie::orderBy($col, $order)->paginate(10);
			else
				$movies = Movie::where('enabled', $status)->orderBy($col, $order)->paginate(10);
		}

		return View("movies.all")
			->with('movies', $movies)
			->with('status', $status)
			->with('order', $order)
			->with('authUser', $authUser)
			->with('page_name', 'movies')
			->with('search', $search)
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
		$genres = Genre::orderBy('name', 'asc')->lists('name', 'id');
		$ratings = Rating::all();

		$ratings_list = array();
		foreach ($ratings as $rating) {
			$ratings_list[$rating->id] = $rating->name." (".$rating->country.")";
		}
		return View("movies.add")
			->with('authUser', $authUser)
			->with('genres', $genres)
			->with('page_name', 'movie-add')
			->with('ratings', $ratings_list)
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
		$movie->slug = str_slug($movie->name, "-");

        $genre_string = '';
        if ($input['genres_id'] != '') {
            $genre = Genre::find($input['genres_id']);
            $genre_string = $genre->name;
        }
        $movie->meta_keywords = strtolower($movie->name).' genre '.$genre_string;
        $movie->meta_description = strtolower($movie->summary);

		if(is_numeric($input['opening_bid']) && $input['opening_bid'] > 0)
			$movie->opening_bid_date = date("Y-m-d H:i");

		if (!empty($input['release_at']))
			$movie->takings_close_date = date("Y-m-d", strtotime("+2 months", strtotime($movie->release_at)));
		
		$movie->save();

		if(isset($input['ratings'])) {
			foreach($input['ratings'] as $rating_id) {
				$r = MovieRating::create(['movies_id'=>$movie->id, 'ratings_id'=>$rating_id]);
				/*$rating = new MovieRating(['movies_id'=>$movie->id, 'ratings_id'=>$rating_id]);
				$rating->save();&/
			}
		}

		return Redirect::route('movie-show', [$movie->id]);
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
			->with('types', ['F'=>'Front', 'L'=>'List', 'A'=>'Auction', 'K'=>'Knowledge'])
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
		$ratings = Rating::all();

		$ratings_list = array();
		foreach ($ratings as $rating) {
			$ratings_list[$rating->id] = $rating->name." (".$rating->country.")";
		}

		$genres = Genre::orderBy('name', 'asc')->lists('name', 'id');
		$title = "Edit Movie";

		return View("movies.edit")
			->with('authUser', $authUser)
			->with('movie', $movie)
			->with('object', $movie)
			->with('ratings', $ratings_list)
			->with('genres', $genres)
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
		$movie->genres_id = $input['genres_id'];
		$movie->rating = $input['rating'];
		$movie->budget = $input['budget'];
		$movie->release_at = $input['release_at'];
		if(!is_null($input['opening_bid']))
			$movie->opening_bid = $input['opening_bid'];

		if(is_numeric($input['opening_bid']) && $input['opening_bid'] > 0)
			$movie->opening_bid_date = date("Y-m-d H:i");

		$movie->slug = str_slug($input["name"], "-");

		if ($input['takings_close_date'] == '' && $input['release_at'] != '')
			$movie->takings_close_date = date("Y-m-d", strtotime("+2 months", strtotime($input['release_at'])));
		else
			$movie->takings_close_date = $input['takings_close_date'];

		$movie->takings_frequency = $input['takings_frequency'];
		$movie->save();


		if (isset($input['ratings'])) {
			//clear out old ratings movie
			MovieRating::where('movies_id', $id)->delete();

			foreach($input['ratings'] as $rating_id) {
				$r = MovieRating::create(['movies_id'=>$id, 'ratings_id'=>$rating_id]);
				/*$rating = new MovieRating(['movies_id'=>$id, 'ratings_id'=>$rating_id]);
				$rating->save();*/
			}

		}

		Flash::message('Movie '.$movie->name. ' has been updated!');
		if (isset($input['referer']) && strrpos($input['referer'], 'movies-admin-search') === FALSE)
			return redirect($input['referer']);
		else
			return Redirect::route('movie-show', $movie->id);
	}

/**
	 * Disable the user
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function disable($id, $search = "")
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

        if ($search != "")
        	return Redirect::route('movies.index');
        else
        	return redirect()->back();
	}

	/**
	 * Enable the user
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function enable($id, $search = "")
	{
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
		} else
        	Flash::message('You don\'t have the permissions to complete this task.');

        if ($search != "")
        	return Redirect::route('movies.index');
        else
        	return redirect()->back();
	}

    /**
     * Remove media from movie
     *
     * @param  int  $id
     * @return Response
     */
    public function removeMedia($id)
    {
        //
        $authUser = Auth::user();

        //ensure permissions are available - should probably check for permissions and not role
        if ($authUser->hasRole("Admin")) {
            $mm = MovieMedia::find($id);
            if (!empty($mm)) {
                $movie = Movie::find($mm->movies_id);
                $message = "Media ".$mm->name." has been removed from ".$movie->name;
                Flash::message($message);

                $mm->delete();
            }
            return redirect()->back();
        } else
            Flash::message("You don\'t have the permissions to complete this task.");

        return redirect()->back();
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

		return Redirect::route('movie.show', array($id))->with('message', 'Movie created.');
	}

	public function addTakings($id, $date = null) {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$movie = Movie::find($id);
		$title = "Add Takings to ".$movie->name." the movie";
		$takings = MovieTaking::where('movies_id', $id)->orderBy('country', 'asc')->orderBy('takings_at', 'asc')->get();

		$countries = ['USD'=>'US Dollars', 'GBP'=>'English Pounds'];

		return View("movies.takings")
			->with('authUser', $authUser)
			->with('movie', $movie)
			->with('object', $movie)
			->with('takings', $takings)
			->with('countries', $countries)
			->with('taking_date', $date)
			->with('page_name', 'movie-takings')
			->with('title', $title);
	}

	public function postTakings($id, AddTakingsToMovieRequest $request) {
		$input = Input::all();

		//if date is not populated use todays date
		if ($input['takings_at'] == '')
			$input['takings_at'] = date("Y-m-d");

		//if less than 10,000 then we will multiply by 1million
		if ($input['amount'] < 10000)
			$input['amount'] = $input['amount'] * 1000000;

		$taking = MovieTaking::create( $input );

		//need to run the update on the league roster
/*		DB::update(DB::raw("UPDATE league_roster SET total_gross = ".$input['amount'].", value_for_money = ((".$input['amount']." / bid_amount) / 100000) WHERE movies_id = ".$input['movies_id']." AND takings_end_date > NOW()"));*/

		Flash::message('Movie takings added.');		
		return Redirect::route('movie-show', array($id));
	}

	public function addMedia($id) {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$movie = Movie::find($id);
		$title = "Add Media to ".$movie->name." the movie";
		$media = MovieMedia::where('movies_id', $id)->orderBy('type', 'asc')->orderBy('name', 'asc')->get();

		return View("movies.media")
			->with('authUser', $authUser)
			->with('movie', $movie)
			->with('object', $movie)
			->with('media', $media)
			->with('page_name', 'movie-media')
			->with('title', $title);
	}

	public function postMedia($id, AddMediaToMovieRequest $request) {
		$input = Input::all();
		//$media = MovieMedia::create( $input );

		$media = new MovieMedia();
		$media->movies_id = $input['movies_id'];
		$media->name = $input['name'];
		$media->description = $input['description'];
		$media->type = $input['type'];
		$media->image_type = $input['image_type'];
		if (isset($input['url']))
			$media->url = $input['url'];

		if ($input['type'] == 'T') {
			unset($input['file_name']);
		}
		$media->save();

		//check for file to be uploaded
		if ($request->file('file_name') != "") {
			$imageName = $media->id.str_replace(' ', '_', strtolower($input['name'])) . '.' . $request->file('file_name')->getClientOriginalExtension();
			$request->file('file_name')->move(base_path() . '/public/images/movies/', $imageName);

			$media->file_name = "/images/movies/".$imageName;
			$media->save();
		}

		Flash::message('Movie media added.');		
		return Redirect::route('movie-show', array($id));
	}

	public function disableOldMovies() {
		$currentTime = date("Y-m-d H:i:s");
		$affected = Movie::where('enabled', '1')->whereNotNull('takings_close_date')->where('takings_close_date', '<', $currentTime)->update(['enabled'=>'0']);
        Log::info("Disable Movies Time ".$currentTime. " disabled ".$affected.' movies');
	}

	/**
     * Remove the movie from site
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $authUser = Auth::user();
        if (!isset($authUser) || !$authUser->hasRole("Admin"))
            return redirect('/auth/login');

        //not sure if this is a function...
        if (Movie::exists($id)) {
            $movie = Movie::find($id);
            Flash::message('Movie '.$movie->name.' has been removed from the system.');
            $movie->delete();
            
        } else 
            Flash::message('You don\'t have the permissions to complete this task.');

        //if we come from a search then we need to make sure we can redirect to index
        return Redirect::route('movies.index');//return redirect()->back();
    }
}
