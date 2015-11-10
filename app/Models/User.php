<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
	use EntrustUserTrait; // add this trait to your user model

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'forenames', 'surname', 'thumbnail', 'enabled'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function role() {
		return $this->belongsToMany("\App\Models\Role", "role_user");
	}

	public function leagues() {
		return $this->hasMany("\App\Models\League", "users_id")->where('enabled', '1');
	}

	public function inLeagues() {
		return $this->belongsToMany("\App\Models\League", "league_users", "user_id", "league_id")->withPivot('id');
	}

	public function auctions() {
		return $this->belongsToMany("\App\Models\Movie", "auctions", "users_id", "movies_id")->withPivot(['bid_amount', 'auction_start_time', 'auction_end_time', 'users_id', 'id', 'ready_for_auction']);
	}

	public function fullName() {
		return (is_null($this->forenames) ? $this->name : $this->forenames." ".$this->surname);
	}
}
