<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use Validator;
use Session;

class QrcodeController extends Controller
{
    public function qrCodeGenerator(Request $request)
    {
        return view('admin.qr-code.index');
    }

    public function saveQrCodeGenerator(Request $request){

        $input = $request->all();

        $messages = [
            'language_id.required' => 'The language field is required',
        ];

        $rules = [
            'qrdata_type' => 'required',
            'height' => 'required|numeric',
            'scale' => 'required|numeric',
            'bgcolor' => 'required',
            'color' => 'required',
            'type' => 'required',
            'file' => 'required|string',

            
        ];

        if ($input['qrdata_type'] == 'text') {

            $rules['qr_bulk_text'] = 'required';

        }else if($input['qrdata_type'] == 'link'){

            $rules['qr_link'] = 'required|url';

        }else if($input['qrdata_type'] == 'sms'){

            $rules['qr_sms_phone'] = 'required';
            $rules['qr_sms_msg'] = 'required';

        }else if($input['qrdata_type'] == 'email'){

            $rules['qr_email_add'] = 'required|email';
            $rules['qr_email_sub'] = 'required';
            $rules['qr_email_msg'] = 'required';

        }else if($input['qrdata_type'] == 'phone'){

            $rules['qr_phone_phone'] = 'required';

        }else if($input['qrdata_type'] == 'vcard'){

            $rules['qr_vc_name'] = 'required';
            $rules['qr_vc_company'] = 'required';
            $rules['qr_vc_job'] = 'required';
            $rules['qr_vc_work_phone'] = 'required';
            $rules['qr_vc_home_phone'] = 'required';
            $rules['qr_vc_home_address'] = 'required';
            $rules['qr_vc_home_city'] = 'required';
            $rules['qr_vc_home_postcode'] = 'required';
            $rules['qr_vc_home_country'] = 'required';
            $rules['qr_vc_email'] = 'required|email';
            $rules['qr_vc_url'] = 'required|url';

        }else if($input['qrdata_type'] == 'mecard'){

            $rules['qr_mec_name'] = 'required';
            $rules['qr_mec_phone'] = 'required';
            $rules['qr_mec_email'] = 'required';
            $rules['qr_mec_url'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            
            return response()->json($validator->errors(),422);
        }

        $bgColorCode = sscanf($input['bgcolor'], "#%02x%02x%02x");
        $colorCode = sscanf($input['color'], "#%02x%02x%02x");

        $data = "";

        if (env('IS_LOCAL_OR_LIVE') == 'local') {
            

            if ($input['qrdata_type'] == 'text') {

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            // ->format($input['type'])
                            ->encoding('UTF-8')
                            ->generate($input['qr_bulk_text']);

            }else if($input['qrdata_type'] == 'link'){

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            // ->format($input['type'])
                            ->encoding('UTF-8')
                            ->generate($input['qr_link']);

            }else if($input['qrdata_type'] == 'sms'){

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            // ->format($input['type'])
                            ->encoding('UTF-8')
                            ->SMS($input['qr_sms_phone'],$input['qr_sms_msg']);

            }else if($input['qrdata_type'] == 'email'){

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            // ->format($input['type'])
                            ->encoding('UTF-8')
                            ->email($input['qr_email_add'], $input['qr_email_sub'], $input['qr_email_msg']);

            }else if($input['qrdata_type'] == 'phone'){

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            // ->format($input['type'])
                            ->encoding('UTF-8')
                            ->phoneNumber($input['qr_phone_phone']);
                            

            }else if($input['qrdata_type'] == 'vcard'){

                $rules['qr_vc_name'] = 'required';
                $rules['qr_vc_company'] = 'required';
                $rules['qr_vc_job'] = 'required';
                $rules['qr_vc_work_phone'] = 'required';
                $rules['qr_vc_home_phone'] = 'required';
                $rules['qr_vc_home_address'] = 'required';
                $rules['qr_vc_home_city'] = 'required';
                $rules['qr_vc_home_postcode'] = 'required';
                $rules['qr_vc_home_country'] = 'required';
                $rules['qr_vc_email'] = 'required';
                $rules['qr_vc_url'] = 'required';


                $vcard = "BEGIN:VCARD
                    VERSION:3.0
                    N:".$input['qr_vc_name']."
                    FN:".$input['qr_vc_name']."
                    ORG:".$input['qr_vc_company']."
                    TITLE:".$input['qr_vc_job']."
                    TEL;TYPE=WORK,VOICE:".$input['qr_vc_work_phone']."
                    TEL;TYPE=HOME,VOICE:".$input['qr_vc_home_phone']."
                    ADR;TYPE=HOME:;;".$input['qr_vc_home_address'].";".$input['qr_vc_home_city'].";;".$input['qr_vc_home_postcode'].";".$input['qr_vc_home_country']."
                    LABEL;TYPE=WORK:".$input['qr_vc_home_address']."\n".$input['qr_vc_home_city'].", ".$input['qr_vc_home_postcode']."\n".$input['qr_vc_home_country']."
                    EMAIL;TYPE=PREF,INTERNET:".$input['qr_vc_email']."
                    URL:".$input['qr_vc_url']."
                    END:VCARD
                    ";


                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            // ->format($input['type'])
                            ->encoding('UTF-8')
                            ->generate($vcard);

            }else if($input['qrdata_type'] == 'mecard'){

                $rules['qr_mec_name'] = 'required';
                $rules['qr_mec_phone'] = 'required';
                $rules['qr_mec_email'] = 'required';
                $rules['qr_mec_url'] = 'required';

                $fullMcard = 'Name:'.$input['qr_mec_name'].';URL:'.$input['qr_mec_url'].';TEL:'.$input['qr_mec_phone'].';EMAIL:'.$input['qr_mec_email'];

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            // ->format($input['type'])
                            ->encoding('UTF-8')
                            ->generate($fullMcard);
            }

        }else{

            if ($input['qrdata_type'] == 'text') {

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            ->format($input['type'])
                            ->encoding('UTF-8')
                            ->generate($input['qr_bulk_text']);

            }else if($input['qrdata_type'] == 'link'){

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            ->format($input['type'])
                            ->encoding('UTF-8')
                            ->generate($input['qr_link']);

            }else if($input['qrdata_type'] == 'sms'){

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            ->format($input['type'])
                            ->encoding('UTF-8')
                            ->SMS($input['qr_sms_phone'],$input['qr_sms_msg']);

            }else if($input['qrdata_type'] == 'email'){

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            ->format($input['type'])
                            ->encoding('UTF-8')
                            ->email($input['qr_email_add'], $input['qr_email_sub'], $input['qr_email_msg']);

            }else if($input['qrdata_type'] == 'phone'){

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            ->format($input['type'])
                            ->encoding('UTF-8')
                            ->phoneNumber($input['qr_phone_phone']);
                            

            }else if($input['qrdata_type'] == 'vcard'){

                $rules['qr_vc_name'] = 'required';
                $rules['qr_vc_company'] = 'required';
                $rules['qr_vc_job'] = 'required';
                $rules['qr_vc_work_phone'] = 'required';
                $rules['qr_vc_home_phone'] = 'required';
                $rules['qr_vc_home_address'] = 'required';
                $rules['qr_vc_home_city'] = 'required';
                $rules['qr_vc_home_postcode'] = 'required';
                $rules['qr_vc_home_country'] = 'required';
                $rules['qr_vc_email'] = 'required';
                $rules['qr_vc_url'] = 'required';


                $vcard = "BEGIN:VCARD
                    VERSION:3.0
                    N:".$input['qr_vc_name']."
                    FN:".$input['qr_vc_name']."
                    ORG:".$input['qr_vc_company']."
                    TITLE:".$input['qr_vc_job']."
                    TEL;TYPE=WORK,VOICE:".$input['qr_vc_work_phone']."
                    TEL;TYPE=HOME,VOICE:".$input['qr_vc_home_phone']."
                    ADR;TYPE=HOME:;;".$input['qr_vc_home_address'].";".$input['qr_vc_home_city'].";;".$input['qr_vc_home_postcode'].";".$input['qr_vc_home_country']."
                    LABEL;TYPE=WORK:".$input['qr_vc_home_address']."\n".$input['qr_vc_home_city'].", ".$input['qr_vc_home_postcode']."\n".$input['qr_vc_home_country']."
                    EMAIL;TYPE=PREF,INTERNET:".$input['qr_vc_email']."
                    URL:".$input['qr_vc_url']."
                    END:VCARD
                    ";


                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            ->format($input['type'])
                            ->encoding('UTF-8')
                            ->generate($vcard);

            }else if($input['qrdata_type'] == 'mecard'){

                $rules['qr_mec_name'] = 'required';
                $rules['qr_mec_phone'] = 'required';
                $rules['qr_mec_email'] = 'required';
                $rules['qr_mec_url'] = 'required';

                $fullMcard = 'Name:'.$input['qr_mec_name'].';URL:'.$input['qr_mec_url'].';TEL:'.$input['qr_mec_phone'].';EMAIL:'.$input['qr_mec_email'];

                $data = \QrCode::size($input['height']*$input['scale'])
                            ->backgroundColor($bgColorCode[0],$bgColorCode[1],$bgColorCode[2])
                            ->color($colorCode[0],$colorCode[1],$colorCode[2])
                            ->format($input['type'])
                            ->encoding('UTF-8')
                            ->generate($fullMcard);
            }

        }

        if (env('IS_LOCAL_OR_LIVE') == 'local') {
                
            return $data;

        }else{

            return base64_encode($data);
        }
        
    }
}
    