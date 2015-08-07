<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieContributor extends Model {

    //
    protected $table = 'movies_contributors';
    protected $fillable = array('movies_id', 'contributors_id', 'star', 'contributor_types_id');
}
