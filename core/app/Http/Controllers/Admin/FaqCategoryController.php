<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FaqCategory;
use App\Language;
use Validator;
use Session;

class FaqCategoryController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['scategorys'] = FaqCategory::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);

        $data['lang_id'] = $lang_id;
        return view('admin.home.faq.category.index', $data);
    }

    public function edit($id)
    {
        $data['scategory'] = FaqCategory::findOrFail($id);
        return view('admin.home.faq.category.edit', $data);
    }

    public function store(Request $request)
    {

        $slug = make_slug($request->slug);

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'name' => 'required|max:255',
            'slug' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $scategory = new FaqCategory;
        $scategory->language_id = $request->language_id;
        $scategory->name = $request->name;
        $scategory->slug = $slug;
        $scategory->serial_number = $request->serial_number;
        $scategory->save();

        Session::flash('success', 'FAQ Category added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->slug);

        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $scategory = FaqCategory::findOrFail($request->faq_category_id);
        $scategory->name = $request->name;
        $scategory->slug = $slug;
        $scategory->serial_number = $request->serial_number;
        $scategory->save();

        Session::flash('success', 'FAQ Category updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $scategory = FaqCategory::findOrFail($request->faq_category_id);
        if ($scategory->customerFaq()->count() > 0 || $scategory->faq()->count()) {
            Session::flash('warning', 'First, delete all the faqs under this category!');
            return back();
        }
        $scategory->delete();

        Session::flash('success', 'FAQ Category deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $scategory = FaqCategory::findOrFail($id);
            if ($scategory->customerFaq()->count() > 0 || $scategory->faq()->count()) {
                Session::flash('warning', 'First, delete all the faqs under the selected categories!');
                return "success";
            }
        }

        foreach ($ids as $id) {
            $scategory = FaqCategory::findOrFail($id);
            $scategory->delete();
        }

        Session::flash('success', 'FAQ categories deleted successfully!');
        return "success";
    }

    public function feature(Request $request)
    {
        $scategory = FaqCategory::find($request->faq_category_id);
        $scategory->feature = $request->feature;
        $scategory->save();

        if ($request->feature == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }
}
