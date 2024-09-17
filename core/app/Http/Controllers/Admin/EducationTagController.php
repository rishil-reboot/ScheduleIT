<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EducationTag;
use App\EducationBlogTag;
use App\Language;
use Validator;
use Session;

class EducationTagController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['tags'] = EducationTag::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;

        return view('admin.education.tag.index', $data);
    }

    public function edit($id)
    {
        $data['tag'] = EducationTag::findOrFail($id);
        return view('admin.education.tag.edit', $data);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'name' => 'required|max:255',
            'slug' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $obj = new EducationTag;
        $obj->language_id = $request->language_id;
        $obj->name = $request->name;
        $obj->slug = slug_create($request->slug);
        $obj->status = $request->status;
        $obj->serial_number = $request->serial_number;
        $obj->save();

        Session::flash('success', 'Tag added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required',
            'status' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $obj = EducationTag::findOrFail($request->tag_id);
        $obj->name = $request->name;
        $obj->slug = slug_create($request->slug);
        $obj->status = $request->status;
        $obj->serial_number = $request->serial_number;
        $obj->save();

        Session::flash('success', 'Tag updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $bcategory = EducationTag::findOrFail($request->tag_id);
        if ($bcategory->educationBlogTags()->count() > 0) {
            Session::flash('warning', 'First, delete all the education blogs under this tag!');
            return back();
        }
        $bcategory->delete();

        Session::flash('success', 'Tag deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $bcategory = EducationTag::findOrFail($id);
            if ($bcategory->educationBlogTags()->count() > 0) {
                Session::flash('warning', 'First, delete all the education blogs under the selected tag!');
                return "success";
            }
        }

        foreach ($ids as $id) {
            $bcategory = EducationTag::findOrFail($id);
            $bcategory->delete();
        }

        Session::flash('success', 'Tag deleted successfully!');
        return "success";
    }
}
