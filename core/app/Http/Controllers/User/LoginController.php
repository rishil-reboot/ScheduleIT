<?php

namespace App\Http\Controllers\User;

use Auth;
use Config;
use Session;
use App\User;
use App\Language;
use App\BasicExtra;
use App\TwilioCredit;
use Twilio\Rest\Client;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\PublicKeyLoader;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
        $bs = BS::first();
        $be = BE::first();
        $bex = BasicExtra::first();
        // Config::set('captcha.sitekey', \Crypt::decryptString($bs->google_recaptcha_site_key));
        // Config::set('captcha.secret', \Crypt::decryptString($bs->google_recaptcha_secret_key));
    }

    public function showLoginForm()
    {
        $bex = BasicExtra::first();
        if ($bex->is_user_panel == 0) {
            return back();
        }

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $url = url()->previous();
        $url = (explode('/', $url));
        if (in_array('checkout', $url)) {
            session(['link' => url()->previous()]);
        }

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }
        $data['terms_and_conditions'] = \App\Page::find(\App\Page::TERMS_AND_CONDITIONS);
        $data['version'] = $version;
        if($version=='apper-theme')
        {
            return view('front.apper-theme.login', $data);
        }
        return view('front.login', $data);
    }

    public function login(Request $request)
    {
        if (Session::has('link')) {
            $redirectUrl = Session::get('link');
            Session::forget('link');
        } else {
            $redirectUrl = route('user-dashboard');
        }

        //--- Validation Section
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $rules = [
            'email'   => 'required|email',
            'password' => 'required'
        ];

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];
        $request->validate($rules, $messages);
        //--- Validation Section Ends

        // Attempt to log the user in
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // if successful, then redirect to their intended location

            // Check If Email is verified or not
            if (Auth::guard('web')->user()->email_verified == 'no' || Auth::guard('web')->user()->email_verified == 'No') {
                Auth::guard('web')->logout();

                return back()->with('err', __('Your Email is not Verified!'));
            }
            if (Auth::guard('web')->user()->status == '0') {
                Auth::guard('web')->logout();

                return back()->with('err', __('Your account has been banned'));
            }

            $user = Auth::user();

            if (!isset($user->loginSecurity) && $user->loginSecurity == null) {

                // Initialise the 2FA class
                $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

                // Add the secret key to the registration data
                $login_security = \App\LoginSecurity::firstOrNew(array('user_id' => $user->id));
                $login_security->user_id = $user->id;
                $login_security->google2fa_enable = 0;
                $login_security->google2fa_secret = $google2fa->generateSecretKey();
                $login_security->save();

                return redirect($redirectUrl);
            } else {

                if ($user->loginSecurity->google2fa_enable == 1) {

                    \Session::put('loginUserId', $user->id);
                    Auth::guard('web')->logout();
                    return redirect()->route('user.login.verifyOtp');
                }
            }
            // OTP Login Section
            if ($be->is_twilio == 1) {
                $otpCode = random_int(100000, 999999);
                $privateKey = RSA::createKey(2048);
                $publicKey = $privateKey->getPublicKey();
                $encryptedOtp = $publicKey->encrypt($otpCode);
                $user->update(['verification_code' => base64_encode($encryptedOtp)]);
                $this->sendOtp($user->number, $otpCode);
                session(['privateKey' => $privateKey->toString('PKCS8'), 'phoneNumber' => $user->number]);
                Auth::guard('web')->logout();
                return redirect()->route('user.login.verifyOtp');
            }

            return redirect($redirectUrl);
        }
        // if unsuccessful, then redirect back to the login with the form data
        return back()->with('err', __("Credentials Doesn\'t Match !"));
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
    public function resendOtp()
    {
        if (\Session::has('phoneNumber')) {
            $phoneNumber = session('phoneNumber');
            $user = User::where('number', $phoneNumber)->first();
            $otpCode = random_int(100000, 999999);
            $privateKey = RSA::createKey(2048);
            $publicKey = $privateKey->getPublicKey();
            $encryptedOtp = $publicKey->encrypt($otpCode);
            $user->update(['verification_code' => base64_encode($encryptedOtp)]);
            $this->sendOtp($user->number, $otpCode);
            session(['privateKey' => $privateKey->toString('PKCS8'), 'phoneNumber' => $user->number]);
            return redirect()->back()->with('success', 'OTP sent successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to Send code');
        }
    }
    private function sendOtp($phoneNumber, $otp)
    {
        $credit = TwilioCredit::first();
        $client = new Client($credit->account_sid, $credit->auth_token);

        $client->messages->create(
            $phoneNumber,
            [
                'from' => $credit->phone_number,
                // 'body' => "Your OTP code is: $otp",
            ]
        );
    }
    public function verifyOtp()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        return view('front.verify-login-otp', $data);
    }

    public function verifyAndLogin(Request $request)
    {
        if (Session::has('link')) {
            $redirectUrl = Session::get('link');
            Session::forget('link');
        } else {
            $redirectUrl = route('user-dashboard');
        }

        //--- Validation Section
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $rules = [
            'otp'   => 'required',
        ];

        $messages = [
            'otp.required' => 'One time password is required.',
        ];
        $request->validate($rules, $messages);
        //--- Validation Section Ends

        if (\Session::has('loginUserId')) {

            $user = \App\User::where('id', \Session::get('loginUserId'))->first();

            if ($user != null) {

                $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

                $secret = $request->input('otp');
                $valid = $google2fa->verifyKey($user->loginSecurity->google2fa_secret, $secret);

                if ($valid) {

                    \Auth::login($user);
                    \Session::forget('loginUserId');
                    return redirect($redirectUrl);
                } else {

                    return redirect()->back()->with('err', "Invalid verification Code, Please try again.");
                }
            }
        }
        if (\Session::has('phoneNumber')) {
            $phoneNumber = session('phoneNumber');
            $privateKeyString = session('privateKey');

            if (!$phoneNumber || !$privateKeyString) {
                return redirect()->back()->with('error', 'Session expired or invalid.');
            }

            $user = User::where('number', $phoneNumber)->first();

            if ($user) {
                try {
                    $encryptedOtp = base64_decode($user->verification_code);

                    $privateKey = PublicKeyLoader::loadPrivateKey($privateKeyString);

                    $storedOtp = $privateKey->decrypt($encryptedOtp);

                    if ($request->input('otp') == $storedOtp) {
                        $user->update(['verification_code' => null]);

                        session()->forget(['privateKey', 'phoneNumber']);

                        Auth::login($user);

                        return redirect()->route('user-dashboard')->with('success', 'OTP verified successfully');
                    } else {
                        return redirect()->back()->with('error', 'Invalid OTP code');
                    }
                } catch (\Exception $e) {
                    Log::error('Decryption error', ['message' => $e->getMessage()]);
                    return redirect()->back()->with('error', 'Decryption error');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid OTP code');
            }
        }
        \Session::forget('phoneNumber');
        \Session::forget('loginUserId');

        return redirect()->route('user.login')->with('err', "Something want wrong.");
    }

    public function showOtpLoginForm()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;

        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }
        $data['otpCode'] = session('otpCode');
        $data['phoneNumber'] = session('phoneNumber');
        $data['version'] = $version;
        if($version=='apper-theme')
        {
            return view('front.theme.login_with_otp', $data);
        }
        return view('front.login_with_otp', $data);
    }

    public function sendOtpTwilio(Request $request)
    {
        $request->validate([
            'number' => 'required|regex:/^\+?[1-9]\d{1,14}$/',
        ]);

        $user = User::where('number', $request->number)->first();

        if ($user) {
            $otpCode = random_int(100000, 999999);

            $privateKey = RSA::createKey(2048);
            $publicKey = $privateKey->getPublicKey();

            $encryptedOtp = $publicKey->encrypt($otpCode);

            $user->update(['verification_code' => base64_encode($encryptedOtp)]);

            try {
                $credit = TwilioCredit::first();
                $client = new Client($credit->account_sid, $credit->auth_token);

                $client->messages->create(
                    $request->input('number'),
                    [
                        'from' => $credit->phone_number,
                        'body' => "Your OTP code is: $otpCode",
                    ]
                );

                session(['privateKey' => $privateKey->toString('PKCS8'), 'phoneNumber' => $request->input('number')]);

                return redirect()->back()->with('success', 'OTP sent successfully');
            } catch (\Exception $e) {
                Log::error('Twilio message sending error', ['message' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Failed to send OTP. Please try again.');
            }
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
    }


    public function verifyMOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $phoneNumber = session('phoneNumber');
        $privateKeyString = session('privateKey');

        if (!$phoneNumber || !$privateKeyString) {
            return redirect()->back()->with('error', 'Session expired or invalid.');
        }

        $user = User::where('number', $phoneNumber)->first();

        if ($user) {
            try {
                $encryptedOtp = base64_decode($user->verification_code);

                $privateKey = PublicKeyLoader::loadPrivateKey($privateKeyString);

                $storedOtp = $privateKey->decrypt($encryptedOtp);

                if ($request->input('otp') == $storedOtp) {
                    $user->update(['verification_code' => null]);

                    session()->forget(['privateKey', 'phoneNumber']);

                    Auth::login($user);

                    return redirect()->route('user-dashboard')->with('success', 'OTP verified successfully');
                } else {
                    return redirect()->back()->with('error', 'Invalid OTP code');
                }
            } catch (\Exception $e) {
                Log::error('Decryption error', ['message' => $e->getMessage()]);
                return redirect()->back()->with('error', 'Decryption error');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid OTP code');
        }
    }
}
