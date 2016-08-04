<?php namespace App\Http\Controllers;

//use DB;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Auction;
use App\Models\LeagueInvite;
use App\Models\LeagueUser;
use Session;
use Input;
use Redirect;
use Flash;

use Illuminate\Http\Request;

class UsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($type = '')
	{
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$input = Input::all();
		$search = "";
		if (isset($input['users-search-text'])) {
			$search_like = '%'.$input['users-search-text'].'%';

			$users = User::where('name', 'LIKE', $search_like)
				->orWhere('forenames', 'LIKE', $search_like)
				->orWhere('surname', 'LIKE', $search_like)->paginate();
			$search = $input['users-search-text'];
		} elseif ($type != '') {
			$role = Role::where('name', $type)->first();
			
			$user_role = RoleUser::where('role_id', $role->id)->lists('user_id');
			
			$users = User::whereIn('id', $user_role)->paginate();
		} else 
			$users = User::paginate(10);

		$roles = Role::all();

		return View("users.all")
			->with('users', $users)
			->with('roles', $roles)
			->with('authUser', $authUser)
			->with('page_name', 'users')
			->with('search', $search)
			->with('instructions', 'Members List')
			->with('title', 'Members');
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

		$title = "Add User";
		$roles = Role::lists('name', 'id');
		$instructions = $title ." Details";

		return View("users.add")
			->with('authUser', $authUser)
			->with('page_name', 'user-add')
			->with('roles', $roles)
			->with('instructions', $instructions)
			->with('title', $title);
	}

	/*private function getRoleKey($user_type) {
		if ($user_type == 'A')
			return 'Admin';
		elseif ($user_type == 'C')
			return 'Customer';
		else
			return 'Supplier';
	}*/

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateUserRequest $request)
	{
		//
		$user_type = Input::get('user_type');

		$input = $request->all();

		if (isset($input['role_id'])) {
			$role = \App\Models\Role::where('id', $input['role_id'])->first();	
		} else {
			//if role not selected we can get the player role
			$role = \App\Models\Role::where('name', 'Player')->first();
		}

		$user = new User();
		$user->name = $input['name'];
		$user->email = $input['email'];
		$user->forenames = $input['forenames'];
		$user->surname = $input['surname'];

		//check the passwords are not set
		if (isset($input['confirm_password']) && $input['confirm_password'] == "") {
			unset($input['confirm_password']);
			unset($input['password']);
		} elseif (isset($input['confirm_password']) && ($input['confirm_password'] == $input['password'] && $input['password'] != "")) {
			unset($input['confirm_password']);
			$user->password = bcrypt($input['password']);
		}

		$user->save();

		if ($request->file('thumbnail') != "") {
			$imageName = $user->id.str_replace(' ', '_', strtolower($input['forenames'])) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
			$request->file('thumbnail')->move(base_path() . '/public/images/users/', $imageName);

			$user->thumbnail = "/images/users/".$imageName;
			$user->save();
		}

		//set role
		$user->attachRole($role);

		Flash::message('New user has been created!');
		return redirect()->route("users.index");
			
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

		$user = User::find($id);
		$leagues = $user->leagues()->paginate(10);

		return View("users.show")
			->with('authUser', $authUser)
			->with('user', $user)
			->with('leagues', $leagues)
			->with('title', 'Details for '.$user->name);
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

		$user = User::find($id);
		$title = "Edit User";
		$instructions = $title ." Details";

/*		$role = Role::where('id', $this->getRole($authUser))->first();
		$roles = Role::where('role_order', '>=', $role->role_order)->orderBy('role_order', 'asc')->lists('display_name', 'id');
*/		
		$roles = Role::lists('name', 'id');
		return View("users.edit")
			->with('authUser', $authUser)
			->with('user', $user)
			->with('page_name', 'user-edit')
			->with('object', $user)
			->with('instructions', $instructions)
			->with('selected_role', $this->getRole($user))
			->with('roles', $roles)
			->with('title', $title);
	}

	private function getRole($user) {
		$role_name = "";
		$roles = Role::lists('name', 'id');
		foreach ($roles as $role_id => $role_name) {
			if ($user->hasRole($role_name)) {
				return $role_id;
			}
		}
		return -1;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, UpdateUserRequest $request)
	{
		//get user
		$user = User::find($id);
		$input = $request->all();

		//check the passwords are not set
		if (isset($input['password'])) {
			$user->password = bcrypt($input['password']);
		} else {
			$user->password = $user->password;
		}

		$user->name = $input['name'];
		$user->email = $input['email'];
		$user->forenames = $input['forenames'];
		$user->surname = $input['surname'];
		if (isset($input['description']))
			$user->description = $input['description'];

		if ($request->file('thumbnail') != "") {
			$imageName = $user->id.str_replace(' ', '_', strtolower($input['forenames'])) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
			$request->file('thumbnail')->move(base_path() . '/public/images/users/', $imageName);

			$user->thumbnail = "/images/users/".$imageName;
		}

		$user->save();

		 if (isset($input['role_id'])) {
            //remove current roles
            RoleUser::where('user_id', $user->id)->delete();

            foreach ($input['role_id'] as $role) {
                $ru = new RoleUser();
                $ru->role_id = $role;
                $ru->user_id = $user->id;
                $ru->save(['timestamps' => false]);

                unset($ru);
            }
        }

		if (isset($input['update_from']) && $input['update_from'] == 'P') {
			Flash::message('Profile updated!');
			return Redirect::route('edit-profile');
		} else {
			Flash::message('User updated!');
			return Redirect::route('users.index');
		}

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
		$authUser = Auth::user();

		//ensure permissions are available - should probably check for permissions and not role
		if ($authUser->hasRole("Admin")) {
			$user = User::find($id);
			$user_message = "";
			if (!empty($user)) {
				$user_message = "User " .$user->name. " has been removed.";
				Flash::message($user_message);
				$user->delete();
			}
			return Redirect::route('users.index');
		}
		return Redirect::route('users.index')->with('message', 'You don\'t have the permissions to complete this task.');
	}

	/**
	 * Use this function to set all of the roles/permissions in the system - remove once completed.
	 *
	 * @return Response
	 */
	/*public function setroles() {
		//get users and 
		$adminUser = User::where('name', 'Kinsley')->get();

		//create roles
		$supplier = new Role();
		$supplier->name = "supplier";
		$supplier->save();

		$customer = new Role();
		$customer->name = "customer";
		$customer->save();

		$admin = new Role();
		$admin->name = "admin";
		$admin->save();

		$adminUser->attachRole($admin);
		
	}
*/

	public function adminDashboard() {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		//totals 
		$totals['liveAuctionTotal'] = Auction::where('ready_for_auction', '1')->count();
		
		return View("users.admin")
			->with('use_graph', true)
			->with('totals', $totals)
			->with('authUser', $authUser)
			->with('page_name', 'admin-dashboard')
			->with('title', 'Welcome to the TheNextBigFilm adminstration system Dashboard');
	}

	public function usersDashboard() {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		return View("users.dashboard")
			->with('use_graph', true)
			->with('authUser', $authUser)
			->with('page_name', 'dashboard')
			->with('title', 'Welcome to your leagues');
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
			$user = User::find($id);
			$user_message = "";
			if (!empty($user)) {
				$user_message = "User " .$user->name. " has been disabled.";
				Flash::message($user_message);
				$user->enabled = false;
				$user->save();
			}
			
		} else 
        	Flash::message('You don\'t have the permissions to complete this task.');

        return redirect()->back();
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
			$user = User::find($id);
			$user_message = "";
			if (!empty($user)) {
				$user_message = "User " .$user->name. " has been enabled.";
				Flash::message($user_message);
				$user->enabled = true;
				$user->save();
			}
			
		} else 
        	Flash::message('You don\'t have the permissions to complete this task.');
        return redirect()->back();
	}

	/**
	 * Confirm User Registration
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function confirmRegister($confirmation_code)
	{
		 if( ! $confirmation_code) {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user) {
            throw new InvalidConfirmationCodeException;
        }

        $user->enabled = 1;
        $user->confirmation_code = null;
        $user->save();

        //make sure invites are handled
        $invites = LeagueInvite::where('email', $user->email)->where('status', 'I')->get();
        if($invites->count() > 0) {
        	foreach ($invites as $invite) {
        		$lu = new LeagueUser();
        		$lu->league_id = $invite->leagues_id;
        		$lu->user_id = $user->id;
        		$lu->balance = 100;
        		$lu->save();

        		unset($lu);
        	}
        }

        Flash::message('You have successfully verified your account.');

        return Redirect::route('email-verified');	
        //return redirect('/auth/login');
	}


}
