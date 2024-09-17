<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use DB;

class VerifyLicenseInstaller extends Controller {
        
    public function __construct() {
        
        $this->basicSetting = \App\BasicSetting::first();
    }

    public function license(Request $request){

        return view('vendor.license.install');  
    }

}    