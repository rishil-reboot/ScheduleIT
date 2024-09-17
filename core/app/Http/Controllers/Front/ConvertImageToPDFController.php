<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MPDF;
use App\Language;

class ConvertImageToPDFController extends Controller
{

    public function imageToPdf(){

        return view('tools.image-to-pdf.index');
    }
    
    public function convertImageToPdf(Request $request){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
  
        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $img = $request->file('file');
        
        $rules = [
            
            'file'=>'required|mimes:jpeg,jpg,png,gif,tiff|max:5120',
            
        ];

        $message = [

            'file.required'=>'This field is required',
            'file.max'=>'The max 5MB file size is allowed'
        ];


        if ($bs->is_recaptcha == 1) {

            $rules['g-recaptcha-response'] = 'required';

        }

        $message['g-recaptcha-response.required'] = 'Please verify that you are not a robot.';
        $message['g-recaptcha-response.captcha'] = 'Captcha error! try again later or contact site admin.';

        $request->validate($rules,$message);
        
        $arayFilePath = [];

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->file('file')->move('assets/front/img/img-to-pdf/', $filename);

        $arayFilePath[] =  str_replace('core', '', base_path()) . 'assets/front/img/img-to-pdf/' . $filename;

        \Session::put('fileArray',$arayFilePath);

        return response()->json(['filename'=>$filename]);
        
    }

    public function removeFileFromServer(Request $request){

        if(\Session::has('fileArray')){

           foreach(\Session::get('fileArray') as $key=>$v){

                unlink($v);
           }

        }

    }

    public function getDownloadFile(Request $request){
        
        $pdf = MPDF::loadView('pdf.image-to-pdf', [
    		'filename'=>$request->filename,
        ]);
        
        return $pdf->download($request->filename);

    }
}



