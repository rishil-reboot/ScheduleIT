<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Pcategory;
use App\Language;
use Validator;
use Session;
use App\PsubCategory;

class ProductSubCategory extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data['pcategories'] = PsubCategory::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);
        
        $data['lang_id'] = $lang_id;
        return view('admin.product.sub-category.index',$data);
    }


    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:255',
            'status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }


        $data = new PsubCategory;
        $input = $request->all();
        $input['slug'] =  make_slug($request->name);
        $data->create($input);

        Session::flash('success', 'Sub Category added successfully!');
        return "success";
    }


    public function edit($id)
    {
        $data = PsubCategory::findOrFail($id);
        return view('admin.product.sub-category.edit',compact('data'));
    }

    public function update(Request $request)
    {
        
        $data = PsubCategory::findOrFail($request->category_id_primary);
        $input = $request->all();
        $input['slug'] =  make_slug($request->name);
        $data->update($input);

        Session::flash('success', 'Sub Category Update successfully!');
        return "success";
    }

    public function delete(Request $request)
    {
        $category = PsubCategory::findOrFail($request->category_id);
        if ($category->productSubCategoryData()->count() > 0) {
            Session::flash('warning', 'First, delete all the product categories!');
            return back();
        }

        $category->delete();

        Session::flash('success', 'Sub Category deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $pcategory = PsubCategory::findOrFail($id);
            if ($pcategory->productSubCategoryData()->count() > 0) {
                Session::flash('warning', 'First, delete all the product under the selected categories!');
                return "success";
            }
        }

        foreach ($ids as $id) {
            $pcategory = PsubCategory::findOrFail($id);
            $pcategory->delete();
        }

        Session::flash('success','Categories deleted successfully!');
        return "success";
    }

    /**
     * This function is used to get category data
     * @author Chirag Ghevariya
    */
    public function getcats($langid)
    {
        $bcategories = Pcategory::where('language_id', $langid)->get();

        return $bcategories;
    }
}



