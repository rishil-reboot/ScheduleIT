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

class VideosController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['videos'] = Videos::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;
		$data['azure_brand'] = AzureBrand::get();
        $data['personMpdel'] = APModel::get();
        $data['abe'] = BasicExtended::where('language_id', $lang_id)->first();


        return view('admin.videos.videos.index', $data);
    }

    public function edit($id)
    {
        $data['video'] = Videos::findOrFail($id);
		$data['brandsCategories_id'] = $data['video']['brandsCategories'];
        $data['personMpdel_id'] = $data['video']['personMpdel'];
        $data['ascats'] = Vcategory::where('status', 1)->where('language_id', $data['video']->language_id)->get();
		 $data['azure_brand'] = AzureBrand::get();
        $data['personMpdel'] = APModel::get();
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

        $img = $request->file('file');
        if($img) {
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
            return response()->json(['status' => "session_put", "image" => "store_image", 'filename' => $filename]);
        }
        

        $language = Language::find($request->language_id);
        $be = $language->basic_extended;

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $slug = make_slug($request->name);

        $rules = [
            'language_id' => 'required',
            'category' => 'required|max:255',
            'serial_number' => 'required',
            'name' => 'required',
            'videoUrl' => 'required',
        ];

        // if 'theme version'contains video category
        if (hasCategory($be->theme_version)) {
            $rules["category"] = 'required';
        }

        // if 'theme version' doesn't contain video category
       

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }
		$is_thum = $request->is_thum;
		$video = new Videos;
		//echo  $request->store_image;exit;
		if($is_thum == 1){
            $video->main_image = $request->img_url;

        }else{
            $video->main_image = $request->store_image;

        }
        $video->language_id = $request->language_id;
        $video->name = $request->name;
        $video->slug = $slug;
        // if 'theme version'contains video category
        if (hasCategory($be->theme_version)) {
            $video->vcategory_id = $request->category;
        }
        $video->videoUrl = $request->videoUrl;
        $video->fileName = $request->fileName;
        $video->is_thum = $request->is_thum;
        $video->privacy = $request->privacy;
        $video->serial_number = $request->serial_number;
        $video->priority = $request->priority;
        $video->description = $request->description;
        $video->partition = $request->partition;
        $video->externalId = $request->externalId;
        $video->externalUrl = $request->externalUrl;
        $video->metadata = $request->metadata;
        $video->indexingPreset = $request->indexingPreset;
        $video->streamingPreset = $request->streamingPreset;
        $video->linguisticModelId = $request->linguisticModelId;
        $video->personMpdel = $request->personMpdel;
        $video->sendSuccessEmail = $request->sendSuccessEmail;
        $video->brandsCategories = $request->brandsCategories;
		$video->created_at = now();
        $video->save();

        Session::flash('success', 'Videos added successfully!');
        return "success";
    }

    public function update(Request $request,$id)
    {
        $img = $request->file('file');
        if($img){
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

            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/videos/', $filename);
            @unlink('assets/front/img/videos/' . $video->main_image);
            return response()->json(['status' => "session_put", "image" => "video_image", 'filename' => $filename]);
        }

        $slug = make_slug($request->name);
        $video = Videos::findOrFail($request->video_id);

        $language = Language::find($video->language_id);
        $be = $language->basic_extended;

        $rules = [
            'category' => 'required|max:255',
            'serial_number' => 'required',
            'name' => 'required',
            'videoUrl' => 'required',
        ];

        if (hasCategory($be->theme_version)) {
            $rules["category"] = 'required';
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
            $video->main_image = $request->video_image;

        }
        $video->videoUrl = $request->videoUrl;
        $video->fileName = $request->fileName;
        $video->is_thum = $is_thum;
        $video->privacy = $request->privacy;
        $video->serial_number = $request->serial_number;
        $video->priority = $request->priority;
        $video->description = $request->description;
        $video->partition = $request->partition;
        $video->externalId = $request->externalId;
        $video->externalUrl = $request->externalUrl;
        $video->metadata = $request->metadata;
        $video->indexingPreset = $request->indexingPreset;
        $video->streamingPreset = $request->streamingPreset;
        $video->linguisticModelId = $request->linguisticModelId;
        $video->personMpdel = $request->personMpdel;
        $video->sendSuccessEmail = $request->sendSuccessEmail;
        $video->brandsCategories = $request->brandsCategories;
		$video->updated_at = now();
        $video->save();
		$Insert_id = $video->id;
        $user_id = Auth::guard('admin')->user()->id;
        UploadVideo($Insert_id, $user_id);

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

}
