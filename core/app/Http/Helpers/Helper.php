<?php
use App\BasicSetting as BS;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Language;
use App\Page;
use App\Admin;
use App\Videos;
use Illuminate\Support\Facades\DB;

if (! function_exists('setEnvironmentValue')) {
  function setEnvironmentValue(array $values)
  {

      $envFile = app()->environmentFilePath();
      $str = file_get_contents($envFile);

      if (count($values) > 0) {
          foreach ($values as $envKey => $envValue) {

              $str .= "\n"; // In case the searched variable is in the last line without \n
              $keyPosition = strpos($str, "{$envKey}=");
              $endOfLinePosition = strpos($str, "\n", $keyPosition);
              $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

              // If key does not exist, add it
              if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                  $str .= "{$envKey}={$envValue}\n";
              } else {
                  $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
              }

          }
      }

      $str = substr($str, 0, -1);
      if (!file_put_contents($envFile, $str)) return false;
      return true;

  }
}

if(! function_exists('user_name')){
    function user_name($id){
        $data = Admin::where('id', $id)->first();
         $user_name =  $data['first_name'].' '.$data['last_name'];
        return  $user_name;
    }
}

if (! function_exists('convertUtf8')) {
    function convertUtf8( $value ) {
        return mb_detect_encoding($value, mb_detect_order(), true) === 'UTF-8' ? $value : mb_convert_encoding($value, 'UTF-8');
    }
}


if (! function_exists('make_slug')) {
    function make_slug($string) {
        $slug = preg_replace('/\s+/u', '-', trim($string));
        $slug = str_replace("/","",$slug);
        $slug = str_replace("?","",$slug);
        return $slug;
    }
}


if (! function_exists('make_input_name')) {
    function make_input_name($string) {
        return preg_replace('/\s+/u', '_', trim($string));
    }
}


if (! function_exists('getVersion')) {
    function getVersion($version) {
        $arr = explode("_", $version, 2);
        $version = $arr[0];
        return $version;
    }
}


if (! function_exists('hasCategory')) {
    function hasCategory($version) {
        if(strpos($version, "no_category") !== false){
            return false;
        } else {
            return true;
        }
    }
}

if (! function_exists('isDark')) {
    function isDark($version) {
        if(strpos($version, "dark") !== false){
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('slug_create') ) {
    function slug_create($val) {
        $slug = preg_replace('/\s+/u', '-', trim($val));
        $slug = str_replace("/","",$slug);
        $slug = str_replace("?","",$slug);
        return $slug;
    }
}


if (!function_exists('getHref') ) {
    function getHref($link) {
        $href = "#";

        if ($link["type"] == 'home') {
            $href = route('front.index');
        } else if ($link["type"] == 'services') {
            $href = route('front.services');
        } else if ($link["type"] == 'packages') {
            $href = route('front.packages');
        } else if ($link["type"] == 'portfolios') {
            $href = route('front.portfolios');
        } else if ($link["type"] == 'team') {
            $href = route('front.team');
        } else if ($link["type"] == 'career') {
            $href = route('front.career');
        } else if ($link["type"] == 'calendar') {
            $href = route('front.calendar');
        } else if ($link["type"] == 'gallery') {
            $href = route('front.gallery');
        } else if ($link["type"] == 'faq') {
            $href = route('front.faq');
        } else if ($link["type"] == 'products') {
            $href = route('front.product');
        } else if ($link["type"] == 'cart') {
            $href = route('front.cart');
        } else if ($link["type"] == 'checkout') {
            $href = route('front.checkout');
        } else if ($link["type"] == 'blogs') {
            $href = route('front.blogs');
        } else if ($link["type"] == 'rss') {
            $href = route('front.rss');
        } else if ($link["type"] == 'contact') {
            $href = route('front.contact');
        } else if ($link["type"] == 'custom') {
            if (empty($link["href"])) {
                $href = "#";
            } else {
                $href = $link["href"];
            }
        } else {
            $pageid = (int)$link["type"];
            $page = Page::find($pageid);
            $href = isset($page) ? route('front.dynamicPage', [$page->slug]) : "javascript:void(0)";
        }

        return $href;
    }
}



if (!function_exists('create_menu') ) {
    function create_menu($arr) {
        echo '<ul style="z-index: 0;">';
            foreach ($arr["children"] as $el) {

                // determine if the class is 'submenus' or not
                $class = null;
                if (array_key_exists("children", $el)) {
                    $class = 'class="submenus"';
                }


                // determine the href
                $href = getHref($el);


                echo '<li '.$class.'>';
                    echo '<a  href="'.$href.'" target="'.$el["target"].'">'.$el["text"].'</a>';
                    if (array_key_exists("children", $el)) {
                        create_menu($el);
                    }
                echo '</li>';
            }
        echo '</ul>';
    }
}



if (!function_exists('hex2rgb') ) {
    function hex2rgb( $colour ) {
        if ( $colour[0] == '#' ) {
                $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
                return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    }
}


if (!function_exists('replaceBaseUrl') ) {
    function replaceBaseUrl($html) {
        $startDelimiter = 'src="';
        $endDelimiter = '/assets/front/img/summernote';
        // $contents = array();
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($html, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($html, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $html = substr_replace($html, url('/'), $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }

        return $html;
    }
}

///azure video upload

if(!function_exists('UploadVideo')) {
    function UploadVideo($id='', $id_cms_users='',$reindex='') {

        $result = ['status'=>false];
        $result['status'] = true;
        //return  $result;
        try {
            $client = new \GuzzleHttp\Client();
            //$obj = new AdminAzureAccountsController();
            $azure_accounts = getAccounts($id_cms_users);
            // echo $reindex;exit;
            if($azure_accounts) {
                $azure_videos = DB::table('azure_videos')->select(['name', 'privacy','videoId', 'description', 'partition_video as partition', 'externalId', 'externalUrl', 'brandsCategories', 'metadata', 'language', 'videoUrl', 'fileName', 'indexingPreset', 'streamingPreset','linguisticModelId', 'sendSuccessEmail', 'personModelId', 'assetId'])->where('id', $id)->first();
                
                $azure_videos = (array)$azure_videos;
				 $url = env('AZURE_API_URL').'/'.$azure_accounts->location.'/Accounts/'.$azure_accounts->account_id.'/Videos?accessToken='.$azure_accounts->access_token;
                // echo "<pre>";print_r($azure_videos);exit();
                 /*if(empty($reindex)){
                    $url = env('AZURE_API_URL').'/'.$azure_accounts->location.'/Accounts/'.$azure_accounts->account_id.'/Videos?accessToken='.$azure_accounts->access_token;
                }else{
                
                   $url = env('AZURE_API_URL').'/'.$azure_accounts->location.'/Accounts/'.$azure_accounts->account_id.'/Videos/'.$azure_videos['videoId'].'/ReIndex?accessToken='.$azure_accounts->access_token;
                }*/
               foreach ($azure_videos as $key => $value) {
                    $url .= '&'.$key.'='.$value;
                }

               // $callbackUrl = urlencode(env('CALLBACK_URL'));

               // $url .= '&callbackUrl='.$callbackUrl;
                
                $response = $client->request('POST', $url, ['headers'=>['Content-Type'=>'multipart/form-data']]);
                if($response->getStatusCode()==200) {
                    $data = $response->getBody(); 
                    $res = json_decode($data);
                    $videoId = $res->id;
                    $update_data =
                    [
                        'videoId'=>$videoId,
                        'isOwned'=>$res->isOwned,
                        'isBase'=>$res->isBase,
                        'state'=>$res->state,
                        'processingProgress'=>$res->processingProgress,
                        'durationInSeconds'=>$res->durationInSeconds,
                        'thumbnailVideoId'=>$res->thumbnailVideoId,
                        'thumbnailId'=>($res->thumbnailId=='00000000-0000-0000-0000-000000000000')?'0':$res->thumbnailId,
                        'searchMatches'=>(empty(!$res->searchMatches)?json_encode($res->searchMatches):null),
                        'sourceLanguage'=>$res->sourceLanguage,
                        // 'callbackUrl'=>$callbackUrl,
                        'json_data'=>$data
                    ];
                    
                    $azure_videos = DB::table('azure_videos')->where('id', $id)->update($update_data);
                    
                    $result['status'] = true;
                }
                getAccountDetail($id_cms_users);
            }
            
        } catch (HttpException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
        }

        return  $result;
    }
}

if(!function_exists('getAccounts')) {
    function getAccounts($id_cms_users='') {

        if (Request()->id_cms_users) {
            $id_cms_users = Request()->id_cms_users;
        }

        $client = new \GuzzleHttp\Client();
        $azure_accounts = DB::table('azure_accounts')->where('id_cms_users', $id_cms_users)->first();
        // echo "<pre>";print_r($azure_accounts);exit;
        if($azure_accounts) {
            $url = env('AZURE_API_URL').'/auth/'.$azure_accounts->location.'/Accounts?generateAccessTokens=true&allowEdit=true';
            $response = $client->request('GET', $url, ['headers'=>['Ocp-Apim-Subscription-Key'=>$azure_accounts->primary_key]]);
            $data = $response->getBody(); 
            $data = json_decode($data);
            $azure_accounts->access_token = $data[0]->accessToken;
            
            return $azure_accounts;
        }
        return false;
    }
}

if(!function_exists('getAccountDetail')) {
    function getAccountDetail($id_cms_users='') {
        $getAccount = '';
        if (!$id_cms_users) {
            $id_cms_users = Auth::guard('admin')->user()->id;
        }
        $client = new \GuzzleHttp\Client();
        $azure_accounts = getAccounts($id_cms_users);
        if ($azure_accounts) {
            $url = env('AZURE_API_URL').'/'.$azure_accounts->location.'/Accounts/'.$azure_accounts->account_id.'?includeUsage=true&includeAmsInfo=true&includeStatistics=true&accessToken='.$azure_accounts->access_token;

            $response = $client->request('GET', $url, ['headers'=>['Ocp-Apim-Subscription-Key'=>$azure_accounts->primary_key]]);
            
            $data = $response->getBody(); 
            $getAccount = json_decode($data);
            $owners = $getAccount->owners[0];
            $quotaUsage = $getAccount->quotaUsage;
            $statistics = $getAccount->statistics;
            DB::table('azure_accounts')
            ->where('id_cms_users', Auth::guard('admin')->user()->id)
            ->update(
                    [
                        'owners_id'=>$owners->id,
                        /*'owners_name'=>$owners->name,
                        'owners_email'=>$owners->email,*/
                        'dailyUploadCount'=>$quotaUsage->dailyUploadCount,
                        'dailyUploadCountLimit'=>$quotaUsage->dailyUploadCountLimit,
                        'dailyUploadDurationInSeconds'=>$quotaUsage->dailyUploadDurationInSeconds,
                        'dailyUploadDurationLimitInSeconds'=>$quotaUsage->dailyUploadDurationLimitInSeconds,
                        'everUploadDurationInSeconds'=>$quotaUsage->everUploadDurationInSeconds,
                        'everUploadDurationLimitInSeconds'=>$quotaUsage->everUploadDurationLimitInSeconds,
                        'videosCount'=>$statistics->videosCount,
                        'lingusiticModelsCount'=>$statistics->lingusiticModelsCount,
                        'personModlesCount'=>$statistics->personModlesCount,
                        'brandsCount'=>$statistics->brandsCount,
                        'state'=>$getAccount->state,
                        'isPaid'=>$getAccount->isPaid
                    ]
                );
        }
        return $getAccount;
    }
}

/**
 * This function is used to get project Root directory path
 * @author Chirag Ghevariya 
 */
if(!function_exists('getRootDirectoryPath')) {
    function getRootDirectoryPath() {

        $path  = explode('core',base_path());
        return $path[0];
    }
}

/**
 * This function is used to get repeat interval type
 * @author Chirag Ghevariya 
 */
if(!function_exists('repeatIntervalType')) {
    function repeatIntervalType() {

        return [

            'yearly'=>'Yearly',
            'monthly'=>'Monthly',
            'weekly'=>'Weekly',
            'daily'=>'Daily',
            'hourly'=>'Hourly',

        ];
    }
}

/**
 * This function is used to get repeat interval type
 * @author Chirag Ghevariya 
 */
if(!function_exists('recurringMonth')) {
    function recurringMonth() {

        return [

            '1'=>'Jan',
            '2'=>'Feb',
            '3'=>'Mar',
            '4'=>'Apr',
            '5'=>'May',
            '6'=>'Jun',
            '7'=>'Jul',
            '8'=>'Aug',
            '9'=>'Sep',
            '10'=>'Oct',
            '11'=>'Nov',
            '12'=>'Dec',

        ];
    }
}

/**
 * This function is used to get repeat interval type
 * @author Chirag Ghevariya 
 */
if(!function_exists('recurringDays')) {
    function recurringDays() {

        $array = [];

        for($i = 1; $i <= 31; $i++){

            $array[$i] = $i;           
        }

        return $array;
    }
}

/**
 * This function is used to get repeat interval type
 * @author Chirag Ghevariya 
 */
if(!function_exists('recurringWeekDayName')) {
    function recurringWeekDayName() {

        $array = [

            'su'=>'Sun',
            'mo'=>'Mon',
            'tu'=>'Tue',
            'we'=>'Wed',
            'th'=>'Thu',
            'fr'=>'Fri',
            'sa'=>'Sat',
        ];

        return $array;
    }
}

/**
 * This function is used to get repeat interval type
 * @author Chirag Ghevariya 
 */
if(!function_exists('recurringWeekDayNameMix')) {
    function recurringWeekDayNameMix() {

        $array = [

            '0'=>'Sunday',
            '1'=>'Monday',
            '2'=>'Tuesday',
            '3'=>'Wednesday',
            '4'=>'Thursday',
            '5'=>'Friday',
            '6'=>'Saturday',
            '0,1,2,3,4,5,6'=>'Day',
            '1,2,3,4,5'=>'Weekday',
            '6'=>'Weekend day',
        ];

        return $array;
    }
}

/**
 * This function is used to get repeat interval type
 * @author Chirag Ghevariya 
 */
if(!function_exists('recurringMonthDayPos')) {
    function recurringMonthDayPos() {

        $array = [

            '1'=>'First',
            '2'=>'Second',
            '3'=>'Third',
            '4'=>'Fourth',
            '-1'=>'Last',
        ];

        return $array;
    }
}

/**
 * This function is used to get featured event
 * @author Chirag Ghevariya 
 */
if(!function_exists('getFeaturedEvent')) {
    function getFeaturedEvent() {

        $events = \App\CalendarEvent::where('is_featured',1)->get();
        return $events;
    }
}

/**
 * This function is used to get mail in box from third party
 * @author Chirag Ghevariya 
 */
if(!function_exists('getImapHosturl')) {
    function getImapHosturl($accountSetting) {

       // $url =  "{pop3.live.com:993/imap/ssl/novalidate-cert}INBOX";
       $url =  "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";
       
       return $url;
    }
}

/**
 * This function is used to get mail in box from third party
 * @author Chirag Ghevariya 
 */
if(!function_exists('getCustomeImapHosturl')) {
    function getCustomeImapHosturl($emailServer,$type = null) {

       $imapAddress = $emailServer->imap_server_address;
       $imapPort = $emailServer->imap_port;

       if($type == 1){
        
           $url =  "{".$imapAddress.":".$imapPort."/imap/ssl/novalidate-cert}INBOX";

       }else{
            
            $url =  "{imap.gmail.com:993/ssl}[Gmail]/Sent Mail";
       }
       
        return $url;
    }
}

/**
 * This function is used to get email server details
 * @author Chirag Ghevariya 
 */
if(!function_exists('getEmailServerInfo')) {
    function getEmailServerInfo($id) {

       $obj = \App\EmailServer::where('id',$id)->firstOrFail();

       return $obj;
    }
}

/**
 * This function is used to get website path url
    @modify by Chirag Ghevariya
 */
    
if(!function_exists('getBasePath')) {

    function getBasePath()
    {   
        if (env('IS_LOCAL_OR_LIVE') == "local") {

            return $_SERVER['CONTEXT_DOCUMENT_ROOT'].'/'.env('PROJECT_NAME');

        }else{

            return $_SERVER['CONTEXT_DOCUMENT_ROOT'];
        }
    }
}

if(!function_exists('getMediaTypeImagePath')) {

    function getMediaTypeImagePath()
    {   
        
        return getBasePath().'/assets/front/img/gallery';

    }
}

if(!function_exists('getMediaTypeDocumentPath')) {

    function getMediaTypeDocumentPath()
    {   
        
        return getBasePath().'/assets/front/doc';

    }
}

if(!function_exists('getMediaTypeVideoPath')) {

    function getMediaTypeVideoPath()
    {   
        
        return getBasePath().'/assets/front/videos';

    }
}

if(!function_exists('getMediaTypeAudioPath')) {

    function getMediaTypeAudioPath()
    {   
        
        return getBasePath().'/assets/front/img/audio';

    }
}

if(!function_exists('getBreadcumVideoPath')) {

    function getBreadcumVideoPath()
    {   
        return getBasePath().'/assets/front/img/breadcrumb';
    }
}

if(!function_exists('getFormatSize')) {

    function getFormatSize($size)
    {   
        
      $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");

        if ($size == 0) { 

            return('n/a'); 

        } else {

            return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); 

        }

    }
}


if(!function_exists('CommonFunctionForMailString')) {

    function CommonFunctionForMailString($requestPassword,$smtpPassword,$length)
    {   
        $newKey = $smtpPassword; 
        if (strlen($requestPassword) < $length) {
            
            $newKey = \Crypt::encryptString($requestPassword);
        }

        return $newKey;
    }
}

if(!function_exists('GET_FAQ_LEGENDS_PAGE_URL')) {

    function GET_FAQ_LEGENDS_PAGE_URL()
    {   
        $page = \App\Page::where('id',\App\Page::FAQ_FOR_LEGENDS_EDITOR_PAGE_ID)->first();
        
        if ($page !=null) {
            
            $url = route('front.dynamicPage',$page->slug);

        }else{

            $url = 'javascript:void(0)';
        }   

        return $url;
    }
}

if(!function_exists('getMediaTypeImageURL')) {

    function getMediaTypeImageURL()
    {   
        
        return asset('assets/front/img/gallery');

    }
}

if(!function_exists('getMediaTypeDocumentURL')) {

    function getMediaTypeDocumentURL()
    {   
        
        return asset('/assets/front/doc');

    }
}

if(!function_exists('getMediaTypeVideoURL')) {

    function getMediaTypeVideoURL()
    {   
        
        return asset('/assets/front/img/videos');

    }
}

if(!function_exists('getMediaTypeAudioURL')) {

    function getMediaTypeAudioURL()
    {   
        
        return asset('/assets/front/img/audio');

    }
}

?>
