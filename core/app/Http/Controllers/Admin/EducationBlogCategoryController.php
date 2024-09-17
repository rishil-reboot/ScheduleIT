<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Bcategory;
use App\EducationCategory;
use App\Language;
use Validator;
use Session;

class EducationBlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['ecategorys'] = EducationCategory::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;

        return view('admin.education.category.index', $data);
    }

    public function edit($id)
    {
        $data['ecategory'] = EducationCategory::findOrFail($id);
        return view('admin.education.category.edit', $data);
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

        $bcategory = new EducationCategory;
        $bcategory->language_id = $request->language_id;
        $bcategory->name = $request->name;
        $bcategory->slug = slug_create($request->slug);
        $bcategory->status = $request->status;
        $bcategory->serial_number = $request->serial_number;
        $bcategory->save();

        Session::flash('success', 'Category added successfully!');
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

        $bcategory = EducationCategory::findOrFail($request->education_category_id);
        $bcategory->name = $request->name;
        $bcategory->slug = slug_create($request->slug);
        $bcategory->status = $request->status;
        $bcategory->serial_number = $request->serial_number;
        $bcategory->save();

        Session::flash('success', 'Category updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $bcategory = EducationCategory::findOrFail($request->education_category_id);
        if ($bcategory->educationBlogs()->count() > 0) {
            Session::flash('warning', 'First, delete all the education blogs under this category!');
            return back();
        }
        $bcategory->delete();

        Session::flash('success', 'Category deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $bcategory = EducationCategory::findOrFail($id);
            if ($bcategory->educationBlogs()->count() > 0) {
                Session::flash('warning', 'First, delete all the education blogs under the selected categories!');
                return "success";
            }
        }

        foreach ($ids as $id) {
            $bcategory = EducationCategory::findOrFail($id);
            $bcategory->delete();
        }

        Session::flash('success', 'categories deleted successfully!');
        return "success";
    }
}
