<?php

namespace App\Http\Controllers\Admin;

use MPDF;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConvertImageToPDFController extends Controller {

    public function imageToPdf(){

        return view('admin.tools.image-to-pdf.index');
    }

    public function convertImageToPdf(Request $request){
        
        $img = $request->file('file');
        
        $rules = [
            
            'file'=>'required|mimes:jpeg,jpg,png,gif,tiff|max:5120'
        ];

        $message = [

            'file.required'=>'This field is required',
            'file.max'=>'The max 5MB file size is allowed'
        ];

        $request->validate($rules,$message);

        $arayFilePath = [];

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->file('file')->move('assets/front/img/img-to-pdf/', $filename);

        $arayFilePath[] =  str_replace('core', '', base_path()) . 'assets/front/img/img-to-pdf/' . $filename;

        Session::put('fileArray',$arayFilePath);

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
        dd('in');
        
        return $pdf->download($request->filename);

    }
}
