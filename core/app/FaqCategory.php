<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    
    protected $table = "faq_categories";

    public $timestamps = false;

    public function customerFaq() {

      return $this->hasMany('App\CustomerFaq','faq_category_id','id');
    }

    public function faq() {

      return $this->hasMany('App\Faq','faq_category_id','id');
    }

    public function language() {
    
        return $this->belongsTo('App\Language');

    }
}
