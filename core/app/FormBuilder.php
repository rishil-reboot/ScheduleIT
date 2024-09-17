<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{

    const CONTACT_CONSTANT = 10;
    
    public function language() {
        return $this->belongsTo('App\Language');
    }

    public function formBuilderToEmail(){

        return $this->hasMany('App\FormBuilderToMail','form_builder_id','id');
    }
    
}
