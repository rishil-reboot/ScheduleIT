<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingSchedule extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'schedule';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['service_id', 'week_number', 'start_time', 'end_time'];

    public function service() {
        return $this->belongsTo('App\BookingService');
    }

}
