<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\BasicSetting as BS;
use App\BasicExtended as BE;
use App\Social;
use App\Ulink;
use App\Page;
use App\Scategory;
use App\Language;
use App\Menu;
use App\TopMenu;
use App\Validator\CustomeValidator;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $socials = Social::orderBy('serial_number', 'ASC')->get();
        $langs = Language::all();

        view()->composer('*', function ($view)
        {
            if (session()->has('lang')) {
                $currentLang = Language::where('code', session()->get('lang'))->first();
            } else {
                $currentLang = Language::where('is_default', 1)->first();
            }

            $bs = $currentLang->basic_setting;
            $be = $currentLang->basic_extended;
            $bex = $currentLang->basic_extra;

            $ulinks = $currentLang->ulinks;
            $versionSlug = getVersion($be->theme_version);

            $myTheme = \App\MyThemeVersion::where('slug',$versionSlug)->first();

            if ($myTheme !=null) {
                
                $breadcumPadding = $myTheme->padding;
                $breadcumPaddingDashboard = $myTheme->dashboard_padding;

            }else{

                $breadcumPadding = "";
                $breadcumPaddingDashboard = "";
            }

            if (hasCategory($be->theme_version)) {
                $scats = $currentLang->scategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();
            }

            if (Menu::where('language_id', $currentLang->id)->count() > 0) {
                $menus = Menu::where('language_id', $currentLang->id)->first()->menus;
            } else {
                $menus = json_encode([]);
            }

            if (TopMenu::where('language_id', $currentLang->id)->count() > 0) {
                $topMenus = TopMenu::where('language_id', $currentLang->id)->first()->menus;
            } else {
                $topMenus = json_encode([]);
            }

            if ($currentLang->rtl == 1) {
                $rtl = 1;
            } else {
                $rtl = 0;
            }

            $view->with('breadcumPadding', $breadcumPadding );
            $view->with('breadcumPaddingDashboard', $breadcumPaddingDashboard );
            $view->with('bs', $bs );
            $view->with('be', $be );
            $view->with('bex', $bex );
            if (hasCategory($be->theme_version)) {
                $view->with('scats', $scats );
            }
            $view->with('ulinks', $ulinks );
            $view->with('menus', $menus );
            $view->with('topMenus', $topMenus );
            $view->with('currentLang', $currentLang );
            $view->with('rtl', $rtl );
        });

        View::share('socials', $socials);
        View::share('langs', $langs);

        $this->app->validator->resolver(function($translator, $data, $rules, $messages) {
            return new CustomeValidator($translator, $data, $rules, $messages);
        });
    }
}
