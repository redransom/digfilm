<?php namespace App\Http\Controllers;

//use DB;
use App\Http\Requests;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Role;
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
	public function index()
	{
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$users = User::paginate(4);
		$roles = Role::all();

		return View("users.all")
			->with('users', $users)
			->with('roles', $roles)
			->with('authUser', $authUser)
			->with('page_name', 'users')
			->with('instructions', 'Members List')
			->with('title', 'Members');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function search()
	{
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		//get the users by type
		$search = Input::get('search');
		DB::connection()->enableQueryLog();
		if ($search != "") {
			$search_text = '%'.$search.'%';

			$users = User::whereHas('profile', function($query) use ($search_text) {
				$query->where('forenames', 'like', $search_text)->orWhere('surname', 'like', $search_text);
			})->Where('name', 'like', $search_text)->orWhere('email', 'like', $search_text)->get();
		} else
			$users = User::all();

		$queries = DB::getQueryLog();
		
		//$suppliers = 
		$customers = $admin = array();

		foreach ($users as $user) {
			/*if ($user->hasRole("Supplier")) {
				$suppliers[] = $user;
			} else*/if ($user->hasRole("Customer")) {
				$customers[] = $user;
			} else {
				$admin[] = $user;
			}
		}

		$authUser = Auth::user();
		$sites = Domain::where('users_id', $authUser->id)->lists('name', 'id');

		return View("users.all")
			->with('users', $users)
			->with('suppliers', $suppliers)
			->with('customers', $customers)
			->with('admin', $admin)
			->with('authUser', $authUser)
			->with('page_name', 'users')
			->with('instructions', 'User List')
			->with('title', 'Users');
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	/*public function create_admin()
	{
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		$title = "Add Administrator";
		$instructions = $title ." Details";

		$role = Role::where('id', $this->getRole($authUser))->first();
		$roles = Role::where('role_order', '>=', $role->role_order)->orderBy('role_order', 'asc')->lists('display_name', 'id');

		return View("users.create")
			->with('user_type', 'A')
			->with('authUser', $authUser)
			->with('page_name', 'admin')
			->with('instructions', $instructions)
			->with('roles', $roles)
			->with('title', $title);
	}*/

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
			} else
				$role = \App\Models\Role::where('name', 'Customer')->first();

			$user = new User();
			$user->name = $input['name'];
			$user->email = $input['email'];
			
			//check the passwords are not set
			if (isset($input['confirm_password']) && $input['confirm_password'] == "") {
				unset($input['confirm_password']);
				unset($input['password']);
			} elseif (isset($input['confirm_password']) && ($input['confirm_password'] == $input['password'] && $input['password'] != "")) {
				unset($input['confirm_password']);
				$user->password = bcrypt($input['password']);
			}

			$user->save();

			//set role
			$user->attachRole($role);

			//need to create the user profile
			/*$profile = new UserProfile();
			$profile->users_id = $user->id;

			if ($request->file('thumbnail') != "") {
				$imageName = $user->id.str_replace(' ', '_', strtolower($input['name'])) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
				$request->file('thumbnail')->move(base_path() . '/public/images/profiles/', $imageName);

				$profile->thumbnail = "/images/profiles/".$imageName;
			}

			$profile->title = $input['title'];
			$profile->forenames = $input['forenames'];
			$profile->surname = $input['surname'];
			if ($role->name == "Customer")
				$profile->member_type = $input['member_type'];

			$profile->telephone = $input['telephone'];
			$profile->company_name = $input['company_name'];
			$profile->address_1 = $input['address_1'];
			$profile->address_2 = $input['address_2'];
			$profile->address_3 = $input['address_3'];
			$profile->town = $input['town'];
			$profile->city = $input['city'];
			$profile->county = $input['county'];
			$profile->post_code = $input['post_code'];
			$profile->country = $input['country'];
			$profile->save();
*/
			/*if ($role->name == "Customer") {
				//
				if (isset($input['website']) && $input['website'] != "") {
					$domain = new Domain();
					$domain->name = $input['website'];
					$domain->users_id = $user->id;
					$domain->save();

					if (isset($input['free_app']) && $input['free_app'] != "") {
						$domainapp = new DomainApp();
						$domainapp->domains_id = $domain->id;
						$domainapp->apps_id = $input['free_app'];
						$domainapp->save();

					}
				}
			}*/

			Flash::message('New user has been created!');
			return redirect()->route("users.index");
			//Redirect::route('dashboard')->with('message', 'Admin user '. $input['forenames'].' created.');
		//} else {
			//Flash::message('Emails dont match - please make sure they do!');

			//if ($user_type == "Customer")
			//return Redirect::back()->withInput();
				/*return redirect()->route("create_customer")->withInputs();
			else
				return redirect()->route("create_admin")->withInputs();*/
		//}
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
		$title = "Edit Member";
		$instructions = $title ." Details";

/*		$role = Role::where('id', $this->getRole($authUser))->first();
		$roles = Role::where('role_order', '>=', $role->role_order)->orderBy('role_order', 'asc')->lists('display_name', 'id');
*/		
		$roles = Role::lists('name', 'id');
		return View("users.edit")
			->with('authUser', $authUser)
			->with('user', $user)
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
/*		if (isset($input['confirm_password']) && $input['confirm_password'] == "") {
			unset($input['confirm_password']);
			unset($input['password']);
		} elseif (isset($input['confirm_password']) && ($input['confirm_password'] == $input['password'] && $input['password'] != "")) {
			unset($input['confirm_password']);
			$user->password = bcrypt($input['password']);
		}
*/
		if (isset($input['password'])) {
			$user->password = bcrypt($input['password']);	
		}

		$user->name = $input['name'];
		$user->email = $input['email'];
		$user->forenames = $input['forenames'];
		$user->surname = $input['surname'];
		$user->save();

		//check role change
/*		if (isset($input['role_id'])) {
			$role_id = $this->getRole($user);

			if ($role_id != $input['role_id']) {
				//role has changed - clear role for user
				DB::table('role_user')->where('user_id', $user->id)->where('role_id', $role_id)->delete();

				//attach new role to user
				$role = Role::where('id', $input['role_id'])->first();
				$user->attachRole($role);
			}

		}
*/
		/*$profile = $user->profile;

		if ($request->file('thumbnail') != "") {
			$imageName = $user->id.str_replace(' ', '_', strtolower($input['name'])) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
			$request->file('thumbnail')->move(base_path() . '/public/images/profiles/', $imageName);

			$profile->thumbnail = "/images/profiles/".$imageName;
		}

		$profile->title = $input['title'];
		$profile->forenames = $input['forenames'];
		$profile->surname = $input['surname'];
		$profile->telephone = $input['telephone'];
		$profile->company_name = $input['company_name'];
		$profile->address_1 = $input['address_1'];
		$profile->address_2 = $input['address_2'];
		$profile->address_3 = $input['address_3'];
		$profile->town = $input['town'];
		$profile->city = $input['city'];
		$profile->county = $input['county'];
		$profile->post_code = $input['post_code'];
		$profile->country = $input['country'];
		$profile->save();
*/
		Flash::message('User updated!');

		/*if (isset($input['direction']) && $input['direction'] == "profile")
			return Redirect::route('profile');
		else*/
			return Redirect::route('users.index');
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
/*
	public function selectsite() {
		$authUser = Auth::user();

		if ($authUser->hasRole("Admin")) {
			//redirect to dashboard
			return redirect('dashboard');
		}

		$sites = Domain::where('users_id', $authUser->id)->get();
		Session::put('available_domains', $sites);

		return View("users.selectsite")
			->with('sites', $sites)
			->with('authUser', $authUser)
			->with('page_name', 'select')
			->with('instructions', 'Click to select the site to manage')
			->with('title', 'Select Your Site');
	}

	public function confirmsite($id) {
		$authUser = Auth::user();

		$domain = Domain::where('users_id', $authUser->id)->where('id', $id)->firstOrFail();
		if (!empty($domain)) {
			Session::put('current_domain', $domain);
			return redirect('dashboard');
		} else {
			return redirect('home')->with('message', 'This domain does not belong to you.');
		}
	}*/

	public function adminDashboard() {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		return View("users.admin")
			->with('use_graph', true)
			->with('authUser', $authUser)
			->with('page_name', 'dashboard')
			->with('title', 'Welcome to the DigFilm adminstration system Dashboard');
	}

	public function usersDashboard() {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		return View("users.dashboard")
			->with('use_graph', true)
			->with('authUser', $authUser)
			->with('page_name', 'add-user')
			->with('title', 'Welcome to the DigFilm adminstration system Dashboard');
	}

/*	public function profile() {
		$authUser = Auth::user();
		if (!isset($authUser))
			return redirect('/auth/login');

		if ($authUser->hasRole("Customer")) {
			$current_domain = Session::get('current_domain');
			$sites = Session::get('available_domains');
		} else {
			$current_domain = null;
			$sites = array();
		}

		return View("users.profile")
			->with('sites', $sites)
			->with('authUser', $authUser)
			->with('instructions', 'Make sure you complete all of the required fields before submitting.')
			->with('page_name', 'profile')
			->with('title', 'Update your profile');
	}

*/	/**
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
			return Redirect::route('users.index');
		}
		return Redirect::route('users.index')->with('message', 'You don\'t have the permissions to complete this task.');
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
			return Redirect::route('users.index');
		}
		return Redirect::route('users.index')->with('message', 'You don\'t have the permissions to complete this task.');
	}

}
