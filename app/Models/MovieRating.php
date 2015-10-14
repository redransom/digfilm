<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieRating extends Model {

    //
    protected $table = 'movie_ratings';
    protected $fillable = array('movies_id', 'ratings_id');
/*
    public static function clearBalances($id) {
        $this->where('leagues_id', $id)->update(['balance'=>100]);
    }*/
}
