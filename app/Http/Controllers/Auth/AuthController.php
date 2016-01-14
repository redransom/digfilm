<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Mail;
use Input;
use Flash;
use Redirect;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/
	protected $redirectPath = '/dashboard';
	protected $loginPath = '/dashboard';
	use AuthenticatesAndRegistersUsers;

	/**
	 * Override the trait function to handle players and admin
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function getLogin() {
		return view('auth.login')->with('login', true);
	}
	
	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getRegister() {
		return view('auth.register')->with('login', true);
	}

	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');
		$credentials['enabled'] = '1';

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			$authUser = $this->auth->user();

			$role_users = \App\Models\RoleUser::where('user_id', $authUser->id)->get();

			foreach ($role_users as $ru) {
				$role = Role::where('id', $ru->role_id)->first();
				$roles[] = $role->name;
			}

			if (in_array("Admin", $roles))
				return redirect()->intended('admin-dashboard');
			else
				return redirect()->intended('dashboard');
		}

		return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => $this->getFailedLoginMessage(),
					]);
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->auth->login($this->registrar->create($request->all()));

		$user = $this->auth->user();

		/* add confirmation code for the email */
		$confirmation_code = str_random(30);
		$user->confirmation_code = $confirmation_code;
		$user->save();

		$role = \App\Models\Role::where('name', 'Player')->first();
		$roleUser = new \App\Models\RoleUser();
		$roleUser->user_id = $user->id;
		$roleUser->role_id = $role->id;
		$roleUser->save(['timestamps' => false]);		

		$data = ['confirmation_code'=>$confirmation_code, 
				'user'=>$user,
				'subject'=>'Verify Your Email Address'];

		Mail::send('emails.verify', $data, function($message) {
            $message->to(Input::get('email'), Input::get('username'))
                ->subject('Verify your email address');
        });

		Flash::success('Thanks for signing up! Please check your email.');

		return Redirect::route('register-successful');
		//return redirect($this->redirectPath());
	}
}
