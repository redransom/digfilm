<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieTaking extends Model {

    //
    protected $fillable = array('amount', 'country', 'takings_at', 'movies_id');

    /*
     * List of movies in next 7 days that are due to have takings entered
     * * Need to get films that release at has passed and takings close date hasn't occured
     */
    public static function dueTakings() {
    	$movies = Movie::whereRaw('release_at < now()')->whereRaw('takings_close_date > now()')->get();

    	$missing_takings = array();
    	foreach ($movies as $movie) {
    		//get each movie and work out their takings 
    		$takings_start_date = $movie->release_at;
    		$takings_close_date = $movie->takings_close_date;
    		$takings_freq = $movie->takings_frequency;

    		if ($takings_freq == 'W') {
    			//weekly takings - add 7 to date
    			$takings_date = $takings_start_date;
    			$takings_dates = array();
    			while ($takings_date < date("Y-m-d")) {
    				/*
					date_add($round_date, date_interval_create_from_date_string(intval($round_duration).' hours'));
                	$league->round_start_date = date_format($round_date, 'Y-m-d H:i:s');
    				*/
    				$test_date = date_add(date_create($takings_date), date_interval_create_from_date_string('7 days'));
    				$takings_date = date_format($test_date, 'Y-m-d');
    				$takings = $movie->takings()->where('takings_at', $takings_date)->get();
    				if ($takings->isEmpty()) {
    					//need to record this
    					$takings_dates[] = date("d M Y", strtotime($takings_date));
    				}
    			}

    			if (!empty($takings_dates))
    				$missing_takings[$movie->id] = $takings_dates;
    		}
    	}
    	return $missing_takings;
    }
}
