<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = 'email_template';
        
    const TEST_MAIL_CONST = 1;
    const WELCOME_MAIL_TO_USER = 2;
    const RESET_PASSWORD_REQUEST = 3;
    const CONTACT_US_INQUIRY = 4;
    const FORM_BUILDER_COMMON = 5;
    const REQUEST_QUOTA = 6;
    const PACKAGE_ORDER_FOR_ADMIN = 7;
    const PACKAGE_ORDER_FOR_BUYER = 8;
    const PRODUCT_ORDER_FOR_BUYER = 9;
    const ORDER_STATUS_UPDATED_MAIL_TO_BUYER = 10;
         
    public function language() {
        return $this->belongsTo('App\Language');
    }
}
