<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerProduct extends Model
{
    protected $table = 'partner_products';

    /**
     * This function is used to get product data
     * @author Chirag Ghevariya
     */
    public function product() {

        return $this->belongsTo('App\Product','product_id','id');
    }

    /**
     * This function is used to get partner data
     * @author Chirag Ghevariya
     */
    public function partner() {

        return $this->belongsTo('App\Partner','id','partner_id');
    }
}
