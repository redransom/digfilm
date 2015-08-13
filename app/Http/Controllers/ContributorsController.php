<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Movie;
use App\Models\Contributor;
use App\Models\ContributorType;
use App\Models\Role;
use Session;
use Input;
use Redirect;
use App\Http\Requests\CreateContributorRequest;
use App\Http\Requests\UpdateContributorRequest;

use Illuminate\Http\Request;

class ContributorsController extends Controller {

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

		$contributors = Contributor::paginate(4);

		return View("contributors.all")
			->with('contributors', $contributors)
			->with('authUser', $authUser)
			->with('page_name', 'contributors')
			->with('instructions', 'All Contributors registered in the site.')
			->with('title', 'Contributors');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$types = ContributorType::lists('name', 'id');

		return View("contributors.add")
			->with('authUser', $authUser)
			//->with('contributor_types', $types)
			->with('page_name', 'contributor-add')
			->with('instructions', 'Add New Contributor to Database')
			->with('title', 'Add Contributor');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateContributorRequest $request)
	{
		//		
		$input = Input::all();
		$contributor = Contributor::create( $input );

		if ($request->file('thumbnail') != "") {
			$imageName = $contributor->id.str_replace(' ', '_', strtolower($input['first_name'])) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
			$request->file('thumbnail')->move(base_path() . '/public/images/contributors/', $imageName);

			$contributor->thumbnail = "/images/contributors/".$imageName;
		}


		return Redirect::route('contributors.index')->with('message', 'Contributor created.');

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

		$contributor = Contributor::find($id);
		$title = "Contributor ".$contributor->name;

		return View("contributors.show")
			->with('authUser', $authUser)
			->with('contributor', $contributor)
			->with('object', $contributor)
			->with('page_name', 'contributor-show')
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
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$contributor = Contributor::find($id);
		$title = "Edit Contributor";

		return View("contributors.edit")
			->with('authUser', $authUser)
			->with('contributor', $contributor)
			->with('object', $contributor)
			->with('page_name', 'contributor-edit')
			->with('title', $title);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, UpdateContributorRequest $request)
	{
		//
		$contributor = Contributor::find($id);
		$input = $request->all();

		$contributor->first_name = $input['first_name'];
		$contributor->surname = $input['surname'];

		if ($request->file('thumbnail') != "") {
			$imageName = $contributor->id.str_replace(' ', '_', strtolower($input['first_name'])) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
			$request->file('thumbnail')->move(base_path() . '/public/images/contributors/', $imageName);

			$contributor->thumbnail = "/images/contributors/".$imageName;
		}

		$contributor->save();

		return Redirect::route('contributors.index');
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
