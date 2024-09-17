<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vcategory;
use App\Language;
use Validator;
use Session;

class VcategoryController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['vcategorys'] = Vcategory::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;
        return view('admin.videos.vcategory.index', $data);
    }

    public function edit($id)
    {
        $data['vcategory'] = Vcategory::findOrFail($id);
        return view('admin.videos.vcategory.edit', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'video_category_icon']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('video_category_icon_image', $filename);
        $request->file('file')->move('assets/front/img/video_category_icons/', $filename);
        return response()->json(['status' => "session_put", "image" => "video category icon", 'filename' => $filename]);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'vcategory']);
        }

        $vcategory = Vcategory::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/video_category_icons/', $filename);
            @unlink('assets/front/img/video_category_icons/' . $vcategory->image);
            $vcategory->image = $filename;
            $vcategory->save();
        }

        return response()->json(['status' => "success", "image" => "Category icon", 'vcategory' => $vcategory]);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'video_category_icon' => 'nullable',
            'name' => 'required|max:255',
            'short_text' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $vcategory = new Vcategory;
        $vcategory->language_id = $request->language_id;
        $vcategory->name = $request->name;
        $vcategory->image = $request->video_category_icon;
        $vcategory->status = $request->status;
        $vcategory->short_text = $request->short_text;
        $vcategory->serial_number = $request->serial_number;
        $vcategory->save();

        Session::flash('success', 'Category added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'status' => 'required',
            'short_text' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $vcategory = Vcategory::findOrFail($request->vcategory_id);
        $vcategory->name = $request->name;
        $vcategory->status = $request->status;
        $vcategory->short_text = $request->short_text;
        $vcategory->serial_number = $request->serial_number;
        $vcategory->save();

        Session::flash('success', 'Category updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $vcategory = Vcategory::findOrFail($request->vcategory_id);
        if ($vcategory->videos()->count() > 0) {
            Session::flash('warning', 'First, delete all the videos under this category!');
            return back();
        }
        @unlink('assets/front/img/video_category_icons/' . $vcategory->image);
        $vcategory->delete();

        Session::flash('success', 'Category deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $vcategory = Vcategory::findOrFail($id);
            if ($vcategory->videos()->count() > 0) {
                Session::flash('warning', 'First, delete all the videos under the selected categories!');
                return "success";
            }
        }

        foreach ($ids as $id) {
            $vcategory = Vcategory::findOrFail($id);
            @unlink('assets/front/img/video_category_icons/' . $vcategory->image);
            $vcategory->delete();
        }

        Session::flash('success', 'Videos categories deleted successfully!');
        return "success";
    }

   
}
