<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Sitemap\SitemapGenerator;
use App\Language;
use App\Sitemap;
use Illuminate\Support\Facades\Session;

class SitemapController extends Controller
{
    public function index(Request $request){
        
        $data['langs'] = Language::all();
        $data['sitemaps'] = Sitemap::orderBy('id', 'DESC')->paginate(10);
        return view('admin.sitemap.index',$data);
    }

    public function store(Request $request){
        
        $data = \App\Sitemap::first();

        if ($data == null) {

            $data = new Sitemap();

        }else{

            $data = $data;
        }

        $input = $request->all();

        $filename = 'sitemap'.'.xml';
        SitemapGenerator::create($request->sitemap_url)->writeToFile('assets/sitemaps/'.$filename);
        $input['filename']    = $filename;
        $input['sitemap_url'] = $request->sitemap_url;
        $data->fill($input)->save();

        if (env('IS_LOCAL_OR_LIVE') == 'local') {

            $pathFrom =  $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/laravel_new_template/assets/sitemaps/'.$filename;
            $pathTo =  $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/laravel_new_template/'.$filename;

        }else{

            $pathFrom =  $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/assets/sitemaps/'.$filename;
            $pathTo =  $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/'.$filename;
        }

        \File::copy($pathFrom,$pathTo);

        Session::flash('success', 'Sitemap Generate Successfully');
        return "success";
    }

    public function download(Request $request) {
        return response()->download('assets/sitemaps/'.$request->filename);
    }

    public function update(Request $request)
    {
        $data  = Sitemap::find($request->id);
        $input = $request->all();
        @unlink('assets/sitemaps/'.$data->filename);

        $filename = 'sitemap'.'.xml';
        SitemapGenerator::create($data->sitemap_url)->writeToFile('assets/sitemaps/'.$filename);
        $input['filename']  = $filename;

        $data->update($input);
        Session::flash('success', 'Feed updated successfully!');
        return back();
    }

    public function delete($id) {
    $sitemap = Sitemap::find($id);
    @unlink('assets/sitemaps/'.$sitemap->filename);
    $sitemap->delete();

    Session::flash('success', 'Sitemap file deleted successfully!');
    return back();
    }
}
