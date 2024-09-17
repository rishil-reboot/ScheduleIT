<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_types';

    public function productTypeData(){

        return $this->hasMany('App\ProductTypeData','product_type_id','id');
    }
}
