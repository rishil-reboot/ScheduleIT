<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingPaymentSetting extends Model
{
   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['currency_id', 'price'];
    
    public function currency() {
        return $this->belongsTo('App\BookingCurrency');
    }
}
