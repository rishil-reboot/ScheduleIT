<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Language;

class MetaViewerController extends Controller
{
    
    public function getMetaDataPreview(Request $request){

        $img = $request->file('file');
        
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        
        $bs = $currentLang->basic_setting;

        $rules = [
            
            'file'=>'required|mimes:jpeg,jpg,jpe,jif,jfif,jfi,tif,tiff|max:5120'
        ];
        
        $message = [

            'file.required'=>'This field is required',
            'file.max'=>'The max 5MB file size is allowed'
        ];

        if ($bs->is_recaptcha == 1) {

            $rules['g-recaptcha-response'] = 'required';
        }

        $messages['g-recaptcha-response.required'] = 'Please verify that you are not a robot.';
        $messages['g-recaptcha-response.captcha'] = 'Captcha error! try again later or contact site admin.';

        $request->validate($rules,$message);

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->file('file')->move('assets/front/img/meta-viewer/', $filename);
        $filePath = str_replace('core', '', base_path()) . 'assets/front/img/meta-viewer/' . $filename;
        $fileType = mime_content_type($filePath);
        
        // dd($fileType);

        $arayFilePath = [];
        if (in_array($fileType, ['image/jpeg','image/jpg', 'image/gif', 'video/mp4', 'video/x-msvideo'])) {
            
            $arayFilePath[] = $filePath;
            \Session::put('metaFileArray',$arayFilePath);

            $exifData = exif_read_data($filePath, null, true);
            
            return view('tools.get_meta_preview', [
                'file' => $filePath,
                'fileType' => $fileType,
                'exifData' => $exifData
            ]);

        } else {

            return response()->json(['message' => 'Invalid file type'], 400);

        }
    }

    public function removeFileFromServer(Request $request){

        if(\Session::has('metaFileArray')){

           foreach(\Session::get('metaFileArray') as $key=>$v){

                unlink($v);
           }
        }
    }

}
