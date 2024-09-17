<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\Slider;
use App\Scategory;
use App\Jcategory;
use App\Portfolio;
use App\Feature;
use App\Point;
use App\Statistic;
use App\Testimonial;
use App\Gallery;
use App\Faq;
use App\Page;
use App\Member;
use App\Blog;
use App\Partner;
use App\Client;
use App\Service;
use App\Job;
use App\Archive;
use App\Bcategory;
use App\Subscriber;
use App\Quote;
use App\Language;
use App\Package;
use App\PackageOrder;
use App\Admin;
use App\CalendarEvent;
use App\Mail\ContactMail;
use App\Mail\OrderPackage;
use App\Mail\OrderQuote;
use App\OfflineGateway;
use App\PackageInput;
use App\PaymentGateway;
use App\QuoteInput;
use App\RssFeed;
use App\RssPost;
use Session;
use Validator;
use Config;
use Mail;
use PDF;
use App\FormBuilder;
use App\EducationCategory;
use App\EducationBlogTag;
use App\EducationTag;
use App\EducationBlog;
use App\EducationBlogComment;
use App\Models\Step;
use App\Models\FreeAppSection;
use App\Social;
use Mpdf\Tag\Select;

use function Laravel\Prompts\select;

class FrontendController extends Controller
{
    public function __construct()
    {
        $bs = BS::first();
        $be = BE::first();

        // Config::set('captcha.sitekey', \Crypt::decryptString($bs->google_recaptcha_site_key));
        // Config::set('captcha.secret', \Crypt::decryptString($bs->google_recaptcha_secret_key));
    }

    public function index()
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $lang_id = $currentLang->id;

        $data['sliders'] = Slider::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['portfolios'] = Portfolio::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->limit(10)->get();
        $data['portfolio60'] = $data['portfolios']->firstWhere('id', 60);
        $data['portfolioimgs'] = $data['portfolio60'] ? $data['portfolio60']->portfolio_images()->pluck('image') : collect();
        $data['features'] = Feature::with(['page:id,slug'])->where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['points'] = Point::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['statistics'] = Statistic::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['testimonials'] = Testimonial::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['faqs'] = Faq::orderBy('serial_number', 'ASC')->get();
        $data['steps']=Step::orderBy('serial_number', 'ASC')->get();
        $data['members'] = Member::where('language_id', $lang_id)->where('feature', 1)->get();
        $data['blogs'] = Blog::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->limit(6)->get();
        $data['partners'] = Partner::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();
        $data['packages'] = Package::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->get();
        $data['socials']=Social::orderBy('serial_number', 'ASC')->get();
        $data['FreeAppSections']=FreeAppSection::with('freeAppsectionImages')->first();
        // $data['inactive_packages'] = Package::where('language_id', $lang_id)->where('feature', 0)->orderBy('serial_number', 'ASC')->get();
        $data['scategories'] = Scategory::where('language_id', $lang_id)->where('feature', 1)->where('status', 1)->orderBy('serial_number', 'ASC')->get();
        if (!hasCategory($be->theme_version)) {
            $data['services'] = Service::where('language_id', $lang_id)->where('feature', 1)->orderBy('serial_number', 'ASC')->get();
        }

        $version = getVersion($be->theme_version);
        $data['version'] = $version;

        if ($version == 'default' || $version == 'dark') {
            return view('front.default.index', $data);
        }
        elseif($version ==  'apper-theme'){
            $page= Page::select('id')->where('title','Youtextme')->first();
            $data['page_feature']= Feature::select('title','icon','subtitle')->where('page_id',$page->id)->get();
            return view('front.apper-theme.index', $data);
        }
    }

    public function services(Request $request)
    {
        return $this->getServiceListCommonFunction($request);
    }

    public function serviceCategory(Request $request,$serviceSlug){

        return $this->getServiceListCommonFunction($request,$serviceSlug);
    }

    public function getServiceListCommonFunction($request,$serviceSlug = null){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $data['sCategorySlug'] = "";
        if ($serviceSlug !=null) {

            $getInfo = Scategory::where('slug',$serviceSlug)->firstOrFail();

            $category = $getInfo->id;
            $data['sCategorySlug'] = $serviceSlug;

        }else{

            $category = $request->category;
        }
        $term = $request->term;

        if (!empty($category)) {

            $data['category'] = Scategory::findOrFail($category);
            $data['sCategorySlug'] = $data['category']->slug;
        }

        $data['services'] = Service::when($category, function ($query, $category) {
            return $query->where('scategory_id', $category);
        })->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(6);


        $version = getVersion($be->theme_version);

        if ($version == 'default' || $version == 'dark') {
            return view('front.default.services', $data);
        }
    }

    public function packages()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $data['packages'] = Package::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->get();

        $version = getVersion($be->theme_version);

        if ($version == 'default' || $version == 'dark') {
            return view('front.default.packages', $data);
        }
    }

    public function portfolios(Request $request,$slug = null)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;
        $be = $currentLang->basic_extended;

        $category = $slug;
        if (isset($category) && !empty($category)) {

            $scategoryObj = Scategory::where('slug',$category)->firstOrFail();
            $category = $scategoryObj->id;
        }

        if (!empty($category)) {
            $data['category'] = Scategory::findOrFail($category);
        }

        $data['portfolios'] = Portfolio::when($category, function ($query, $category) {
            $serviceIdArr = [];
            $serviceids = Service::select('id')->where('scategory_id', $category)->get();

            foreach ($serviceids as $key => $serviceid) {
                $serviceIdArr[] = $serviceid->id;
            }
            return $query->whereIn('service_id', $serviceIdArr);
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC');

        $version = getVersion($be->theme_version);

        if ($version == 'default' || $version == 'dark') {
            $data['portfolios'] = $data['portfolios']->paginate(9);
            return view('front.default.portfolios', $data);
        }
    }

    public function portfoliodetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['portfolio'] = Portfolio::where('slug',$slug)->firstOrFail();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.portfolio-details', $data);
    }

    public function servicedetails($slug)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['service'] = Service::where('slug',$slug)->firstOrFail();

        if ($data['service']->details_page_status == 0) {
            return back();
        }

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.service-details', $data);

    }

    public function careerdetails($slug, $id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['jcats'] = $currentLang->jcategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();

        $data['job'] = Job::findOrFail($id);

        $data['jobscount'] = Job::when($currentLang, function ($query, $currentLang) {
                                return $query->where('language_id', $currentLang->id);
                                })->count();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;


        return view('front.career-details', $data);

    }

    public function blogs(Request $request)
    {
        return $this->getBlogListCommonFunction($request);
    }

    /**
     * This function is used to get blog list category wise
     */
    public function blogCategory(Request $request,$slug)
    {
        return $this->getBlogListCommonFunction($request,$slug);
    }

    /**
     * This function is used to get all blog and blog list category wise
     */
    public function getBlogListCommonFunction($request,$catSlug = null){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $data['currentLang'] = $currentLang;

        $lang_id = $currentLang->id;
        $be = $currentLang->basic_extended;
        $data['catSlugData'] = null;
        if ($catSlug !=null) {

            $category = $catSlug;
            $data['catSlugData'] = $category;

        }else{

            $category = $request->category;
        }

        $catid = null;
        if (!empty($category)) {
            $data['category'] = Bcategory::where('slug', $category)->firstOrFail();
            $catid = $data['category']->id;
            $data['catSlugData'] = $data['category']->slug;
        }
        $term = $request->term;
        $tag = $request->tag;
        $month = $request->month;
        $year = $request->year;
        $data['archives'] = Archive::orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('language_id', $lang_id)->where('status', 1)->orderBy('serial_number', 'ASC')->get();
        if (!empty($month) && !empty($year)) {
            $archive = true;
        } else {
            $archive = false;
        }

        $data['blogs'] = Blog::when($catid, function ($query, $catid) {
            return $query->where('bcategory_id', $catid);
        })
        ->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })
        ->when($tag, function ($query, $tag) {
            return $query->where('tags', 'like', '%' . $tag . '%');
        })
        ->when($archive, function ($query) use ($month, $year) {
            return $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        })
        ->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })
        ->where(function($qp){

            $qp->where('publish_at','<=',\Carbon\Carbon::now())
                ->orWhere('publish_at');
        })
        ->orderBy('serial_number', 'ASC')->paginate(6);

        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;


        return view('front.blogs', $data);
    }

    public function getBlogYearMonthWise($year,$month){

        if (session()->has('lang')) {

            $currentLang = Language::where('code', session()->get('lang'))->first();

        } else {

            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['currentLang'] = $currentLang;

        $lang_id = $currentLang->id;
        $be = $currentLang->basic_extended;

        $data['catSlugData'] = null;

        $month = $month;
        $year = $year;

        $data['archives'] = Archive::orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('language_id', $lang_id)->where('status', 1)->orderBy('serial_number', 'ASC')->get();

        if (!empty($month) && !empty($year)) {

            $archive = true;

        } else {

            $archive = false;
        }

        $data['blogs'] = Blog::when($archive, function ($query) use ($month, $year) {
            return $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        })
        ->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(6);

        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        $data['queryYear'] = $year;
        $data['queryMonth'] = $month;

        return view('front.blogs', $data);
    }

    public function blogdetails($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;


        $data['blog'] = Blog::where('slug',$slug)
                            ->where(function($qp){

                                $qp->where('publish_at','<=',\Carbon\Carbon::now())
                                    ->orWhere('publish_at');
                            })
                            ->firstOrFail();

        $data['archives'] = Archive::orderBy('id', 'DESC')->get();
        $data['bcats'] = Bcategory::where('status', 1)->where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        $data['slug'] = $slug;

        return view('front.blog-details', $data);
    }

    public function rss(){
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;
        $data['categories'] = RssFeed::where('language_id',$lang_id)->orderBy('id','desc')->get();
        $data['rss_posts']  = RssPost::where('language_id',$lang_id)->orderBy('id','desc')->paginate(4);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'default' || $version == 'dark') {
            return view('front.default.rss', $data);
        }
    }

    public function rssdetails($slug, $id){
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;
        $data['categories'] = RssFeed::where('language_id',$lang_id)->orderBy('id','desc')->get();
        $data['post']  = RssPost::findOrFail($id);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.rss-details', $data);
    }

    public function rcatpost($id){
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['cat_id'] = $id;
        $data['categories'] = RssFeed::where('language_id',$lang_id)->orderBy('id','desc')->get();
        $data['posts']  = RssFeed::findOrFail($id)->rss()->orderBy('id', 'DESC')->paginate(4);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'default' || $version == 'dark') {
            return view('front.default.rcatpost', $data);
        }
    }

    public function clients()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        $data['clients'] = Client::where('language_id',$currentLang->id)
                                    ->orderBy('serial_number', 'ASC')
                                    ->get();

        return view('front.clients', $data);
    }

    public function partners()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;


        $data['partners'] = Partner::where('language_id',$currentLang->id)
                                    ->orderBy('serial_number', 'ASC')
                                    ->get();

        return view('front.partner', $data);
    }

    public function contact()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }
        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        $form_builder = FormBuilder::where('id',FormBuilder::CONTACT_CONSTANT)->firstOrFail();

        $data['bodyForm'] = '<div id="form_builder_rebootcs" data-id="'.$form_builder->id.'"></div>';

        if (session()->has('lang') && $version=='default') {
            $data['langg'] = Language::where('code', session('lang'))->first();
            return view('front.contact', $data);
        }
        else if( $version=='apper-theme')
        {
            return view('front.apper-theme.contact',$data);
        }

        return view('front.contact', $data);
    }

    public function sendmail(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;

        $data = $request->all();

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ];

        if ($bs->is_recaptcha == 1) {

            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $form_data = new \App\FormSubmission();
        $form_data->form_id = $data['form_id'];
        unset($data['form_id']);
        if(isset($data['g-recaptcha-response'])){

            unset($data['g-recaptcha-response']);
        }
        $form_data->json_data = json_encode($data);
        $form_data->save();

        $be =  BE::firstOrFail();
        $from = $request->email;
        $to = $be->to_mail;
        $subject = $request->subject;
        $message = $request->message;

        try {

            $mail = new PHPMailer(true);
            $mail->setFrom($from, $request->name);
            $mail->addAddress($to);     // Add a recipient

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();

        } catch(\Exception $e) {
            // die($e->getMessage());
        }

        $fromData = \App\FormBuilder::with(['formBuilderToEmail'=>function($query){

                                        $query->has('user');
                                    }])
                                    ->where('id',$form_data->form_id)->first();
        if (isset($fromData) && !$fromData->formBuilderToEmail->isEmpty()) {

            $emailTemplate = \App\EmailTemplate::where('id',\App\EmailTemplate::CONTACT_US_INQUIRY)
                                    ->where('status',1)
                                    ->first();

            if (isset($emailTemplate) && !empty($emailTemplate)) {

                try {

                    $mail = new PHPMailer(true);

                    if($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_SMTP){

                        $mail->isSMTP();

                    }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_MAIL){

                        $mail->isMail();

                    }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_IS_SEND_MAIL){

                        $mail->isSendMail();
                    }
                    $mail->Host       = $be->smtp_host;
                    $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;
                    $mail->Username   = $be->smtp_username;
                    $mail->Password   = \Crypt::decryptString($be->smtp_password);
                    $mail->SMTPSecure = $be->encryption;
                    $mail->Port       = $be->smtp_port;

                    //Recipients
                    $mail->setFrom($be->from_mail, $be->from_name);

                    foreach($fromData->formBuilderToEmail as $key=>$v){

                        $mail->addAddress($v->user->email);     // Add a recipient
                    }

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = $emailTemplate->subject;

                    $bodyMain = view('mail.form_builder_common',compact('fromData','data'))->render();

                    $emailTemplate->body_content = str_replace(array('###INQUIRY_NAME###','###DYNAMIC_CONTENT###'), array($fromData->name,$bodyMain), $emailTemplate->body_content);

                    $mail->Body = view('email_template.transactional.common_email_template',compact('emailTemplate'));

                    $mail->send();

                } catch(\Exception $e) {
                    // die($e->getMessage());

                }
            }
        }

        Session::flash('success', 'Email sent successfully!');

        return "success";
    }

    public function subscribe(Request $request)
    {
            $rules = [
                'email' => 'required|email|unique:subscribers'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $validator->getMessageBag()->add('error', 'true');
                return response()->json(['errors' => $validator->errors(), 'id' => 'blog']);
            }

        $subsc = new Subscriber;
        $subsc->email = $request->email;
        $subsc->save();

        return "success";
    }

    public function quote()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;

        if ($bs->is_quote == 0) {
            return view('errors.404');
        }

        $lang_id = $currentLang->id;

        $data['services'] = Service::all();
        $data['inputs'] = QuoteInput::where('language_id', $lang_id)->get();
        $data['ndaIn'] = QuoteInput::find(10);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.quote', $data);
    }

    public function sendquote(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $quote_inputs = $currentLang->quote_inputs;

        $nda = $request->file('nda');
        $ndaIn = QuoteInput::find(10);
        $allowedExts = array('doc', 'docx', 'pdf', 'rtf', 'txt', 'zip', 'rar');

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'nda' => [
                function ($attribute, $value, $fail) use ($nda, $allowedExts) {

                    $ext = $nda->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only doc, docx, pdf, rtf, txt, zip, rar files are allowed");
                    }

                },

            ],
        ];


        if ($ndaIn->required == 1 && $ndaIn->active == 1) {
            if (!$request->hasFile('nda')) {
                $rules["nda"] = 'required';
            }
        }


        foreach ($quote_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"] = 'required';
            }
        }

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $fields = [];
        foreach ($quote_inputs as $key => $input) {
            $in_name = $input->name;
            if ($request["$in_name"]) {
                $fields["$in_name"] = $request["$in_name"];
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/","/",$jsonfields);


        $quote = new Quote;
        $quote->name = $request->name;
        $quote->email = $request->email;
        $quote->fields = $jsonfields;

        if ($request->hasFile('nda')) {
            $filename = uniqid() . '.' . $nda->getClientOriginalExtension();
            $nda->move('assets/front/ndas/', $filename);
            $quote->nda = $filename;
        }

        $quote->save();


        // send mail to Admin
        $from = $request->email;
        $to = $be->to_mail;
        $subject = "Quote Request Received";

        $fields = json_decode($quote->fields, true);

        $emailTemplate = \App\EmailTemplate::where('id',\App\EmailTemplate::REQUEST_QUOTA)
                                    ->where('status',1)
                                    ->first();


        if (isset($emailTemplate) && !empty($emailTemplate)) {

            try {

                $mail = new PHPMailer(true);

                if($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_SMTP){

                    $mail->isSMTP();

                }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_MAIL){

                    $mail->isMail();

                }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_IS_SEND_MAIL){

                    $mail->isSendMail();
                }
                $mail->Host       = $be->smtp_host;
                $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;
                $mail->Username   = $be->smtp_username;
                $mail->Password   = \Crypt::decryptString($be->smtp_password);
                $mail->SMTPSecure = $be->encryption;
                $mail->Port       = $be->smtp_port;

                $mail->setFrom($from, $request->name);
                $mail->addAddress($to);     // Add a recipient

                // Content
                $mail->isHTML(true);  // Set email format to HTML

                $mail->Subject = $subject;
                $bodyMain = view('email_template.transactional.request_quote_common',compact('request'))->render();

                $emailTemplate->body_content = str_replace(array('###DYNAMIC_CONTENT###'), array($bodyMain), $emailTemplate->body_content);

                $mail->Body = view('email_template.transactional.common_email_template',compact('emailTemplate'));

                $mail->send();
            } catch(\Exception $e) {
                // die($e->getMessage());
            }
        }


        Session::flash('success', 'Quote request sent successfully');
        return back();
    }

    public function team()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['members'] = Member::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->get();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'default' || $version == 'dark') {
            return view('front.default.team', $data);
        }
    }

    public function career(Request $request)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['jcats'] = $currentLang->jcategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();


        $category = $request->category;
        $term = $request->term;

        if (!empty($category)) {
            $data['category'] = Jcategory::findOrFail($category);
        }

        $data['jobs'] = Job::when($category, function ($query, $category) {
            return $query->where('jcategory_id', $category);
        })->when($term, function ($query, $term) {
            return $query->where('title', 'like', '%' . $term . '%');
        })->when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->orderBy('serial_number', 'ASC')->paginate(4);

        $data['jobscount'] = Job::when($currentLang, function ($query, $currentLang) {
            return $query->where('language_id', $currentLang->id);
        })->count();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.career', $data);
    }

    public function calendar() {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $events = CalendarEvent::get();
        $formattedEvents = [];

        foreach ($events as $key => $event) {

            $formattedEvents["$key"]['title'] = $event->title;
            $event_note = $event->event_note;
            $formattedEvents["$key"]['description'] = strip_tags($event->event_note);

            if($event->is_recurring == 1){

                $startDate = strtotime($event->start_date);
                $formattedEvents["$key"]['start'] = date('Y-m-d H:i' ,$startDate);

                $endDate = strtotime($event->end_date);
                $formattedEvents["$key"]['end'] = date('Y-m-d H:i' ,$endDate);

                $formattedEvents["$key"]['color'] = "#f09238"; // yellow

            }else{

                if ($event->recurring_type == 'yearly') {

                    $formattedEvents["$key"]['rrule']['freq'] = 'yearly';

                    // 1 On // 2 On the
                    if ($event->yearly_type == 1) {

                        $formattedEvents["$key"]['rrule']['bymonth'] = $event->yearly_on_month;
                        $formattedEvents["$key"]['rrule']['bymonthday'] = $event->yearly_on_day;

                    }elseif($event->yearly_type == 2){

                        $formattedEvents["$key"]['rrule']['bysetpos'] = [$event->yearly_on_the_setpos];
                        $formattedEvents["$key"]['rrule']['byyearday'] = [$event->yearly_on_the_mixday];
                        $formattedEvents["$key"]['rrule']['bymonth'] = $event->yearly_on_the_month;
                    }

                    $formattedEvents["$key"]['color'] = "#ff4081";

                }elseif($event->recurring_type == 'monthly'){

                    $formattedEvents["$key"]['rrule']['freq'] = 'monthly';
                    $formattedEvents["$key"]['rrule']['interval'] = $event->monthly_every_month;

                    // 1 On day // 2 On the
                    if ($event->monthly_type == 1) {

                        $formattedEvents["$key"]['rrule']['bymonthday'] = $event->monthly_on_day_days;

                    }elseif($event->monthly_type == 2){

                        $formattedEvents["$key"]['rrule']['bysetpos'] = [$event->monthly_on_the_setpos];
                        $formattedEvents["$key"]['rrule']['bymonthday'] = [$event->monthly_on_the_mixdays];
                    }

                    $formattedEvents["$key"]['color'] = "#6256a9";

                }elseif($event->recurring_type == 'weekly'){
                    // dd($event->weekly_days);
                    $formattedEvents["$key"]['rrule']['freq'] = 'weekly';
                    $formattedEvents["$key"]['rrule']['interval'] = $event->weekly_every_week;
                    $formattedEvents["$key"]['rrule']['byweekday'] = [$event->weekly_days];
                    $formattedEvents["$key"]['color'] = "#04aec6"; // ferozi

                }elseif ($event->recurring_type == 'hourly') {

                    $formattedEvents["$key"]['rrule']['freq'] = 'hourly';
                    $formattedEvents["$key"]['rrule']['interval'] = $event->hourly_hour;
                    $formattedEvents["$key"]['color'] = "#3d5afe"; // blue

                }elseif($event->recurring_type == 'daily') {

                    $formattedEvents["$key"]['rrule']['freq'] = 'daily';
                    $formattedEvents["$key"]['rrule']['interval'] = $event->daily_days;
                    $formattedEvents["$key"]['color'] = "#000";
                }

                if ($event->recurring_end_action == 'after') {

                    $formattedEvents["$key"]['rrule']['count'] = $event->end_after_count;

                }elseif($event->recurring_end_action == 'date'){

                    $formattedEvents["$key"]['rrule']['until'] = $event->end_on_date;
                }

            }
        }

        $data["formattedEvents"] = $formattedEvents;
        $be = $currentLang->basic_extended;
        $bs = $currentLang->basic_setting;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        $data['themeSetting'] = $bs;
        return view('front.calendar', $data);
    }

    public function gallery()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['galleries'] = Gallery::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->paginate(12);

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.gallery', $data);
    }

    public function faq()
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['faqs'] = Faq::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.faq', $data);
    }

    public function dynamicPage($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['page'] = Page::where('slug',$slug)->firstOrFail();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        $lang_id = $currentLang->id;

        $data['faqs'] = \App\FaqCategory::with(['customerFaq'=>function($query){

                                            $query->where('feature',1)
                                                  ->orderBy('serial_number', 'ASC');

                                        }])
                                        ->where('feature',1)
                                        ->where('language_id',$lang_id)
                                        ->whereHas('customerFaq',function($query){

                                            $query->where('feature',1)
                                                  ->orderBy('serial_number', 'ASC');

                                        })
                                        ->get();

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        $form_builders = FormBuilder::get();
        foreach ($form_builders as $form_builder) {
            if(strpos($data['page']->body, $form_builder->short_code) !== false) {
                $data['page']->body = str_replace($form_builder->short_code, '<div id="form_builder_rebootcs" data-id="'.$form_builder->id.'"></div>', $data['page']->body);
            }
        }

        if($data['page']->id == \App\Page::IMAGE_TO_PDF_CONSTANT){

            return view('tools.image-to-pdf.index', $data);

        }else if($data['page']->id == \App\Page::METADATA_VIEWER_CONSTANT){

            return view('tools.meta-viewer', $data);

        }
        else if($version=='apper-theme')
        {
            return view('front.apper-theme.dynamic',$data);
        }
        else{

            return view('front.dynamic', $data);
        }

    }

    public function changeLanguage($lang)
    {

        session()->put('lang', $lang);
        app()->setLocale($lang);

        $be = be::first();
        $version = getVersion($be->theme_version);

        return redirect()->route('front.index');
    }

    public function packageorder($id)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $data['package'] = Package::where('slug',$id)->firstOrFail();

        if ($data['package']->order_status == 0) {
            return view('errors.404');
        }

        $data['inputs'] = PackageInput::where('language_id', $lang_id)->get();
        $data['gateways']  = PaymentGateway::whereStatus(1)->whereType('automatic')->get();
        $data['ogateways']  = OfflineGateway::wherePackageOrderStatus(1)->orderBy('serial_number', 'ASC')->get();
        $paystackData = PaymentGateway::whereKeyword('paystack')->first();
        $data['paystack'] = $paystackData->convertAutoData();
        $data['ndaIn'] = PackageInput::find(1);

        $be = be::first();
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.package-order', $data);
    }


    public function submitorder(Request $request)
    {

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;
        $be = $currentLang->basic_extended;
        $package_inputs = $currentLang->package_inputs;

        $nda = $request->file('nda');
        $ndaIn = PackageInput::find(1);
        $allowedExts = array('doc', 'docx', 'pdf', 'rtf', 'txt', 'zip', 'rar');

        $messages = [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'package_id' => 'required',
            'nda' => [
                function ($attribute, $value, $fail) use ($nda, $allowedExts) {

                    $ext = $nda->getClientOriginalExtension();
                    if (!in_array($ext, $allowedExts)) {
                        return $fail("Only doc, docx, pdf, rtf, txt, zip, rar files are allowed");
                    }

                }
            ],
        ];

        if ($ndaIn->required == 1 && $ndaIn->active == 1) {
            if (!$request->hasFile('nda')) {
                $rules["nda"] = 'required';
            }
        }

        foreach ($package_inputs as $input) {
            if ($input->required == 1) {
                $rules["$input->name"] = 'required';
            }
        }

        if ($bs->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        $fields = [];
        foreach ($package_inputs as $key => $input) {
            $in_name = $input->name;
            if ($request["$in_name"]) {
                $fields["$in_name"] = $request["$in_name"];
            }
        }
        $jsonfields = json_encode($fields);
        $jsonfields = str_replace("\/","/",$jsonfields);

        $package = Package::findOrFail($request->package_id);

        $in = $request->all();
        $in['name'] = $request->name;
        $in['email'] = $request->email;
        $in['fields'] = $jsonfields;

        if ($request->hasFile('nda')) {
            $filename = uniqid() . '.' . $nda->getClientOriginalExtension();
            $nda->move('assets/front/ndas/', $filename);
            $in['nda'] = $filename;
        }

        $in['package_title'] = $package->title;
        $in['package_currency'] = $package->currency;
        $in['package_price'] = $package->price;
        $in['package_description'] = $package->description;
        $fileName = str_random(4).time().'.pdf';
        $in['invoice'] = $fileName;
        $po = PackageOrder::create($in);


        // saving order number
        $po->order_number = $po->id + 1000000000;
        $po->save();


        // sending datas to view to make invoice PDF
        $fields = json_decode($po->fields, true);
        $data['packageOrder'] = $po;
        $data['fields'] = $fields;


        // generate pdf from view using dynamic datas
        PDF::loadView('pdf.package', $data)->save('assets/front/invoices/' . $fileName);


        // Send Mail to Buyer
        $mail = new PHPMailer(true);

        if ($be->is_smtp == 1) {

            $emailTemplate = \App\EmailTemplate::where('id',\App\EmailTemplate::PACKAGE_ORDER_FOR_BUYER)
                                    ->where('status',1)
                                    ->first();

            if (isset($emailTemplate) && !empty($emailTemplate)) {

                try {
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    if($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_SMTP){

                        $mail->isSMTP();

                    }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_MAIL){

                        $mail->isMail();

                    }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_IS_SEND_MAIL){

                        $mail->isSendMail();
                    }                                        // Send using SMTP
                    $mail->Host       = $be->smtp_host;                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;                                // Enable SMTP authentication
                    $mail->Username   = $be->smtp_username;                     // SMTP username
                    $mail->Password   = \Crypt::decryptString($be->smtp_password);                               // SMTP password
                    $mail->SMTPSecure = $be->encryption;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = $be->smtp_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom($be->from_mail, $be->from_name);
                    $mail->addAddress($request->email, $request->name);     // Add a recipient

                    // Attachments
                    $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML

                    $emailTemplate->subject = str_replace(array('###PACKAGE_TITLE###'), array($package->title), $emailTemplate->subject);
                    $mail->Subject = $emailTemplate->subject;

                    $emailTemplate->body_content = str_replace(array('###NAME###'), array($request->name), $emailTemplate->body_content);
                    $mail->Body = view('email_template.transactional.common_email_template',compact('emailTemplate'));

                    $mail->send();
                } catch (Exception $e) {
                    // die($e->getMessage());
                }
            }

        }

        // send mail to Admin

        $emailTemplate = \App\EmailTemplate::where('id',\App\EmailTemplate::PACKAGE_ORDER_FOR_ADMIN)
                                    ->where('status',1)
                                    ->first();

        if (isset($emailTemplate) && !empty($emailTemplate)) {

            try {

                $mail = new PHPMailer(true);
                if($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_SMTP){

                    $mail->isSMTP();

                }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_MAIL){

                    $mail->isMail();

                }elseif($be->mail_driver == \App\BasicExtended::MAIL_DRIVER_IS_SEND_MAIL){

                    $mail->isSendMail();
                }
                $mail->Host       = $be->smtp_host;
                $mail->SMTPAuth   = ($be->is_smtp_auth == 1) ? true : false;
                $mail->Username   = $be->smtp_username;
                $mail->Password   = \Crypt::decryptString($be->smtp_password);
                $mail->SMTPSecure = $be->encryption;
                $mail->Port       = $be->smtp_port;

                $mail->setFrom($po->email, $po->name);
                $mail->addAddress('gcb1196@gmail.com');     // Add a recipient
                // $mail->addAddress($be->from_mail);     // Add a recipient

                // Attachments
                $mail->addAttachment('assets/front/invoices/' . $fileName);         // Add attachments

                // Content
                $mail->isHTML(true);  // Set email format to HTML

                $emailTemplate->subject = str_replace(array('###PACKAGE_TITLE###'), array($package->title), $emailTemplate->subject);
                $mail->Subject = $emailTemplate->subject;

                $emailTemplate->body_content = str_replace(array('###ORDER_NUMBER###'), array($po->order_number), $emailTemplate->body_content);
                $mail->Body = view('email_template.transactional.common_email_template',compact('emailTemplate'));

                $mail->send();

            } catch(\Exception $e) {
                // die($e->getMessage());
            }
        }


        Session::flash('success', 'Order placed successfully!');
        return redirect()->route('front.packageorder.confirmation', [$package->id, $po->id]);
    }


    public function orderConfirmation($packageid, $packageOrderId) {
        $data['package'] = Package::findOrFail($packageid);
        $packageOrder = PackageOrder::findOrFail($packageOrderId);

        $data['packageOrder'] = $packageOrder;
        $data['fields'] = json_decode($packageOrder->fields, true);

        $be = be::first();
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        return view('front.order-confirmation', $data);
    }


    public function loadpayment($slug,$id)
    {
        $data['payment'] = $slug;
        $data['pay_id'] = $id;
        $gateway = '';
        if($data['pay_id'] != 0 && $data['payment'] != "offline" ) {
            $gateway = PaymentGateway::findOrFail($data['pay_id']);
        } else {
            $gateway = OfflineGateway::findOrFail($data['pay_id']);
        }
        $data['gateway'] = $gateway;

        return view('front.load.payment', $data);

    }    // Redirect To Checkout Page If Payment is Cancelled

    public function paycancle($packageid){
        return redirect()->route('front.packageorder.index', $packageid)->with('error',__('Payment Cancelled.'));
    }

    // Redirect To Success Page If Payment is Comleted

    public function payreturn($packageid){
        return redirect()->route('front.packageorder.index', $packageid)->with('success',__('Pament Compelted!'));
    }

    public function getSingleCalendar($slug){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;

        if ($bs->show_calendar_public_facing == 0) {

            return redirect()->back();
        }

        $lang_id = $currentLang->id;

        $calendar = \App\Calendar::with(['addedEvents'])
                                        ->where('view',1)
                                        ->where('slug',$slug)
                                        ->firstOrFail();
        $formattedEvents = [];

        if (isset($calendar) && !$calendar->addedEvents->isEmpty()) {

            foreach($calendar->addedEvents as $key => $event) {

                if ($event->calendarEvent !=null) {

                    $formattedEvents["$key"]['title'] = $event->calendarEvent->title;
                    $event_note = $event->event_note;
                    $formattedEvents["$key"]['description'] = strip_tags($event->event_note);

                    if($event->calendarEvent->is_recurring == 1){

                        $startDate = strtotime($event->calendarEvent->start_date);
                        $formattedEvents["$key"]['start'] = date('Y-m-d H:i' ,$startDate);

                        $endDate = strtotime($event->calendarEvent->end_date);
                        $formattedEvents["$key"]['end'] = date('Y-m-d H:i' ,$endDate);

                        $formattedEvents["$key"]['color'] = "#f09238"; // yellow

                    }else{

                        if ($event->calendarEvent->recurring_type == 'yearly') {

                            $formattedEvents["$key"]['rrule']['freq'] = 'yearly';

                            // 1 On // 2 On the
                            if ($event->calendarEvent->yearly_type == 1) {

                                $formattedEvents["$key"]['rrule']['bymonth'] = $event->calendarEvent->yearly_on_month;
                                $formattedEvents["$key"]['rrule']['bymonthday'] = $event->calendarEvent->yearly_on_day;

                            }elseif($event->calendarEvent->yearly_type == 2){

                                $formattedEvents["$key"]['rrule']['bysetpos'] = [$event->calendarEvent->yearly_on_the_setpos];
                                $formattedEvents["$key"]['rrule']['byyearday'] = [$event->calendarEvent->yearly_on_the_mixday];
                                $formattedEvents["$key"]['rrule']['bymonth'] = $event->calendarEvent->yearly_on_the_month;
                            }

                            $formattedEvents["$key"]['color'] = "#ff4081";

                        }elseif($event->calendarEvent->recurring_type == 'monthly'){

                            $formattedEvents["$key"]['rrule']['freq'] = 'monthly';
                            $formattedEvents["$key"]['rrule']['interval'] = $event->calendarEvent->monthly_every_month;

                            // 1 On day // 2 On the
                            if ($event->calendarEvent->monthly_type == 1) {

                                $formattedEvents["$key"]['rrule']['bymonthday'] = $event->calendarEvent->monthly_on_day_days;

                            }elseif($event->calendarEvent->monthly_type == 2){

                                $formattedEvents["$key"]['rrule']['bysetpos'] = [$event->calendarEvent->monthly_on_the_setpos];
                                $formattedEvents["$key"]['rrule']['bymonthday'] = [$event->calendarEvent->monthly_on_the_mixdays];
                            }

                            $formattedEvents["$key"]['color'] = "#6256a9";

                        }elseif($event->calendarEvent->recurring_type == 'weekly'){
                            // dd($event->calendarEvent->weekly_days);
                            $formattedEvents["$key"]['rrule']['freq'] = 'weekly';
                            $formattedEvents["$key"]['rrule']['interval'] = $event->calendarEvent->weekly_every_week;
                            $formattedEvents["$key"]['rrule']['byweekday'] = [$event->calendarEvent->weekly_days];
                            $formattedEvents["$key"]['color'] = "#04aec6"; // ferozi

                        }elseif ($event->calendarEvent->recurring_type == 'hourly') {

                            $formattedEvents["$key"]['rrule']['freq'] = 'hourly';
                            $formattedEvents["$key"]['rrule']['interval'] = $event->calendarEvent->hourly_hour;
                            $formattedEvents["$key"]['color'] = "#3d5afe"; // blue

                        }elseif($event->calendarEvent->recurring_type == 'daily') {

                            $formattedEvents["$key"]['rrule']['freq'] = 'daily';
                            $formattedEvents["$key"]['rrule']['interval'] = $event->calendarEvent->daily_days;
                            $formattedEvents["$key"]['color'] = "#000";

                        }

                        if ($event->calendarEvent->recurring_end_action == 'after') {

                            $formattedEvents["$key"]['rrule']['count'] = $event->calendarEvent->end_after_count;

                        }elseif($event->calendarEvent->recurring_end_action == 'date'){

                            $formattedEvents["$key"]['rrule']['until'] = $event->calendarEvent->end_on_date;
                        }

                    }
                }
            }
        }

        $data["formattedEvents"] = $formattedEvents;

        $data["calendar"] = $calendar;
        $data["bs"] = $bs;

        $be = $currentLang->basic_extended;
        $bs = $currentLang->basic_setting;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;

        $data['themeSetting'] = $bs;


        return view('front.get-single-calendar', $data);
    }

    public function downloadCalender($slug){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;

        if ($bs->download_calendar == 0) {

            return redirect()->back();
        }

        $calendar = \App\Calendar::with(['addedEvents'])
                                          ->where('slug',$slug)
                                          ->where('view',1)
                                          ->firstOrFail();

        $formattedEvents = [];

        define('ICAL_FORMAT', 'Ymd\THis\Z');

        $icalObject = "BEGIN:VCALENDAR
                       VERSION:2.0
                       METHOD:PUBLISH
                       PRODID:-//Charles Oduk//Tech Events//EN\n";

        if (isset($calendar) && !$calendar->addedEvents->isEmpty()) {

            foreach($calendar->addedEvents as $key => $event) {

                if ($event->calendarEvent !=null) {

                    $startDate = strtotime($event->calendarEvent->start_date);
                    $sdate = date('Y-m-d H:i' ,$startDate);

                    $endDate = strtotime($event->calendarEvent->end_date);
                    $edate = date('Y-m-d H:i' ,$endDate);

                    $icalObject .=
                               "BEGIN:VEVENT
                               DTSTART:" . date(ICAL_FORMAT, strtotime($sdate)) . "
                               DTEND:" .  date(ICAL_FORMAT, strtotime($edate)) . "
                               DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->calendarEvent->created_at)) . "
                               SUMMARY: ". $event->calendarEvent->title ."
                               UID: ". $event->id ."
                               STATUS:" . strtoupper("Today") . "
                               LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->calendarEvent->updated_at)) . "
                               LOCATION:
                               DESCRIPTION: ". $event->calendarEvent->notes ."
                               END:VEVENT\n";
                }

            }

        }
        // close calendar
       $icalObject .= "END:VCALENDAR";

       // Set the headers
       header('Content-type: text/calendar; charset=utf-8');
       header('Content-Disposition: attachment; filename="'.$calendar->name.'.ics"');

       $icalObject = str_replace(' ', '', $icalObject);

       echo $icalObject;

    }

    public function downloadCalenderAllEvent(){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $bs = $currentLang->basic_setting;

        if ($bs->download_calendar == 0) {

            return redirect()->back();
        }

        $events = CalendarEvent::where('language_id', $currentLang->id)->get();

        $formattedEvents = [];

        define('ICAL_FORMAT', 'Ymd\THis\Z');

        $icalObject = "BEGIN:VCALENDAR
                       VERSION:2.0
                       METHOD:PUBLISH
                       PRODID:-//Charles Oduk//Tech Events//EN\n";

        if (isset($events) && !$events->isEmpty()) {

            foreach($events as $key => $event) {


                $startDate = strtotime($event->start_date);
                $sdate = date('Y-m-d H:i' ,$startDate);

                $endDate = strtotime($event->end_date);
                $edate = date('Y-m-d H:i' ,$endDate);

                $icalObject .=
                           "BEGIN:VEVENT
                           DTSTART:" . date(ICAL_FORMAT, strtotime($sdate)) . "
                           DTEND:" .  date(ICAL_FORMAT, strtotime($edate)) . "
                           DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->created_at)) . "
                           SUMMARY: ". $event->title ."
                           UID: ". $event->id ."
                           STATUS:" . strtoupper("Today") . "
                           LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
                           LOCATION:
                           DESCRIPTION: ". $event->notes ."
                           END:VEVENT\n";


            }

        }
        // close calendar
       $icalObject .= "END:VCALENDAR";

       // Set the headers
       $calendarName = "calendar";
       header('Content-type: text/calendar; charset=utf-8');
       header('Content-Disposition: attachment; filename="'.$calendarName.'.ics"');

       $icalObject = str_replace(' ', '', $icalObject);

       echo $icalObject;
    }

    /**
     * This function is used to get testimonial list
     */
    public function testimonial(Request $request){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['currentLang'] = $currentLang;
        $lang_id = $currentLang->id;
        $be = $currentLang->basic_extended;

        $version = getVersion($be->theme_version);

        $testimonials = Testimonial::where('language_id', $lang_id)->orderBy('serial_number', 'ASC')->get();

        return view('front.testimonial',compact('version','testimonials'));
    }

    /**
     * This function is used to get partner detail
     * @author Chriag Ghevariya
     */
    public function partnerDetail($slug){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['currentLang'] = $currentLang;
        $lang_id = $currentLang->id;
        $be = $currentLang->basic_extended;

        $version = getVersion($be->theme_version);

                $data['products'] = \App\Product::where('status', 1)
                                        ->where('language_id',$currentLang->id)
                                        ->take(3)
                                        ->get();

        $partnerDetail = Partner::with(['partnerProduct'=>function($query) use($currentLang){

                                         $query->whereHas('product',function($qp) use($currentLang){

                                            $qp->where('status',1)
                                                  ->where('is_featured',1)
                                                  ->where('language_id',$currentLang->id);

                                         });

                                    }])
                                    ->where('slug',$slug)
                                    ->firstOrFail();

        return view('front.partner_detail',compact('version','partnerDetail'));

    }

    /**
     * This function is used to get partner detail
     * @author Chriag Ghevariya
     */
    public function clientDetail($slug){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['currentLang'] = $currentLang;
        $lang_id = $currentLang->id;
        $be = $currentLang->basic_extended;

        $version = getVersion($be->theme_version);

        $clientDetail = Client::where('slug',$slug)
                                    ->firstOrFail();

        return view('front.client_detail',compact('version','clientDetail'));

    }

    public function getPortfolioCategoryWiseData(Request $request){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $category = \App\PortfolioCategory::where('id',$request->category_id)->first();


        $portfolios = Portfolio::with(['myPortfolioCategory'=>function($query) use($request){

                                            $query->where('category_id',$request->category_id);

                                        }])
                                        ->whereHas('myPortfolioCategory',function($query) use($request){

                                            $query->where('category_id',$request->category_id);
                                        })
                                        ->where('language_id', $lang_id)
                                        ->where('feature', 1)
                                        ->inRandomOrder()
                                        ->get();


        return view('front.portfolio_common_ajax',compact('portfolios','category'));
    }

    public function getProductTypeData(Request $request){

        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $lang_id = $currentLang->id;

        $category = \App\ProductType::where('id',$request->type_id)->first();

        $products = \App\Product::with(['productDataType'=>function($query) use($request){

                $query->where('product_type_id',$request->type_id);

            }])
            ->whereHas('productDataType',function($query) use($request){

                $query->where('product_type_id',$request->type_id);
            })
            ->where('status', 1)
            ->where('language_id',$currentLang->id)
            ->where('is_featured',1)
            ->inRandomOrder()
            ->get();

        return view('front.product_common_ajax',compact('products','category'));
    }

    public function getEventsMonthWise(Request $request){

        $input = $request->all();

        $featuredEvents = getFeaturedEvent();

        return view('front.common._get_calendar_right_section',compact('featuredEvents','input'));
    }

    // team Member Dynamic function
    public function dynamicMemberPage($slug)
    {
        if (session()->has('lang')) {
            $currentLang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currentLang = Language::where('is_default', 1)->first();
        }

        $data['page'] = Member::where('slug', $slug)->firstOrFail();

        $be = $currentLang->basic_extended;
        $version = getVersion($be->theme_version);

        if ($version == 'dark') {
            $version = 'default';
        }

        $data['version'] = $version;
        $form_builders = FormBuilder::get();
        foreach ($form_builders as $form_builder) {
            if (strpos($data['page']->body, $form_builder->short_code) !== false) {
                $data['page']->body = str_replace($form_builder->short_code, '<div id="form_builder_rebootcs" data-id="' . $form_builder->id . '"></div>', $data['page']->body);
            }
        }

        return view('front.dynamic-member', $data);

    }

}



