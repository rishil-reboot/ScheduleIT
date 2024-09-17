<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\BasicExtended as BE;
use App\BasicExtra;
use App\Language;
use App\Pcategory;
use App\ProductImage;
use App\Product;
use Validator;
use Session;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $query = Product::where('language_id', $lang_id)->orderBy('id', 'DESC');

        if (request()->input('product_type_id')) {

            $query->whereHas('productDataType',function($qt){

                $qt->where('product_type_id',request()->input('product_type_id'));

            });
        }

        $data['products'] = $query->paginate(10);

        $data['lang_id'] = $lang_id;
        return view('admin.product.index',$data);
    }


    public function create(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $abx = $lang->basic_extra;
        $categories = Pcategory::where('status',1)->get();
        return view('admin.product.create',compact('categories','abx'));
    }

    public function sliderstore(Request $request)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    $ext = $img->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only png, jpg, jpeg images are allowed");
                    }
                },
            ]
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $filename = uniqid() . '.jpg';

        $img->move('assets/front/img/product/sliders/', $filename);

        $pi = new ProductImage;
        if (!empty($request->product_id)) {
            $pi->product_id = $request->product_id;
        }
        $pi->image = $filename;
        $pi->save();

        return response()->json(['status' => 'success', 'file_id' => $pi->id]);
    }

    public function sliderrmv(Request $request)
    {
        $pi = ProductImage::findOrFail($request->fileid);
        @unlink('assets/front/img/product/sliders/' . $pi->image);
        $pi->delete();
        return $pi->id;
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'portfolio']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('portfolio_image', $filename);
        $request->file('file')->move('assets/front/img/product/featured/', $filename);
        return response()->json(['status' => "session_put", "image" => "featured_image", 'filename' => $filename]);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'slider']);
        }

        $product = Product::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/product/featured/', $filename);
            @unlink('assets/front/img/product/featured/' . $product->feature_image);
            $product->feature_image = $filename;
            $product->save();
        }

        return response()->json(['status' => "success", "image" => "Product image", 'product' => $product]);
    }


    public function getCategory($langid)
    {
        $category = Pcategory::where('language_id', $langid)->get();
        return $category;
    }


    public function store(Request $request)
    {
        $slug = make_slug($request->title);

        $rules = [
            'language_id' => 'required',
            'title' => 'required|max:255',
            'category_id' => 'required',
            'tags' => 'required',
            'stock' => 'required',
            'sku' => 'required|unique:products',
            'summary' => 'required',
            'description' => 'required|min:15',
            'featured_image' => 'required',
            'slider_images' => 'required',
            'status' => 'required',
            'product_template_id' => 'required',
        ];


        if ($request->call_for_price == 1) {

            $rules['phone_number'] = 'required';

        }else{

            $rules['current_price'] = 'required';
            $rules['previous_price'] = 'nullable';
        }

        $messages = [

            'language_id.required' => 'The language field is required',
            'category_id.required' => 'Category is required',
            'description.min' => 'Description is required'
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();

        $in['call_for_price'] = ($request->call_for_price == 1) ? $request->call_for_price : 0;
        $in['language_id'] = $request->language_id;
        $in['slug'] = $slug;
        $in['feature_image'] = $request->featured_image;

        $in['is_featured'] = ($request->is_featured == 1) ? $request->is_featured : 2;

        $product = Product::create($in);

        $slders = $request->slider_images;
        $pis = ProductImage::findOrFail($slders);
        foreach ($pis as $key => $pi) {
            $pi->product_id = $product->id;
            $pi->save();
        }

        $input = $request->all();

        if (isset($input['product_type_id']) && !empty($input['product_type_id'])) {

            foreach($input['product_type_id'] as $key=>$v){

                $obj = new \App\ProductTypeData;
                $obj->product_type_id = $v;
                $obj->product_id = $product->id;
                $obj->save();

            }

        }

        if (isset($input['sub_category_id']) && !empty($input['sub_category_id'])) {

            foreach($input['sub_category_id'] as $key=>$v){

                $obj = new \App\ProductSubCategoryData;
                $obj->category_id = $input['category_id'];
                $obj->sub_category_id = $v;
                $obj->product_id = $product->id;
                $obj->save();

            }

        }

        Session::flash('success', 'Product added successfully!');
        return "success";
    }


    public function edit(Request $request, $id)
    {
        $lang = Language::where('code', $request->language)->first();
        $abx = $lang->basic_extra;
        $categories = $lang->pcategories()->where('status',1)->get();
        $data = Product::findOrFail($id);
        return view('admin.product.edit',compact('categories','data','abx'));
    }

    public function images($portid)
    {
        $images = ProductImage::where('product_id', $portid)->get();
        return $images;
    }

    public function update(Request $request)
    {
        $slug = make_slug($request->title);

        $rules = [

            'title' => 'required|max:255',
            'product_template_id' => 'required',
            'category_id' => 'required',
            'tags' => 'required',
            'stock' => 'required',
            'sku' => [
                'required',
                Rule::unique('products')->ignore($request->product_id),
            ],
            'summary' => 'required',
            'description' => 'required|min:15',
            'status' => 'required',
        ];

        if ($request->call_for_price == 1) {

            $rules['phone_number'] = 'required';

        }else{

            $rules['current_price'] = 'required';
            $rules['previous_price'] = 'nullable';
        }

        $messages = [
            'category_id.required' => 'Service is required',
            'description.min' => 'Description is required'
        ];



        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $in = $request->all();
        $product = Product::findOrFail($request->product_id);
        $in['call_for_price'] = ($request->call_for_price == 1) ? $request->call_for_price : 0;
        $in['slug'] = $slug;
        $in['is_featured'] = ($request->is_featured == 1) ? $request->is_featured : 2;

        $product = $product->fill($in)->save();


        $input = $request->all();

        \App\ProductTypeData::where('product_id',$request->product_id)->delete();

        if (isset($input['product_type_id']) && !empty($input['product_type_id'])) {

            foreach($input['product_type_id'] as $key=>$v){

                $obj = new \App\ProductTypeData;
                $obj->product_type_id = $v;
                $obj->product_id = $request->product_id;
                $obj->save();
            }
        }

        \App\ProductSubCategoryData::where('product_id',$request->product_id)->delete();

        if (isset($input['sub_category_id']) && !empty($input['sub_category_id'])) {

            foreach($input['sub_category_id'] as $key=>$v){

                $obj = new \App\ProductSubCategoryData;
                $obj->category_id = $input['category_id'];
                $obj->sub_category_id = $v;
                $obj->product_id = $request->product_id;
                $obj->save();

            }
        }

        Session::flash('success', 'Product updated successfully!');
        return "success";
    }


    public function delete(Request $request)
    {

        $product = Product::findOrFail($request->product_id);

        foreach ($product->product_images as $key => $pi) {
            @unlink('assets/front/img/product/sliders/' . $pi->image);
            $pi->delete();
        }

        @unlink('assets/front/img/product/featured/' . $portfolio->feature_image);
        $product->delete();

        Session::flash('success', 'Product deleted successfully!');
        return back();
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $product = Product::findOrFail($id);
            foreach ($product->product_images as $key => $pi) {
                @unlink('assets/front/img/product/sliders/' . $pi->image);
                $pi->delete();
            }
        }

        foreach ($ids as $id) {
            $product = product::findOrFail($id);
            @unlink('assets/front/img/product/featured/' . $product->feature_image);
            $product->delete();
        }

        Session::flash('success', 'Product deleted successfully!');
        return "success";
    }


    public function populerTag(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();
        $lang_id = $lang->id;
        $data = BE::where('language_id',$lang_id)->first();
        return view('admin.product.tag.index',compact('data'));
    }

    public function populerTagupdate(Request $request)
    {
        $rules = [
            'language_id' => 'required',
            'popular_tags' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $lang = Language::where('code', $request->language_id)->first();
        $be = BE::where('language_id',$lang->id)->first();
        $be->popular_tags = $request->popular_tags;
        $be->save();
        Session::flash('success', 'Populer tags update successfully!');
        return "success";
    }


    public function feature(Request $request)
    {
        $product = \App\Product::find($request->product_id);
        $product->is_featured = $request->is_featured;
        $product->save();

        if ($request->is_featured == 1) {
            Session::flash('success', 'Featured successfully!');
        } else {
            Session::flash('success', 'Unfeatured successfully!');
        }

        return back();
    }

    /**
     * This function is used to get sub category data
     * @author Chirag Ghevariya
     */
    public function getSubcategory(Request $request){

        $productSubcategoryData = \App\PsubCategory::where('category_id',$request->category_id)
                                                    ->pluck('name','id')
                                                    ->toArray();

        $subCateArray = [];

        if ($request->product_id) {

           $subCateArray = \App\ProductSubCategoryData::where('product_id',$request->product_id)
                                    ->pluck('sub_category_id')
                                    ->toArray();
        }

        return view('admin.product._get_sub_category_list',compact('productSubcategoryData','subCateArray'));
    }
}
