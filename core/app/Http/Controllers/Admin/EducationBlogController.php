<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\EducationCategory;
use App\Language;
use App\EducationBlog;
use App\EducationTag;
use App\EducationBlogTag;
use Validator;
use Session;

class EducationBlogController extends Controller
{

    public function index(Request $request)
    {
        $lang = Language::where('code', $request->language)->first();

        $lang_id = $lang->id;
        $data['lang_id'] = $lang_id;
        $data['blogs'] = EducationBlog::where('language_id', $lang_id)->orderBy('id', 'DESC')->paginate(10);
        $data['bcats'] = EducationCategory::where('language_id', $lang_id)->where('status', 1)->get();

        return view('admin.education.blog.index', $data);
    }

    public function edit($id)
    {
        $data['blog'] = EducationBlog::findOrFail($id);
        $data['bcats'] = EducationCategory::where('language_id', $data['blog']->language_id)->where('status', 1)->get();
        return view('admin.education.blog.edit', $data);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'blog']);
        }

        $filename = time() . '.' . $img->getClientOriginalExtension();
        $request->session()->put('education_blog_image', $filename);
        $request->file('file')->move('assets/front/img/educationblogs/', $filename);
        return response()->json(['status' => "session_put", "image" => "education_blog_image", 'filename' => $filename]);
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
            return response()->json(['errors' => $validator->errors(), 'id' => 'blog']);
        }

        $blog = EducationBlog::findOrFail($id);
        if ($request->hasFile('file')) {
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $request->file('file')->move('assets/front/img/educationblogs/', $filename);
            @unlink('assets/front/img/educationblogs/' . $blog->main_image);
            $blog->main_image = $filename;
            $blog->save();
        }

        return response()->json(['status' => "success", "image" => "Blog image", 'blog' => $blog]);
    }

    public function store(Request $request)
    {

        $input = $request->all();

        $messages = [
            'language_id.required' => 'The language field is required'
        ];

        $slug = make_slug($request->title);

        $rules = [
            'language_id' => 'required',
            'education_blog_image' => 'required',
            'title' => 'required|max:255',
            'category' => 'required',
            'content' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $blog = new EducationBlog;
        $blog->language_id = $request->language_id;
        $blog->main_image = $request->education_blog_image;
        $blog->title = $request->title;
        $blog->title_font_size= $request->title_font_size;
        $blog->title_font_style= $request->title_font_style;
        $blog->slug = $slug;
        $blog->education_category_id = $request->category;
        $blog->content = $request->content;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->meta_description = $request->meta_description;
        $blog->serial_number = $request->serial_number;
        $blog->comment_visibility = $request->comment_visibility;
        $blog->publish_at = $request->publish_at;
        $blog->save();

        (new EducationBlogTag)->saveUpdateTags($blog,$input);

        Session::flash('success', 'Article added successfully!');
        return "success";
    }

    public function update(Request $request)
    {
        $input = $request->all();

        $slug = make_slug($request->title);
        $blog = EducationBlog::findOrFail($request->blog_id);

        $rules = [
            'title' => 'required|max:255',
            'category' => 'required',
            'content' => 'required',
            'serial_number' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $blog = EducationBlog::findOrFail($request->blog_id);
        $blog->title = $request->title;
        $blog->title_font_size= $request->title_font_size;
        $blog->title_font_style= $request->title_font_style;
        $blog->slug = $slug;
        $blog->education_category_id = $request->category;
        $blog->content = $request->content;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->meta_description = $request->meta_description;
        $blog->serial_number = $request->serial_number;
        $blog->comment_visibility = $request->comment_visibility;
        $blog->publish_at = $request->publish_at;
        $blog->save();

        (new EducationBlogTag)->saveUpdateTags($blog,$input);

        Session::flash('success', 'Article updated successfully!');
        return "success";
    }

    public function delete(Request $request)
    {

        \App\EducationBlogTag::where('education_blog_id',$request->blog_id)->delete();

        $blog = EducationBlog::findOrFail($request->blog_id);
        @unlink('assets/front/img/educationblogs/' . $blog->main_image);
        $blog->delete();

        Session::flash('success', 'Article deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {

            \App\EducationBlogTag::where('education_blog_id',$id)->delete();
            
            $blog = EducationBlog::findOrFail($id);
            @unlink('assets/front/img/educationblogs/' . $blog->main_image);
            $blog->delete();
        }

        Session::flash('success', 'Article deleted successfully!');
        return "success";
    }

    public function getcats($langid)
    {
        $bcategories = EducationCategory::where('language_id', $langid)->get();

        return $bcategories;
    }

    public function getTagsDropdown(Request $request){

        $input = $request->all();
        $tags = array();
        $selectedTag = array();

        if (isset($input['blog_id']) && !empty($input['blog_id'])) {
            
            $educationBlog = EducationBlog::with(['educationBlogTag'])->where('id',$input['blog_id'])->firstOrFail();

            $tags = EducationTag::where('language_id',$educationBlog->language_id)->get();
            
            if (!$educationBlog->educationBlogTag->isEmpty()) {
                
                $selectedTag = $educationBlog->educationBlogTag->pluck('education_tag_id')->toArray();
            }

        }elseif(isset($input['langid']) && !empty($input['langid'])) {

            $tags = EducationTag::where('language_id',$input['langid'])->get();
        }

        return view('admin.education.blog._get_tags_dropdown',compact('tags','selectedTag'));
    }   
}
