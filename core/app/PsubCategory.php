<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PsubCategory extends Model
{

    protected $table = 'psubcategories';

    protected $fillable = ['name','category_id','language_id','status','slug'];

    public function category() {
        return $this->belongsTo('App\Pcategory','category_id','id');
    }

    public function productSubCategoryData() {
        return $this->hasMany('App\ProductSubCategoryData','sub_category_id','id');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
