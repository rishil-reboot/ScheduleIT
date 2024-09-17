<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Language;

class MetaViewerController extends Controller {

    public function index(){

        return view('admin.tools.metadata-viewer.index');
    }

    public function getPreview(Request $request){

        $img = $request->file('file');
        
        $rules = [
            
            'file'=>'required|mimes:jpeg,jpg,jpe,jif,jfif,jfi,tif,tiff|max:5120'
        ];
        
        $message = [

            'file.required'=>'This field is required',
            'file.max'=>'The max 5MB file size is allowed'
        ];
            
        $request->validate($rules,$message);

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->file('file')->move('assets/front/img/meta-viewer/', $filename);
        $filePath = str_replace('core', '', base_path()) . 'assets/front/img/meta-viewer/' . $filename;
        $fileType = mime_content_type($filePath);
        
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
