<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Language;
use App\Gallery;
use Validator;
use Session;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['galleries'] = Gallery::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;

        return view('admin.gallery.index', $data);
    }

    public function edit($id)
    {
        $data['gallery'] = Gallery::findOrFail($id);
        return view('admin.gallery.edit', $data);
    }

    public function upload(Request $request)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'gallery']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('gallery_image', $filename);
        $request->file('file')->move('assets/front/img/gallery/', $filename);
        return response()->json(['status' => "session_put", "image" => "gallery", 'filename' => $filename]);
    }

    public function uploadUpdate(Request $request, $id)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'gallery']);
        }

        $gallery = Gallery::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/gallery/', $filename);
            @unlink('assets/front/img/gallery/' . $gallery->image);
            $gallery->image = $filename;
            $gallery->save();
        }

        return response()->json(['status' => "success", "image" => "Gallery image", 'gallery' => $gallery]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $messages = [
            'language_id.required' => 'The language field is required',
        ];

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:255',
            'media_type' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $video_upload = $request->file('video_upload');
        $img_upload = $request->file('img_upload');
        $document_file = $request->file('document_file');
        $audio_file = $request->file('audio_file');
        $audio_thumb = $request->file('audio_thumb');
        $is_video =$request->is_video;
        $media_type_image_upload = $request->file('image');

        if (isset($input['media_type'])) {

            if ($input['media_type'] ==  1) {
            
                if(!empty($media_type_image_upload)) {
                    $allowedExts = array('jpg', 'png', 'jpeg');
                    $rules = [
                        'image' => [
                            function ($attribute, $value, $fail) use ($media_type_image_upload, $allowedExts) {
                                if (!empty($media_type_image_upload)) {
                                    $ext = $media_type_image_upload->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only png, jpg, jpeg image is allowed.");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());
                    }

                    $filename = time() . '.' . $media_type_image_upload->getClientOriginalExtension();
                    $request->file('image')->move('assets/front/img/gallery/', $filename);
                    $media_type_image_upload = $filename;
                }

            }elseif ($input['media_type'] ==  2) {

                if(!empty($document_file)) {
                    $allowedExts = array('doc','docx','odt','pdf','tex','txt','rtf','wps','wks','wpd');
                    $rules = [
                        'document_file' => [
                            function ($attribute, $value, $fail) use ($document_file, $allowedExts) {
                                if (!empty($document_file)) {
                                    $ext = $document_file->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only mention file types is allowed.");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {

                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());

                    }

                    $filename = time() . '.' . $document_file->getClientOriginalExtension();
                    $request->file('document_file')->move('assets/front/doc/', $filename);
                    $document_file = $filename;
                }

            }elseif($input['media_type'] ==  3){

                if(!empty($img_upload)) {
                    $allowedExts = array('jpg', 'png', 'jpeg');
                    $rules = [
                        'img_upload' => [
                            function ($attribute, $value, $fail) use ($img_upload, $allowedExts) {
                                if (!empty($img_upload)) {
                                    $ext = $img_upload->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only png, jpg, jpeg image is allowed");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());
                    }

                    $filename = time() . '.' . $img_upload->getClientOriginalExtension();
                    $request->session()->put('video_image', $filename);
                    $request->file('img_upload')->move('assets/front/img/videos/', $filename);
                    $img_upload = $filename;
                }

                if(!empty($video_upload)){
                    $allowedExts = array('mp4', 'mov');
                    $rules = [
                        'video_upload' => [
                            function ($attribute, $value, $fail) use ($video_upload, $allowedExts) {
                                if (!empty($img)) {
                                    $ext = $img->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only mp4, mov,  video is allowed");
                                    }
                                }
                            },
                        ],
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {

                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());
                    }

                    $filename = time() . '.' . $video_upload->getClientOriginalExtension();
                    $request->file('video_upload')->move('assets/front/videos/', $filename);
                    $video_upload = asset('assets/front/videos/'.$filename);
                    $video_name= $filename;
                }

            }elseif($input['media_type'] ==  4){

                if(!empty($audio_file) && $audio_file !=null) {
                    $allowedExts = array('m4a','flac','mp3','wav','wma','aac');
                    $rules = [
                        'audio_file' => [
                            function ($attribute, $value, $fail) use ($audio_file, $allowedExts) {
                                if (!empty($audio_file)) {
                                    $ext = $audio_file->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Note. Only M4A , FLAC , MP3 , MP4 , WAV , WMA , AAC are allowed.");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());
                    }

                    $filename = time() . '.' . $audio_file->getClientOriginalExtension();
                    $request->file('audio_file')->move('assets/front/img/audio/', $filename);
                    $audio_file = $filename;
                }

                if(!empty($audio_thumb) && $audio_thumb !=null) {
                    $allowedExts = array('jpg', 'png', 'jpeg');
                    $rules = [
                        'audio_thumb' => [
                            function ($attribute, $value, $fail) use ($audio_thumb, $allowedExts) {
                                if (!empty($audio_thumb)) {
                                    $ext = $audio_thumb->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only png, jpg, jpeg image is allowed");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());
                    }

                    $filename = time() . '.' . $audio_thumb->getClientOriginalExtension();
                    $request->file('audio_thumb')->move('assets/front/img/audio/', $filename);
                    $audio_thumb = $filename;
                }
            }
        }


        $gallery = new Gallery;

        if (isset($input['media_type']) && $input['media_type'] == 3) {

            $is_thum = $request->is_thum;
            if($is_thum == 1){
                
                $gallery->main_image = $request->img_url;

            }else{

                $gallery->main_image = $img_upload;

            }

            if($is_video == 1){
                $gallery->videoUrl = $request->videoUrl;

            }else{
                $gallery->videoUrl = $video_upload;

            }

            $gallery->is_thum = $request->is_thum;
            $gallery->is_video = $request->is_video;
            $gallery->video_name = $video_name; // storing video filename (e.g: 189455784.mp4)

        }

        $gallery->media_type = (isset($input['media_type'])) ? $input['media_type'] : Null;
        $gallery->image = (isset($input['media_type']) && $input['media_type'] == 1) ? $media_type_image_upload : Null;
        $gallery->document_file = (isset($input['media_type']) && $input['media_type'] == 2) ? $document_file : Null;
        $gallery->audio_file = (isset($input['media_type']) && $input['media_type'] == 4 && $audio_file !=null) ? $audio_file : Null;
        $gallery->audio_thumb = (isset($input['media_type']) && $input['media_type'] == 4 && $audio_thumb !=null) ? $audio_thumb : Null;
        $gallery->language_id = $request->language_id;
        $gallery->title = $request->title;
        $gallery->serial_number = $request->serial_number;
        $gallery->keyword = $request->keyword;
        $gallery->description = $request->description;

        $gallery->save();

        Session::flash('success', 'Image added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $input = $request->all();

        $video_upload = $request->file('video_upload');
        $img_upload = $request->file('img_upload');
        $document_file = $request->file('document_file');
        $audio_file = $request->file('audio_file');
        $audio_thumb = $request->file('audio_thumb');

        $gallery = Gallery::findOrFail($request->gallery_id);

        $rules = [
            'title' => 'required|max:255',
            'media_type' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        // dd($validator->fails());
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $gallery = Gallery::findOrFail($request->gallery_id);

        $is_video = $request->is_video;

        $media_type_image_upload = $request->file('image');

        if (isset($input['media_type'])) {

            if ($input['media_type'] ==  1) {

                if(!empty($media_type_image_upload)) {
                    $allowedExts = array('jpg','png','jpeg');

                    $rules = [
                        'image' => [
                            function ($attribute, $value, $fail) use ($media_type_image_upload, $allowedExts) {
                                if (!empty($media_type_image_upload)) {
                                    $ext = $media_type_image_upload->getClientOriginalExtension();

                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only png, jpg, jpeg image is allowed");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    
                    if ($validator->fails()) {
                        
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());

                    }
                    
                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/doc/' . $gallery->document_file);
                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/videos/' . $gallery->videoUrl);
                    @unlink('assets/front/img/gallery/' . $gallery->image);
                    @unlink('assets/front/img/audio/' . $gallery->audio_file);
                    @unlink('assets/front/img/audio/' . $gallery->audio_thumb);


                    $filename = time() . '.' . $media_type_image_upload->getClientOriginalExtension();
                    $request->file('image')->move('assets/front/img/gallery/', $filename);
                    $media_type_image_upload = $filename;
                }

            }else if ($input['media_type'] ==  2) {

                if(!empty($document_file)) {
                    $allowedExts = array('doc','docx','odt','pdf','tex','txt','rtf','wps','wks','wpd');
                    $rules = [
                        'document_file' => [
                            function ($attribute, $value, $fail) use ($document_file, $allowedExts) {
                                if (!empty($document_file)) {
                                    $ext = $document_file->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only mentions file types are allowed.");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());

                    }
             

                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/doc/' . $gallery->document_file);
                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/videos/' . $gallery->videoUrl);
                    @unlink('assets/front/img/gallery/' . $gallery->image);
                    @unlink('assets/front/img/audio/' . $gallery->audio_file);
                    @unlink('assets/front/img/audio/' . $gallery->audio_thumb);


                    $filename = time() . '.' . $document_file->getClientOriginalExtension();
                    $request->file('document_file')->move('assets/front/doc/', $filename);
                    $document_file = $filename;
                }

            }else if($input['media_type'] ==  3){

                if(!empty($img_upload)) {
                    $allowedExts = array('jpg', 'png', 'jpeg');
                    $rules = [
                        'img_upload' => [
                            function ($attribute, $value, $fail) use ($img_upload, $allowedExts) {
                                if (!empty($img_upload)) {
                                    $ext = $img_upload->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only png, jpg, jpeg image is allowed");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                      
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());
                    }
                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/doc/' . $gallery->document_file);
                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/videos/' . $gallery->videoUrl);
                    @unlink('assets/front/img/gallery/' . $gallery->image);

                    @unlink('assets/front/img/audio/' . $gallery->audio_file);
                    @unlink('assets/front/img/audio/' . $gallery->audio_thumb);

                    $filename = time() . '.' . $img_upload->getClientOriginalExtension();
                    $request->session()->put('video_image', $filename);
                    $request->file('img_upload')->move('assets/front/img/videos/', $filename);
                    $img_upload = $filename;
                }
                if(!empty($video_upload)){
                    $allowedExts = array('mp4', 'mov');
                    $rules = [
                        'video_upload' => [
                            function ($attribute, $value, $fail) use ($video_upload, $allowedExts) {
                                if (!empty($img)) {
                                    $ext = $img->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only mp4, mov,  video is allowed");
                                    }
                                }
                            },
                        ],
                    ];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                       
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());
                    }

                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/doc/' . $gallery->document_file);
                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/videos/' . $gallery->videoUrl);
                    @unlink('assets/front/img/gallery/' . $gallery->image);

                    @unlink('assets/front/img/audio/' . $gallery->audio_file);
                    @unlink('assets/front/img/audio/' . $gallery->audio_thumb);

                    $filename = time() . '.' . $video_upload->getClientOriginalExtension();
                    $request->file('video_upload')->move('assets/front/videos/', $filename);
                    $video_upload = asset('assets/front/videos/'.$filename);
                    //Updating Video Filename (e.g: 1982654745.mp4)
                    $video_name= $filename;
                    $gallery->video_name = $video_name;


                }

            }elseif($input['media_type'] ==  4){

                if(!empty($audio_file) && $audio_file !=null) {
                    $allowedExts = array('m4a','flac','mp3','wav','wma','aac');
                    $rules = [
                        'audio_file' => [
                            function ($attribute, $value, $fail) use ($audio_file, $allowedExts) {
                                if (!empty($audio_file)) {
                                    $ext = $audio_file->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Note. Only M4A , FLAC , MP3 , MP4 , WAV , WMA , AAC are allowed.");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());
                    }

                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/doc/' . $gallery->document_file);
                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/videos/' . $gallery->videoUrl);
                    @unlink('assets/front/img/gallery/' . $gallery->image);

                    $filename = time() . '.' . $audio_file->getClientOriginalExtension();
                    $request->file('audio_file')->move('assets/front/img/audio/', $filename);
                    $audio_file = $filename;
                }

                if(!empty($audio_thumb) && $audio_thumb !=null) {
                    $allowedExts = array('jpg', 'png', 'jpeg');
                    $rules = [
                        'audio_thumb' => [
                            function ($attribute, $value, $fail) use ($audio_thumb, $allowedExts) {
                                if (!empty($audio_thumb)) {
                                    $ext = $audio_thumb->getClientOriginalExtension();
                                    if (!in_array($ext, $allowedExts)) {
                                        return $fail("Only png, jpg, jpeg image is allowed");
                                    }
                                }
                            },
                        ],
                    ];

                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        
                        $errmsgs = $validator->getMessageBag()->add('error', 'true');
                        return response()->json($validator->errors());
                    }

                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/doc/' . $gallery->document_file);
                    @unlink('assets/front/img/videos/' . $gallery->main_image);
                    @unlink('assets/front/videos/' . $gallery->videoUrl);
                    @unlink('assets/front/img/gallery/' . $gallery->image);

                    $filename = time() . '.' . $audio_thumb->getClientOriginalExtension();
                    $request->file('audio_thumb')->move('assets/front/img/audio/', $filename);
                    $audio_thumb = $filename;
                }
            }

        }

        if (isset($input['media_type']) && $input['media_type'] == 1) {

            if (!empty($media_type_image_upload)) {

                $gallery->image = $media_type_image_upload;
            }

            $gallery->main_image = Null;
            $gallery->videoUrl = Null;
            $gallery->is_thum = 0;
            $gallery->is_video = 0;
            $gallery->document_file = Null;

        }elseif (isset($input['media_type']) && $input['media_type'] == 2) {
                
            if (!empty($document_file)) {

                $gallery->document_file = $document_file;
            } 
                                  
            $gallery->main_image = Null;
            $gallery->videoUrl = Null;
            $gallery->is_thum = 0;
            $gallery->is_video = 0;
            $gallery->image = Null;

        }elseif (isset($input['media_type']) && $input['media_type'] == 3) {
           

            $is_thum = $request->is_thum;

            if($is_thum == 1){

                if ($request->img_url !=null) {

                    $gallery->main_image = $request->img_url;
                }

            }else{

                if ($img_upload !=null) {
                    
                   $gallery->main_image = $img_upload;
                }

            }
            if($is_video == 1){
             
                $gallery->videoUrl = $request->videoUrl;
            }
            else{
                $gallery->videoUrl = $video_upload;
            }

            if (empty($gallery->videoUrl)) {
                $gallery->videoUrl = $request->previous_video;
            }

            $gallery->is_thum = $is_thum;
            $gallery->is_video = $is_video;

            $gallery->image = Null;
            $gallery->document_file = Null;


        }elseif (isset($input['media_type']) && $input['media_type'] == 4) {
                
            $gallery->image = Null;
            $gallery->main_image = Null;
            $gallery->videoUrl = Null;
            $gallery->is_thum = 0;
            $gallery->is_video = 0;
            $gallery->document_file = Null;

            if (isset($audio_thumb) !=null && !empty($audio_thumb)) {
                
                $gallery->audio_thumb = $audio_thumb;    
            }

            if (isset($audio_file) !=null && !empty($audio_file)) {
                
                $gallery->audio_file = $audio_file;    
            }
        }

        $gallery->media_type = isset($input['media_type']) ? $input['media_type'] : Null;
        $gallery->title = $request->title;
        $gallery->serial_number = $request->serial_number;
        $gallery->keyword = $request->keyword;
        $gallery->description = $request->description;

        $gallery->save();

        Session::flash('success', 'Media updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $gallery = Gallery::findOrFail($request->gallery_id);
        @unlink('assets/front/img/gallery/' . $gallery->image);
        @unlink('assets/front/videos/' . $gallery->video_name);
        @unlink('assets/front/img/videos/' . $gallery->main_image);
        @unlink('assets/front/doc/' . $gallery->document_file);
        @unlink('assets/front/img/audio/' . $gallery->audio_file);
        @unlink('assets/front/img/audio/' . $gallery->audio_thumb);
        $gallery->delete();

        Session::flash('success', 'Image deleted successfully!');
        return back();
    }

    public function deleteDocFile(Request $request,$id)
    {

        $gallery = Gallery::findOrFail($id);
        @unlink('assets/front/doc/' . $gallery->document_file);
        $gallery->document_file = Null;
        $gallery->save();

        return response()->json(['success'=>true,'msg'=>"Document file successfully deleted."]);
    }

    public function deleteAudioFile(Request $request,$id)
    {

        $gallery = Gallery::findOrFail($id);
        @unlink('assets/front/img/audio/' . $gallery->audio_file);
        $gallery->audio_file = Null;
        $gallery->save();

        return response()->json(['success'=>true,'msg'=>"Audio file successfully deleted."]);
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $gallery = Gallery::findOrFail($id);
            @unlink('assets/front/img/gallery/' . $gallery->image);
            @unlink('assets/front/videos/' . $gallery->video_name);
            @unlink('assets/front/img/videos/' . $gallery->main_image);
            @unlink('assets/front/doc/' . $gallery->document_file);
            @unlink('assets/front/img/audio/' . $gallery->audio_file);
            @unlink('assets/front/img/audio/' . $gallery->audio_thumb);
            $gallery->delete();
        }

        Session::flash('success', 'Image deleted successfully!');
        return "success";
    }
}
