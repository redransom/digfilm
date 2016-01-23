<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model {

    //
    protected $table = 'site_content';
    protected $fillable = array('section', 'type', 'title', 'summary', 'body', 'thumbnail', 'main_image', 'owners_id');

    public function owner() {
        return $this->belongsTo("\App\Models\User", "owners_id");
    }


}
