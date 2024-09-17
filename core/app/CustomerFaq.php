<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerFaq extends Model
{
    
    protected $table = "customer_faqs";
    
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }

    public function faqCategory(){

        return $this->belongsTo('App\FaqCategory','faq_category_id','id');
    }

}
