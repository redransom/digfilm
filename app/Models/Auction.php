<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model {

    //
    protected $table = 'auctions';
    protected $fillable = array('leagues_id', 'users_id', 'movies_id', 'bid_amount', 'auction_start_time', 'auction_end_time', 'ready_for_auction');

    //TODO: Has many movies..
/*    public function movies() {
        return $this->hasMany("\App\Models\Movie", 'genres_id', 'id');
    }

    public function movie_count() {
        return $this->movies()->count();
    }
*/
}