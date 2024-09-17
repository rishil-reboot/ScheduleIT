<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormBuilderToMail extends Model
{

    protected $table = 'form_builders_to_mail';
    
    public function user(){

        return $this->belongsTo('\App\Admin','user_id','id');
    }    
}
