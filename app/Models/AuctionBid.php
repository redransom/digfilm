<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model {

    //
    protected $table = 'auction_bids';
    protected $fillable = array('auctions_id', 'users_id', 'bid_amount', 'movies_id');

    public function auction() {
        return $this->belongsTo("\App\Models\Auction", "auctions_id");
    }
}