<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcategory extends Model
{
    protected $fillable = ['name','language_id','status','slug'];

    public function products() {
        return $this->hasMany('App\Product','category_id','id');
    }

    /**
     * This function is used to get sub category details
     * @author Chirag Ghevariya
     */
    public function subcategory() {
        return $this->hasMany('App\PsubCategory','category_id','id');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
