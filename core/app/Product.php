<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'language_id',
        'stock',
        'sku',
        'category_id',
        'tags',
        'feature_image',
        'summary',
        'description',
        'current_price',
        'previous_price',
        'rating',
        'status',
        'meta_keywords',
        'meta_description',
        'is_featured',
        'call_for_price',
        'phone_number',
        'product_template_id'
    ];

    public function category() {
        return $this->hasOne('App\Pcategory','id','category_id');
    }

    public function product_images() {
        return $this->hasMany('App\ProductImage');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }

    public function productDataType() {
        return $this->hasMany('App\ProductTypeData','product_id','id');
    }

    public function productSubCategoryData() {
        return $this->hasMany('App\ProductSubCategoryData','product_id','id');
    }

    public function productTemplate() {
        return $this->belongsTo('App\ProductTemplate','product_template_id','id');
    }

}
