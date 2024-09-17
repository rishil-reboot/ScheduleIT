<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ulink extends Model
{
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }

    public function footerGroupName() {
        return $this->belongsTo('App\FooterGroupLinkName','footer_group_link_name_id','id');
    }
}
