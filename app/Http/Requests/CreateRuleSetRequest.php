<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateRuleSetRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'name' => ['required'],
            'min_players' => ['required'],
            'max_players' => ['required'],
            'min_movies' => ['required'],
            'max_movies' => ['required'],
            'auction_duration' => ['required'],
            'min_bid' => ['required'],
            'max_bid' => ['required'],
            'league_type' => ['required']
        ];
	}

}
