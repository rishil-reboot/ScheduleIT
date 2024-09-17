<?php

namespace App\Http\Controllers\Admin;
use App\BasicExtended;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Videos;
use App\Vcategory;
use App\Language;
use App\AzureBrand;
use App\APModel;
use Validator;
use Session;
use App\Admin;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;


class VideosController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;

        $data['videos'] = Videos::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);
        $data['lang_id'] = $lang_id;
        $data['azure_brand'] = AzureBrand::get();
        $data['personModelId'] = APModel::get();
        $data['abe'] = BasicExtended::where('language_id', $lang_id)->first();


        return view('admin.videos.videos.index', $data);
    }

    public function edit($id)
    {
        $data['video'] = Videos::findOrFail($id);
        $data['ascats'] = Vcategory::where('status', 1)->where('language_id', $data['video']->language_id)->get();
        $data['azure_brand'] = AzureBrand::get();
        $data['personModelId'] = APModel::get();
        
        $data['abe'] = BasicExtended::where('language_id', $data['video']->language_id)->first();
        return view('admin.videos.videos.edit', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'video']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('video_image', $filename);
        $request->file('file')->move('assets/front/img/videos/', $filename);
        return response()->json(['status' => "session_put", "image" => "video_image", 'filename' => $filename]);
    }

    public function store(Request $request)
    {
        
        $video_upload = $request->file('video_upload');
        $img_upload = $request->file('img_upload');

        $is_video =$request->is_video;
        if(!empty($img_upload)) {
            $allowedExts = array('jpg', 'png', 'jpeg');
            $rules = [
                'file' => [
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
                $validator->getMessageBag()->add('error', 'true');
                return response()->json(['errors' => $validator->errors(), 'id' => 'video_image']);
            }

            $filename = time() . '.' . $img_upload->getClientOriginalExtension();
            $request->session()->put('video_image', $filename);
            $request->file('img_upload')->move('assets/front/img/videos/', $filename);
            $img_upload = $filename;
        }

        if(!empty($video_upload)){
            $allowedExts = array('mp4', 'mov');
            $rules = [
                'file' => [
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
                $validator->getMessageBag()->add('error', 'true');
                return response()->json(['errors' => $validator->errors(), 'id' => 'video_url']);
            }

            $filename = time() . '.' . $video_upload->getClientOriginalExtension();
            $request->file('video_upload')->move('assets/front/videos/', $filename);
            $video_upload = asset('assets/front/videos/'.$filename);
        }
        
        $language = Language::find($request->language_id);
        $be = $language->basic_extended;

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $slug = make_slug($request->name);

        $rules = [
            'language_id' => 'required',
            'id_categories' => 'required|max:255',
            'serial_number' => 'required',
            'name' => 'required',

        ];

        // if 'theme version'contains video category
        if (hasCategory($be->theme_version)) {
            $rules["id_categories"] = 'required';
        }

        // if 'theme version' doesn't contain video category
       

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $is_thum = $request->is_thum;
            
        $video = new Videos;
        // echo  $video_upload;exit;
        if($is_thum == 1){
            $video->main_image = $request->img_url;

        }else{
            $video->main_image = $img_upload;

        }
        if($is_video == 1){
            $video->videoUrl = $request->videoUrl;

        }else{
            $video->videoUrl = $video_upload;

        }

        $video->language_id = $request->language_id;
        $video->name = $request->name;
        $video->slug = $slug;
        // if 'theme version'contains video category
        $video->id_cms_users = Auth::guard('admin')->user()->id;
        $video->id_categories = $request->id_categories;
        $video->fileName = $request->fileName;
        $video->is_thum = $request->is_thum;
        $video->is_video = $request->is_video;
        $video->privacy = $request->privacy;
        $video->serial_number = $request->serial_number;
        $video->priority = $request->priority;
        $video->description = $request->description;
        $video->partition_video = $request->partition_video;
        $video->externalId = $request->externalId;
        $video->externalUrl = $request->externalUrl;
        $video->metadata = $request->metadata;
        $video->indexingPreset = $request->indexingPreset;
        $video->streamingPreset = $request->streamingPreset;
        $video->linguisticModelId = $request->linguisticModelId;
        $video->personModelId = $request->personModelId;
        $video->sendSuccessEmail = $request->sendSuccessEmail;
        $video->brandsCategories = $request->brandsCategories;
        $video->created_at = now();
        $video->save();
        $Insert_id = $video->id;
        $id_cms_users = Auth::guard('admin')->user()->id;
        UploadVideo($Insert_id, $id_cms_users);
        // echo $Insert_id;exit;

        Session::flash('success', 'Videos added successfully!');
        return "success";
    }

    public function update(Request $request,$id)
    {
        $video_upload = $request->file('video_upload');
        $img_upload = $request->file('img_upload');
        $video = Videos::findOrFail($id);

        $is_video =$request->is_video;
        if(!empty($img_upload)) {
            $allowedExts = array('jpg', 'png', 'jpeg');
            $rules = [
                'file' => [
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
                $validator->getMessageBag()->add('error', 'true');
                return response()->json(['errors' => $validator->errors(), 'id' => 'video_image']);
            }
            
            @unlink('assets/front/img/videos/' . $video->main_image);

            $filename = time() . '.' . $img_upload->getClientOriginalExtension();
            $request->session()->put('video_image', $filename);
            $request->file('img_upload')->move('assets/front/img/videos/', $filename);
            $img_upload = $filename;
        }
        if(!empty($video_upload)){
            $allowedExts = array('mp4', 'mov');
            $rules = [
                'file' => [
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
                $validator->getMessageBag()->add('error', 'true');
                return response()->json(['errors' => $validator->errors(), 'id' => 'video_url']);
            }
            @unlink('assets/front/videos/' . $video->videoUrl);
            $filename = time() . '.' . $video_upload->getClientOriginalExtension();
            $request->file('video_upload')->move('assets/front/videos/', $filename);
            $video_upload = asset('assets/front/videos/'.$filename);
        }
        $slug = make_slug($request->name);
        $language = Language::find($video->language_id);
        $be = $language->basic_extended;

        $rules = [
            'id_categories' => 'required|max:255',
            'serial_number' => 'required',
            'name' => 'required',
            'videoUrl' => 'required',
        ];

        if (hasCategory($be->theme_version)) {
            $rules["id_categories"] = 'required';
        }

        if ($request->details_page_status == 0) {
            $rules["content"] = 'nullable';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
        $is_thum = $request->is_thum;
        if($is_thum == 1){
            $video->main_image = $request->img_url;

        }else{
            $video->main_image = $img_upload;

        }
        if($is_video == 1){
            $video->videoUrl = $request->videoUrl;

        }else{
            $video->videoUrl = $video_upload;

        }
        $video->id_cms_users = Auth::guard('admin')->user()->id;
        $video->id_categories = $request->id_categories;
        $video->fileName = $request->fileName;
        $video->is_thum = $is_thum;
        $video->is_video = $is_video;
        $video->privacy = $request->privacy;
        $video->serial_number = $request->serial_number;
        $video->priority = $request->priority;
        $video->description = $request->description;
        $video->partition_video = $request->partition_video;
        $video->externalId = $request->externalId;
        $video->externalUrl = $request->externalUrl;
        $video->metadata = $request->metadata;
        $video->indexingPreset = $request->indexingPreset;
        $video->streamingPreset = $request->streamingPreset;
        $video->linguisticModelId = $request->linguisticModelId;
        $video->personModelId = $request->personModelId;
        $video->sendSuccessEmail = $request->sendSuccessEmail;
        $video->brandsCategories = $request->brandsCategories;
        $video->updated_at = now();
        $video->save();
        $update_id = $video->id;
        $id_cms_users = Auth::guard('admin')->user()->id;
        UploadVideo($update_id, $id_cms_users, 'ReIndex');

        Session::flash('success', 'Videos updated successfully!');
        return "success";
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'video_image']);
        }

        $video = Videos::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/videos/', $filename);
            @unlink('assets/front/img/videos/' . $video->main_image);
            $video->main_image = $filename;
            $video->save();
        }

        return response()->json(['status' => "success", "image" => "Videos image", 'video' => $video]);
    }

    public function delete(Request $request)
    {
        $video = Videos::findOrFail($request->video_id);
        @unlink('assets/front/img/videos/' . $video->main_image);
        $video->delete();

        Session::flash('success', 'Videos deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $video = Videos::findOrFail($id);
            @unlink('assets/front/img/videos/' . $video->main_image);
            $video->delete();
        }

        Session::flash('success', 'Videos deleted successfully!');
        return "success";
    }

    public function getcats($langid)
    {
        $vcategories = Vcategory::where('language_id', $langid)->get();

        return $vcategories;
    }

    public function feature(Request $request)
    {
        $video = Videos::find($request->video_id);
        $video->feature = $request->feature;
        $video->save();

        if ($request->feature == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }

    public function getVideoIndex(Request $request){

        try {
            DB::enableQueryLog();
            $client = new \GuzzleHttp\Client();
            $results = DB::table('azure_accounts')->whereNull('deleted_at')->get();

            foreach ($results as $azure_accounts) {
                if($azure_accounts) {
                    $azure_accounts = getAccounts($azure_accounts->id_cms_users);
                    $azure_videos = DB::table('azure_videos')->where('id_cms_users', $azure_accounts->id_cms_users)->where('state','<>','Processed')->whereNull('deleted_at')->get();
                    foreach ($azure_videos as $key => $value) {
                        $url = env('AZURE_API_URL').'/'.$azure_accounts->location.'/Accounts/'.$azure_accounts->account_id.'/Videos/'.$value->videoId.'/Index?accessToken='.$azure_accounts->access_token.'&reTranslate=False';
                        $response = $client->request('GET', $url,['headers'=>['Ocp-Apim-Subscription-Key'=>$azure_accounts->primary_key]]);

                        $data = $response->getBody(); 
                        $res = json_decode($data);
                        $arr = ['video_index_json'=>$data, 'state'=>$res->state,'durationInSeconds'=>$res->durationInSeconds, 'thumbnailId'=>$res->summarizedInsights->thumbnailId, 'is_indexing'=>1];
                        DB::table('azure_videos')->where('id', $value->id)->update($arr);
                        if($value->id_videos>0) {
                            DB::table('azure_videos')->where('id', $value->id_videos)->update(['id_azure_videos'=>$value->id]);    
                        }
                    }
                }
            }
        } catch (HttpException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
        }
        // echo "<pre>";print_r($request);exit;
    }

    public function getPlayer($id){

        $value = Request()->id;
        $row  = DB::table('azure_videos')->where('id',$id)->first();
        Session::put('current_row_id',$id);
        return view('admin.videos.player.iframe',['row'=>$row,'value'=>$value]);
    }
}
