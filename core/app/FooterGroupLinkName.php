<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterGroupLinkName extends Model
{
    
    protected $table = 'footer_group_link_name';
    
    public function ulink() {

      return $this->hasMany('App\Ulink','footer_group_link_name_id','id');
    }

}
