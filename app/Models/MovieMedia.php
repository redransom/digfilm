<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieMedia extends Model {

    //
    protected $fillable = array('name', 'file_name', 'movies_id', 'description', 'type', 'url',  'image_type');

    public function movie() {
        return $this->belongsTo("\App\Models\Movie", "movies_id");
    }

    public function path() {
        if ($this->file_name != '')
            return $this->file_name;
        else
            return $this->url;
    }
}
