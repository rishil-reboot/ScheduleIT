<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public $timestamps = false;

    public function language() {
        return $this->belongsTo('App\Language');
    }

    /**
     * This function is used to get all partner product data
     * @author Chirag Ghevariya
     */
    public function partnerProduct() {

        return $this->hasMany('App\PartnerProduct','partner_id','id');
    }
}
