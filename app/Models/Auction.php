<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model {

    //
    protected $table = 'auctions';
    protected $fillable = array('leagues_id', 'users_id', 'movies_id', 'bid_amount', 'auction_start_time', 'auction_end_time', 'ready_for_auction', 'initial_bid');

    public function movie() {
        return $this->belongsTo("\App\Models\Movie", "movies_id");
    }

    public function league() {
        return $this->belongsTo("\App\Models\League", "leagues_id");
    }
}