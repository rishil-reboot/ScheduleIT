<?php

namespace App\Http\Middleware;

use Closure;

class XssSanitization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        $arrayOfIgnore = ['cookie_alert_text','tawk_to_script','disqus_script','google_analytics_script','appzi_script','addthis_script','facebook_pexel_script','content','body','meta_content','copyright_text','event_note','description','message','reply','instructions','job_responsibilities','educational_requirements','experience_requirements','additional_requirements','salary','benefits','read_before_apply','booking_spot_description','title','text','intro_section_text','new_your_address','florida_address','vegas_address','united_kingdom_address','partner_section_description','client_section_description','company_address','package_page_description','service_section_content','matomo_script','iframe_data','footer_content','body_content','template_footer_content','maintainance_text'];

        foreach($arrayOfIgnore as $key=>$v){

            $arrayKey = array_keys($input);

            if (in_array($v,$arrayKey) && !empty($arrayKey)) {
                    
                unset($input[$v]);
            }
        }

        array_walk_recursive($input, function(&$input) {

            $input = strip_tags($input);

        });

        $request->merge($input);

        return $next($request);


    }
}
