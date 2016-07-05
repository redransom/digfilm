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

    public function reviews() {
        return $this->hasMany("\App\Models\SiteContent", "movies_id", "id")->where('type', 'M');
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
    }

    public function link() {
        return ((!is_null($this->slug) && trim($this->slug) != "") ? $this->slug : $this->id);
    }

    public function averageBid() {
        $sql = "SELECT avg(bid_amount) avg_bid FROM auctions WHERE movies_id = '".$this->id."' AND ready_for_auction > 2";
        $avgBid = DB::select(DB::Raw($sql));
        return $avgBid[0]->avg_bid;
    }

    public function lowestBid() {
        $sql = "SELECT min(bid_amount) min_bid FROM auctions WHERE movies_id = '".$this->id."' AND ready_for_auction > 2";
        $lowestBid = DB::select(DB::Raw($sql));
        return $lowestBid[0]->min_bid;
    }

    /*
     * daysInterval between the dates in this movie
     * RA = release_at
     * TC = takings_close_date
    */
    public function daysInterval($till = true, $type = 'RA') {
        if ($type == 'RA')
            $compare = new \DateTime($this->release_at);
        elseif ($type == 'TC' && !is_null($this->takings_close_date))
            $compare = new \DateTime($this->takings_close_date);
        else
            return false;
        $now = new \DateTime();

        if ($till == true && $compare > $now) 
            return false;

        $interval = $compare->diff($now);
        $daysInterval = "";
        if($interval->m > 1)
            $daysInterval = $interval->m." months, ";
        elseif($interval->m == 1)
            $daysInterval = $interval->m." month, ";

        $daysInterval .= $interval->d.(($interval->d > 1) ? " days " : " day"); 

        return $daysInterval;
    }
}
