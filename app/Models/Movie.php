<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Movie extends Model {

    //
    protected $fillable = array('name', 'summary', 'genres_id', 'rating', 'budget', 'enabled', 'release_at', 'availability', 'slug', 'opening_bid', 'meta_keywords', 'meta_description');

    public function contributors() {
        return $this->belongsToMany("\App\Models\Contributor", "movies_contributors", "movies_id", "contributors_id")->withPivot('contributor_types_id');
    }

    public function takings() {
        return $this->hasMany("\App\Models\MovieTaking", 'movies_id', 'id');
    }

    public function media() {
        return $this->hasMany("\App\Models\MovieMedia", 'movies_id', 'id');
    }

    public function leagues() {
        return $this->belongsToMany("\App\Models\League", "league_movies", "movies_id", "leagues_id");
    }

    public function firstImage() {
        return $this->media->where('type' ,'I')->first();
    }

    public function topTrailer() {
        return $this->media->where('type' ,'T')->where('image_type', 'F')->first();
    }

    public function topMedia($media_type = 'I') {
        return $this->media->where('type', $media_type)->where('image_type', 'F')->first();
    }

    public function topImage($type = 'F') {
        return $this->media->where('type', 'I')->where('image_type', $type)->first();
    }

    public function images() {
        return $this->media->where('type', 'I');
    }

    public function genre() {
        return $this->belongsTo("\App\Models\Genre", 'genres_id');
    }

    public function ratings() {
        return $this->hasMany("\App\Models\MovieRating", 'movies_id', 'id');
    }

    public function bids() {
        return $this->hasMany("\App\Models\AuctionBid", 'movies_id', 'id');
    }

    public function topBid() {
        $sql = "SELECT max(bid_amount) top_bid FROM auctions WHERE movies_id = '".$this->id."' AND ready_for_auction > 2";
        $topBid = DB::select(DB::Raw($sql));
        return $topBid[0]->top_bid;
        //return $this->bids->max('bid_amount');
    }

    public function link() {
        return ((!is_null($this->slug) && trim($this->slug) != "") ? $this->slug : $this->id);
    }

    public function averageBid() {
//        return $this->bids()->avg('bid_amount');
        $sql = "SELECT avg(bid_amount) avg_bid FROM auctions WHERE movies_id = '".$this->id."' AND ready_for_auction > 2";
        $avgBid = DB::select(DB::Raw($sql));
        return $avgBid[0]->avg_bid;//$this->bids->min('bid_amount');
    }

    public function lowestBid() {
        $sql = "SELECT min(bid_amount) min_bid FROM auctions WHERE movies_id = '".$this->id."' AND ready_for_auction > 2";
        $lowestBid = DB::select(DB::Raw($sql));
        return $lowestBid[0]->min_bid;//$this->bids->min('bid_amount');
    }

    public function daysInBO($till = true) {
        $release = new \DateTime($this->release_at);
        $now = new \DateTime();

        if ($till == true && $release > $now) 
            return false;

        $interval = $release->diff($now);
        $daysInBO = $interval->m.(($interval->m > 1) ? " months, " : " month, ").$interval->d.(($interval->d > 1) ? " days " : " day"); 

        return $daysInBO;
    }
}
