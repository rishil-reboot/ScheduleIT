<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTypeData extends Model
{
    protected $table = 'product_type_data';

    /**
     * This function is used to get product data
     * @author Chirag Ghevariya
     */
    public function product() {

        return $this->belongsTo('App\Product','product_id','id');
    }

    /**
     * This function is used to get product type data
     * @author Chirag Ghevariya
     */
    public function productType() {

        return $this->belongsTo('App\ProductType','id','product_type_id');
    }
}
