<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use DB;
use Illuminate\Support\Facades\Mail;

class BuyCreditController extends Controller {
    
    protected $auth;
    
    public function __construct() {
        
        $this->basicSetting = \App\BasicSetting::first();
        $this->auth = \Auth::user();
    }

    public function index() {
            
        return view('front.booking.buy_credit.credit');
    }

}