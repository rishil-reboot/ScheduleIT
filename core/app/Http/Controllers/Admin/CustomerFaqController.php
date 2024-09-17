<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CustomerFaq;
use App\FaqCategory;
use App\Language;
use Validator;
use Session;

class CustomerFaqController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['faqs'] = CustomerFaq::where('language_id', $lang_id)->orderBy('id', 'DESC')->get();

        $data['lang_id'] = $lang_id;

        return view('admin.home.faq.customer.index', $data);
    }

    public function edit($id)
    {
        $data['faq'] = CustomerFaq::findOrFail($id);
        $data['bcats'] = FaqCategory::where('language_id', $data['faq']->language_id)
                                    ->where('feature', 1)
                                    ->get();
        return view('admin.home.faq.customer.edit', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'customer_faq']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('customer_faq_image', $filename);
        $request->file('file')->move('assets/front/img/faq/customer/', $filename);
        return response()->json(['status' => "session_put", "image" => "customer_faq_image", 'filename' => $filename]);
    }

    public function store(Request $request)
    {
        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $rules = [
            'language_id' => 'required',
            'customer_faq_image' => 'required',
            'faq_category_id' => 'required',
            'question' => 'required|max:255',
            'answer' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $faq = new CustomerFaq;
        $faq->language_id = $request->language_id;
        $faq->image = $request->customer_faq_image;
        $faq->question = $request->question;
        $faq->faq_category_id = $request->faq_category_id;
        $faq->answer = $request->answer;
        $faq->serial_number = $request->serial_number;
        $faq->save();

        Session::flash('success', 'Customer Faq added successfully!');
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'customer_faq']);
        }

        $faq = CustomerFaq::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/faq/customer', $filename);
            @unlink('assets/front/img/faq/customer' . $faq->image);
            $faq->image = $filename;
            $faq->save();
        }

        return response()->json(['status' => "success", "image" => "Faq image", 'faq' => $faq]);
    }

    public function update(Request $request)
    {
        $rules = [
            'question' => 'required|max:255',
            'answer' => 'required',
            'faq_category_id' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $faq = CustomerFaq::findOrFail($request->faq_id);
        $faq->question = $request->question;
        $faq->faq_category_id = $request->faq_category_id;
        $faq->answer = $request->answer;
        $faq->serial_number = $request->serial_number;
        $faq->save();

        Session::flash('success', 'Faq updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        $faq = CustomerFaq::findOrFail($request->faq_id);
        $faq->delete();

        Session::flash('success', 'Faq deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $faq = CustomerFaq::findOrFail($id);
            $faq->delete();
        }

        Session::flash('success', 'FAQs deleted successfully!');
        return "success";
    }

    public function getcats($langid)
    {
        $bcategories = \App\FaqCategory::where('language_id', $langid)
                                        ->where('feature', 1)
                                        ->get();

        return $bcategories;
    }

    public function feature(Request $request)
    {
        $scategory = CustomerFaq::find($request->faq_id);
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
