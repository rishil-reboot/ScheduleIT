<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">
    <title>{{ $bs->website_title }} @yield('pagename')</title>

    <!-- icofont-css-link -->
    <link rel="stylesheet" href="{{ asset('assets/front/theme-css/icofont.min.css') }}">
    <!-- Owl-Carosal-Style-link -->
    <link rel="stylesheet" href="{{ asset('assets/front/theme-css/owl.carousel.min.css') }}">
    <!-- Bootstrap-Style-link -->
    <link rel="stylesheet" href="{{ asset('assets/front/theme-css/bootstrap.min.css') }}">
    <!-- Aos-Style-link -->
    <link rel="stylesheet" href="{{ asset('assets/front/theme-css/aos.css') }}">
    <!-- Coustome-Style-link -->
    <link rel="stylesheet" href="{{ asset('assets/front/theme-css/style.css') }}">
    <!-- Responsive-Style-link -->
    <link rel="stylesheet" href="{{ asset('assets/front/theme-css/responsive.css') }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/front/theme-images/favicon.png') }}"type="image/x-icon">

    <link rel="stylesheet" href="{{asset('assets/user/css/toastr.min.css')}}">

    @yield('styles')
    <!-- plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/plugin.min.css') }}">
    @if ($bs->is_tawkto == 1)
        <style>
            .back-to-top {
                bottom: 50px;
            }

            .back-to-top.show {
                right: 20px;
            }
        </style>
    @endif
    @if (count($langs) == 0)
        <style media="screen">
            .support-bar-area ul.social-links li:last-child {
                margin-right: 0px;
            }

            .support-bar-area ul.social-links::after {
                display: none;
            }
        </style>
    @endif
    @if ($bs->feature_section == 0)
        <style media="screen">
            .hero-txt {
                padding-bottom: 160px;
            }
        </style>
    @endif
    @if (isDark($be->theme_version))
        <!-- dark version css -->
        <link rel="stylesheet" href="{{ asset('assets/front/css/dark.css') }}">
        <!-- dark version base color change -->
        <link href="{{ url('/') }}/assets/front/css/dark-base-color.php?color={{ $bs->base_color }}"
            rel="stylesheet">
    @endif

    @if ($rtl == 1)
        <!-- RTL css -->
        <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
    @endif
    <script src="{{ asset('assets/front/theme-js/jquery.js') }}"></script>

    @if ($bs->is_appzi == 1)
        <!-- Start of Appzi Feedback Script -->
        <script async src="https://app.appzi.io/bootstrap/bundle.js?token={{ $bs->appzi_token }}"></script>
        <!-- End of Appzi Feedback Script -->
    @endif

    <!-- Start of Facebook Pixel Code -->
    @if ($be->is_facebook_pexel == 1)
        {!! $be->facebook_pexel_script !!}
    @endif
    <!-- End of Facebook Pixel Code -->

    <!--Start of Appzi script-->
    @if ($bs->is_appzi == 1)
        {!! $bs->appzi_script !!}
    @endif
    <!--End of Appzi script-->

    <!--Start of Matomo script-->
    @if ($bs->is_matomo == 1)
        {!! $bs->matomo_script !!}
    @endif
    <!--End of Matomo script-->

    <link rel="stylesheet" href="{{ asset('assets/front/css/breadcum.css') }}">
</head>

<body @if ($rtl == 1) dir="rtl" @endif
    class="@if (isset($themeSetting) && $themeSetting->calendar_theme == 2) light-version @endif">
    <!-- Header Start -->
    {{-- <header class="header-absolute @yield('no-breadcrumb')"> --}}
        {{--  <div class="container">
           <div class="support-bar-area">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6 support-contact-info d-flex">
                        <span class="address mr-4"><i class="far fa-envelope"></i> {{ $bs->support_email }}</span>
                        <span class="phone"><i class="flaticon-chat"></i> {{ $bs->support_phone }}</span>
                    </div>
                    <div
                        class="col-lg-6 d-flex align-items-center justify-content-end {{ $rtl == 1 ? 'text-left' : 'text-right' }}">
                        <ul class="social-links list-inline mb-0 mr-7">
                            @foreach ($socials as $key => $social)
                                <li class="list-inline-item"><a target="_blank" href="{{ $social->url }}"><i
                                            class="{{ $social->icon }} socials-links"></i></a></li>
                            @endforeach
                        </ul>
                        @if (!empty($currentLang))
                            <div class="language mr-4">
                                <select name="language" id="language" onchange="location = this.value;">
                                    @foreach ($langs as $key => $lang)
                                        <option value="{{ route('changeLanguage', $lang->code) }}"
                                            {{ $lang->code == $currentLang->code ? 'selected' : '' }}>
                                            {{ convertUtf8($lang->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @guest
                            <ul class="login list-inline mb-0">
                                <li class="list-inline-item"><a href="{{ route('user.login') }}">{{ __('Login') }}</a>
                                </li>
                            </ul>
                        @endguest
                        @auth
                        <ul class="login list-inline mb-0">
                     @if (request()->is('user/dashboard'))
                                <li class="list-inline-item">
                                    <a href="{{ route('user-logout') }}">{{ __('Logout') }}</a>
                                </li>
                            @else
                                <li class="list-inline-item">
                                    <a href="{{ route('user-dashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                            @endif
                        </ul>
                    @endauth
                    </div>
                </div>
            </div>
        </div> --}}
        @include("front.$version.partials.navbar")
     {{-- </header> --}}

    <!-- Header end -->
    <!-- Page-wrapper-Start -->
    <div class="page_wrapper">
        @yield('content')
    </div>
    <!-- Page-wrapper-End -->

    <!-- Footer-Section start -->
    <footer>
        @include("front.$version.partials.footer")
    </footer>
    <!-- Footer-Section end -->
    <script src="{{asset('assets/user/js/toastr.min.js')}}"></script>

    @yield('scripts')
    <!-- Jquery-js-Link -->
    <!-- owl-js-Link -->
    <script src="{{ asset('assets/front/theme-js/owl.carousel.min.js') }}"></script>
    <!-- bootstrap-js-Link -->
    <script src="{{ asset('assets/front/theme-js/bootstrap.min.js') }}"></script>
    <!-- aos-js-Link -->
    <script src="{{ asset('assets/front/theme-js/aos.js') }}"></script>
    <!-- main-js-Link -->
    <script src="{{ asset('assets/front/theme-js/main.js') }}"></script>


</body>

</html>
