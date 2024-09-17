<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingCurrency extends Model
{
   
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'status'];
    
    public function scopeActive($query) {
        return $query->whereStatus('1');
    }
    
    public function paymentSetting() {
        return $this->hasOne('App\BookingPaymentSetting');
    }
}
