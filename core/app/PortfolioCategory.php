<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioCategory extends Model
{   

    protected $table = 'pcategories';

    public $timestamps = false;

    public function portfolio() {

      return $this->hasMany('App\Portfolio','category_id','id');
    }

    public function myPortfolioCategory(){

      return $this->hasMany('App\MyPortfolioCategory','category_id','id');
    }
}
