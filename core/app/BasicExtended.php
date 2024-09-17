<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicExtended extends Model
{
    protected $table = 'basic_settings_extended';
    public $timestamps = false;

    const MAIL_DRIVER_SMTP = 1;
    const MAIL_DRIVER_MAIL = 2;
    const MAIL_DRIVER_IS_SEND_MAIL = 3;
    public function language() {
        return $this->belongsTo('App\Language');
    }
}
