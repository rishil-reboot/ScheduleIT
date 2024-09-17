<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategoryData extends Model
{

    protected $table = 'product_subcategory_data';

    public function category() {
        return $this->belongsTo('App\Pcategory','category_id','id');
    }

    public function subCategory() {
        return $this->belongsTo('App\PsubCategory','sub_category_id','id');
    }

    public function product() {
        return $this->belongsTo('App\Product','product_id','id');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
