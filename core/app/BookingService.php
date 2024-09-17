<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingService extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_services';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'price', 'duration', 'max_spot_limit', 'close_booking_before_time','start_date', 'end_date', 'start_time', 'end_time', 'service_type', 'status'];

    public function scopeActive($query) {
        
        return $query->whereStatus('1');
    }
    
    public function schedule() {
        
        return $this->hasMany('App\BookingSchedule','service_id','id');
    }
    
    public function booking() {

        return $this->hasMany('App\Booking','service_id','id');
    }

    public function bookingServiceUser() {

        return $this->hasMany('App\BookingServiceAdminUser','booking_service_id','id');
    }
}



