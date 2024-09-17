<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingServiceAdminUser extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_service_admin_users';

    public function admin() {
        
        return $this->belongsTo('App\Admin','admin_id','id');
    }
    
    public function bookingService() {

        return $this->belongsTo('App\BookingService','booking_service_id','id');
    }
}



