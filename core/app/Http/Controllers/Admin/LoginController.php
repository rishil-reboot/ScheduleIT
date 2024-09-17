<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\BasicExtra;
use App\Language;

class LoginController extends Controller
{ 

    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();

        // Config::set('captcha.sitekey', \Crypt::decryptString($bs->google_recaptcha_site_key));
        // Config::set('captcha.secret', \Crypt::decryptString($bs->google_recaptcha_secret_key));
    }

    public function login(){
      return view('admin.login');
    }

    public function authenticate(Request $request){
      // return $request->username . ' ' . $request->password;

      //--- Validation Section
      if (session()->has('lang')) {
          $currentLang = Language::where('code', session()->get('lang'))->first();
      } else {
          $currentLang = Language::where('is_default', 1)->first();
      }

      $bs = $currentLang->basic_setting;
      $be = $currentLang->basic_extended;

      $rules = [
          'username'   => 'required',
          'password' => 'required'
      ];

      if ($bs->is_recaptcha == 1) {
          $rules['g-recaptcha-response'] = 'required|captcha';
      }
      $messages = [
          'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
          'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
      ];

      $this->validate($request, [
        'username'   => 'required',
        'password' => 'required'
      ]);

      $request->validate($rules, $messages);
      if (Auth::guard('admin')->attempt(['username' => $request->username,'password' => $request->password]))
      {
          return redirect()->route('admin.dashboard');
      }
      return redirect()->back()->with('alert','Username and Password Not Matched');
    }

    public function logout() {
      Auth::guard('admin')->logout();
      return redirect()->route('admin.login');
    }
}
