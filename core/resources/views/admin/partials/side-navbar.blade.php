@php
  $default = \App\Language::where('is_default', 1)->first();
  $admin = Auth::guard('admin')->user();
  if (!empty($admin->role)) {
    $permissions = $admin->role->permissions;
    $permissions = json_decode($permissions, true);
  }

@endphp
<div class="sidebar sidebar-style-2" data-background-color="dark2">
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-primary new-public-class">
        <li class="nav-item">
          <a style="background-color: black !important;" href="{{route('front.index')}}" target="_blank">
            <i class="fa fa-globe" aria-hidden="true"></i>
            <p>Public View</p>
          </a>
        </li>
      </ul>
      <div class="user">
        <div class="avatar-sm float-left mr-2">
          @if (!empty(Auth::guard('admin')->user()->image))
            <img src="{{asset('assets/admin/img/propics/'.Auth::guard('admin')->user()->image)}}" alt="..." class="avatar-img rounded">
          @else
            <img src="{{asset('assets/admin/img/propics/blank_user.jpg')}}" alt="..." class="avatar-img rounded">
          @endif
        </div>
        <div class="info">
          <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
            <span>
              {{Auth::guard('admin')->user()->first_name}}
              @if (empty(Auth::guard('admin')->user()->role))
                <span class="user-level">Owner</span>
              @else
                <span class="user-level">{{Auth::guard('admin')->user()->role->name}}</span>
              @endif
              <span class="caret"></span>
            </span>
          </a>
          <div class="clearfix"></div>

          <div class="collapse in" id="collapseExample">
            <ul class="nav">
              <li>
                <a href="{{route('admin.editProfile')}}">
                  <span class="link-collapse">Edit Profile</span>
                </a>
              </li>
              <li>
                <a href="{{route('admin.changePass')}}">
                  <span class="link-collapse">Change Password</span>
                </a>
              </li>
              <li>
                <a href="{{route('admin.logout')}}">
                  <span class="link-collapse">Logout</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <ul class="nav nav-primary">

        @if (empty($admin->role) || (!empty($permissions) && in_array('Dashboard', $permissions)))
          {{-- Dashboard --}}
          <li class="nav-item @if(request()->path() == 'admin/dashboard') active @endif">
            <a href="{{route('admin.dashboard')}}">
              <i class="la flaticon-paint-palette"></i>
              <p>Dashboard</p>
            </a>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Basic Settings', $permissions)))
          {{-- Basic Settings --}}
          <li class="nav-item
          @if(request()->path() == 'admin/favicon') active
          @elseif(request()->path() == 'admin/logo') active
          @elseif(request()->path() == 'admin/twilio-credit') active
          @elseif(request()->path() == 'admin/themeversion') active
          @elseif(request()->path() == 'admin/homeversion') active
          @elseif(request()->path() == 'admin/basicinfo') active
          @elseif(request()->path() == 'admin/social') active
          @elseif(request()->is('admin/social/*')) active
          @elseif(request()->path() == 'admin/breadcrumb') active
          @elseif(request()->path() == 'admin/heading') active
          @elseif(request()->path() == 'admin/script') active
          @elseif(request()->path() == 'admin/seo') active
          @elseif(request()->path() == 'admin/maintainance') active
          @elseif(request()->path() == 'admin/announcement') active
          @elseif(request()->path() == 'admin/cookie-alert') active
          @elseif(request()->path() == 'admin/mail-from-admin') active
          @elseif(request()->path() == 'admin/qr-code-generator') active
          @elseif(request()->path() == 'admin/mail-to-admin') active
          @elseif(request()->routeIs('admin.featuresettings')) active
          @elseif(request()->is('admin/currency')) active
          @elseif(request()->is('admin/currency/create')) active
          @elseif(request()->is('admin/currency/*/edit')) active
          @elseif(request()->is('admin/advertisement')) active
          @elseif(request()->is('admin/advertisement/create')) active
          @elseif(request()->is('admin/advertisement/*/edit')) active
          @endif">
            <a data-toggle="collapse" href="#basic">
              <i class="la flaticon-settings"></i>
              <p>Basic Settings</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/favicon') show
            @elseif(request()->path() == 'admin/logo') show
            @elseif(request()->path() == 'admin/twilio-credit') show
            @elseif(request()->path() == 'admin/themeversion') show
            @elseif(request()->path() == 'admin/homeversion') show
            @elseif(request()->path() == 'admin/basicinfo') show
            @elseif(request()->path() == 'admin/social') show
            @elseif(request()->is('admin/social/*')) show
            @elseif(request()->path() == 'admin/breadcrumb') show
            @elseif(request()->path() == 'admin/heading') show
            @elseif(request()->path() == 'admin/script') show
            @elseif(request()->path() == 'admin/seo') show
            @elseif(request()->path() == 'admin/maintainance') show
            @elseif(request()->path() == 'admin/announcement') show
            @elseif(request()->path() == 'admin/cookie-alert') show
            @elseif(request()->path() == 'admin/mail-from-admin') show
            @elseif(request()->path() == 'admin/mail-from-admin/template/create') show
            @elseif(request()->is('admin/mail-from-admin/template/*/edit')) show
            @elseif(request()->path() == 'admin/mail-to-admin') show
            @elseif(request()->path() == 'admin/qr-code-generator') show
            @elseif(request()->routeIs('admin.featuresettings')) show
            @elseif(request()->is('admin/currency')) show
            @elseif(request()->is('admin/currency/create')) show
            @elseif(request()->is('admin/advertisement')) show
            @elseif(request()->is('admin/advertisement/create')) show
            @elseif(request()->is('admin/advertisement/*/edit')) show
            @endif" id="basic">
              <ul class="nav nav-collapse">
                <li class="@if(request()->path() == 'admin/favicon') active @endif">
                  <a href="{{route('admin.favicon') . '?language=' . $default->code}}">
                    <span class="sub-item">Favicon</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/logo') active @endif">
                  <a href="{{route('admin.logo') . '?language=' . $default->code}}">
                    <span class="sub-item">Logo</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/basicinfo') active @endif">
                  <a href="{{route('admin.basicinfo') . '?language=' . $default->code}}">
                    <span class="sub-item">General Settings</span>
                  </a>
                </li>


                <li class="submenu">
                    <a data-toggle="collapse" href="#currency-management" aria-expanded="{{(request()->path() == 'admin/currency/create' || request()->path() == 'admin/currency' || request()->is('admin/currency/*/edit')) ? 'true' : 'false' }}">
                      <span class="sub-item">Currency</span>
                      <span class="caret"></span>
                    </a>
                    <div class="collapse {{(request()->path() == 'admin/currency/create' || request()->path() == 'admin/currency' || request()->is('admin/currency/*/edit')) ? 'show' : '' }}" id="currency-management" style="">
                      <ul class="nav nav-collapse subnav">

                        <li class="@if(request()->path() == 'admin/currency/create' || request()->is('admin/currency/*/edit')) active @endif">
                          <a href="{{route('currency.create')}}">
                            <span class="sub-item">Add Currency</span>
                          </a>
                        </li>

                        <li class="@if(request()->path() == 'admin/currency') active @endif">
                          <a href="{{route('currency.index')}}">
                            <span class="sub-item">Currency List</span>
                          </a>
                        </li>

                      </ul>
                    </div>
                </li>

                <li class="submenu">
                    <a data-toggle="collapse" href="#emailset" aria-expanded="{{(request()->path() == 'admin/mail-from-admin' || request()->path() == 'admin/mail-to-admin' || request()->path() == 'admin/mail-from-admin/template/create' || request()->is('admin/mail-from-admin/template/*/edit')) ? 'true' : 'false' }}">
                      <span class="sub-item">Email Settings</span>
                      <span class="caret"></span>
                    </a>
                    <div class="collapse {{(request()->path() == 'admin/mail-from-admin' || request()->path() == 'admin/mail-to-admin' || request()->path() == 'admin/mail-from-admin/template/create' || request()->is('admin/mail-from-admin/template/*/edit')) ? 'show' : '' }}" id="emailset" style="">
                      <ul class="nav nav-collapse subnav">

                        <li class="@if(request()->path() == 'admin/mail-from-admin' || request()->path() == 'admin/mail-from-admin/template/create' || request()->is('admin/mail-from-admin/template/*/edit')) active @endif">
                          <a href="{{route('admin.mailFromAdmin')}}">
                            <span class="sub-item">Mail from Admin</span>
                          </a>
                        </li>
                        <li class="@if(request()->path() == 'admin/mail-to-admin') active @endif">
                          <a href="{{route('admin.mailToAdmin')}}">
                            <span class="sub-item">Mail to Admin</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                </li>

                <li class="@if(request()->path() == 'admin/themeversion') active @endif">
                  <a href="{{route('admin.themeversion') . '?language=' . $default->code}}">
                    <span class="sub-item">Theme Versions</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/homeversion') active @endif">
                  <a href="{{route('admin.homeversion') . '?language=' . $default->code}}">
                    <span class="sub-item">Home Versions</span>
                  </a>
                </li>

                <li class="@if(request()->routeIs('admin.featuresettings')) active @endif">
                  <a href="{{route('admin.featuresettings') . '?language=' . $default->code}}">
                    <span class="sub-item">Features Settings</span>
                  </a>
                </li>

                <li class="@if(request()->path() == 'admin/social') active
                @elseif(request()->is('admin/social/*')) active @endif">
                  <a href="{{route('admin.social.index')}}">
                    <span class="sub-item">Social Links</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/breadcrumb') active @endif">
                  <a href="{{route('admin.breadcrumb') . '?language=' . $default->code}}">
                    <span class="sub-item">Breadcrumb</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/heading') active @endif">
                  <a href="{{route('admin.heading') . '?language=' . $default->code}}">
                    <span class="sub-item">Page Headings</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/script') active @endif">
                  <a href="{{route('admin.script')}}">
                    <span class="sub-item">Scripts</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/seo') active @endif">
                  <a href="{{route('admin.seo') . '?language=' . $default->code}}">
                    <span class="sub-item">SEO Information</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/maintainance') active @endif">
                  <a href="{{route('admin.maintainance')}}">
                    <span class="sub-item">Maintainance Mode</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/announcement') active @endif">
                  <a href="{{route('admin.announcement') . '?language=' . $default->code}}">
                    <span class="sub-item">Announcement Popup</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/cookie-alert') active @endif">
                  <a href="{{route('admin.cookie.alert') . '?language=' . $default->code}}">
                    <span class="sub-item">Cookie Alert</span>
                  </a>
                </li>

                <li class="@if(request()->path() == 'admin/advertisement' || request()->path() == 'admin/advertisement/create' || request()->is('admin/advertisement/*/edit')) active @endif">
                  <a href="{{route('admin.advertisement.index') }}">
                    <span class="sub-item">Advertisement</span>
                  </a>
                </li>

		 <li class="@if(request()->path() == 'admin/qr-code-generator') active @endif">
                  <a href="{{route('admin.qr-code-generator')}}">
                    <span class="sub-item">QR Code</span>
                  </a>
                </li>

                <li class="@if(request()->path() == 'admin/twilio-credit') active @endif">
                  <a href="{{route('admin.twilio-credit')}}">
                    <span class="sub-item">Twilio Creds </span>
                  </a>
                </li>


              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Home Page', $permissions)))
          {{-- Home Page --}}
          <li class="nav-item
          @if(request()->path() == 'admin/features') active
          @elseif(request()->path() == 'admin/introsection') active
          @elseif(request()->is('admin/aboutintro/create')) active
          @elseif(request()->is('admin/aboutintro/*/edit')) active
          @elseif(request()->path() == 'admin/servicesection') active

          @elseif(request()->path() == 'admin/scategorys') active
          @elseif(request()->is('admin/scategory/*/edit')) active
          @elseif(request()->path() == 'admin/services') active
          @elseif(request()->is('admin/service/*/edit')) active

          @elseif(request()->path() == 'admin/herosection/static') active
          @elseif(request()->path() == 'admin/herosection/video') active
          @elseif(request()->path() == 'admin/herosection/sliders') active
          @elseif(request()->is('admin/herosection/slider/*/edit')) active
          @elseif(request()->path() == 'admin/approach') active
          @elseif(request()->is('admin/approach/*/pointedit')) active
          @elseif(request()->path() == 'admin/statistics') active
          @elseif(request()->is('admin/statistics/*/edit')) active
          @elseif(request()->path() == 'admin/members') active
          @elseif(request()->is('admin/member/*/edit')) active
          @elseif(request()->is('admin/approach/*/pointedit')) active
          @elseif(request()->path() == 'admin/cta') active
          @elseif(request()->is('admin/feature/*/edit')) active
          @elseif(request()->path() == 'admin/testimonials') active
          @elseif(request()->is('admin/testimonial/*/edit')) active
          @elseif(request()->path() == 'admin/invitation') active
          @elseif(request()->path() == 'admin/partners') active
          @elseif(request()->is('admin/partner/*/edit')) active
          @elseif(request()->path() == 'admin/clients') active
          @elseif(request()->is('admin/client/*/edit')) active
          @elseif(request()->path() == 'admin/portfoliosection') active
          @elseif(request()->path() == 'admin/blogsection') active
          @elseif(request()->path() == 'admin/educationsection') active
          @elseif(request()->path() == 'admin/member/create') active
          @elseif(request()->path() == 'admin/sections') active
          @elseif(request()->path() == 'admin/package/background') active
          @endif">
            <a data-toggle="collapse" href="#home">
              <i class="la flaticon-home"></i>
              <p>Home Page</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/features') show
            @elseif(request()->path() == 'admin/introsection') show
            @elseif(request()->is('admin/aboutintro/create')) show
            @elseif(request()->is('admin/aboutintro/*/edit')) show

            @elseif(request()->path() == 'admin/servicesection') show

            @elseif(request()->path() == 'admin/scategorys') show
            @elseif(request()->is('admin/scategory/*/edit')) show
            @elseif(request()->path() == 'admin/services') show
            @elseif(request()->is('admin/service/*/edit')) show


            @elseif(request()->path() == 'admin/herosection/static') show
            @elseif(request()->path() == 'admin/herosection/video') show
            @elseif(request()->path() == 'admin/herosection/sliders') show
            @elseif(request()->is('admin/herosection/slider/*/edit')) show
            @elseif(request()->path() == 'admin/approach') show
            @elseif(request()->is('admin/approach/*/pointedit')) show
            @elseif(request()->path() == 'admin/statistics') show
            @elseif(request()->is('admin/statistics/*/edit')) show
            @elseif(request()->path() == 'admin/members') show
            @elseif(request()->is('admin/member/*/edit')) show
            @elseif(request()->path() == 'admin/cta') show
            @elseif(request()->is('admin/feature/*/edit')) show
            @elseif(request()->path() == 'admin/testimonials') show
            @elseif(request()->is('admin/testimonial/*/edit')) show
            @elseif(request()->path() == 'admin/invitation') show
            @elseif(request()->path() == 'admin/partners') show
            @elseif(request()->is('admin/partner/*/edit')) show
            @elseif(request()->path() == 'admin/clients') show
            @elseif(request()->is('admin/client/*/edit')) show
            @elseif(request()->path() == 'admin/portfoliosection') show
            @elseif(request()->path() == 'admin/blogsection') show
            @elseif(request()->path() == 'admin/educationsection') show
            @elseif(request()->path() == 'admin/member/create') show
            @elseif(request()->path() == 'admin/sections') show
            @elseif(request()->path() == 'admin/package/background') show
            @endif" id="home">
              <ul class="nav nav-collapse">
                <li class="
                @if(request()->path() == 'admin/herosection/static') selected
                @elseif(request()->path() == 'admin/herosection/video') selected
                @elseif(request()->path() == 'admin/herosection/sliders') selected
                @elseif(request()->is('admin/herosection/slider/*/edit')) selected
                @endif">
                  <a data-toggle="collapse" href="#herosection">
                    <span class="sub-item">Hero Section</span>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse
                  @if(request()->path() == 'admin/herosection/static') show
                  @elseif(request()->path() == 'admin/herosection/video') show
                  @elseif(request()->path() == 'admin/herosection/sliders') show
                  @elseif(request()->is('admin/herosection/slider/*/edit')) show
                  @endif" id="herosection">
                    <ul class="nav nav-collapse subnav">
                      <li class="@if(request()->path() == 'admin/herosection/static') active @endif">
                        <a href="{{route('admin.herosection.static') . '?language=' . $default->code}}">
                          <span class="sub-item">Static Version</span>
                        </a>
                      </li>
                      <li class="
                      @if(request()->path() == 'admin/herosection/sliders') active
                      @elseif(request()->is('admin/herosection/slider/*/edit')) active
                      @endif">
                        <a href="{{route('admin.slider.index') . '?language=' . $default->code}}">
                          <span class="sub-item">Slider Version</span>
                        </a>
                      </li>
                      <li class="@if(request()->path() == 'admin/herosection/video') active @endif">
                        <a href="{{route('admin.herosection.video') . '?language=' . $default->code}}">
                          <span class="sub-item">Video Version</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>

                <li class="
                @if(request()->path() == 'admin/features') active
                @elseif(request()->is('admin/feature/*/edit')) active
                @endif">
                  <a href="{{route('admin.feature.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Features</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/introsection') active
                           @elseif(request()->is('admin/aboutintro/create')) active
                           @elseif(request()->is('admin/aboutintro/*/edit')) active
                          @endif">

                  <a href="{{route('admin.introsection.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Intro Section</span>
                  </a>
                </li>

                @if (empty($admin->role) || (!empty($permissions) && in_array('Service Page', $permissions)))

                  <li class="submenu">
                      <a data-toggle="collapse" href="#service" aria-expanded="{{(request()->path() == 'admin/scategorys' || request()->is('admin/scategory/*/edit') || request()->path() == 'admin/services' || request()->is('admin/service/*/edit') || request()->path() == 'admin/servicesection') ? 'true' : 'false' }}">
                        <span class="sub-item">Service Section</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse {{(request()->path() == 'admin/scategorys' || request()->is('admin/scategory/*/edit') || request()->path() == 'admin/services' || request()->is('admin/service/*/edit') || request()->path() == 'admin/servicesection') ? 'show' : '' }}" id="service" style="">
                        <ul class="nav nav-collapse subnav">

                           <li class="@if(request()->path() == 'admin/servicesection') active @endif">
                              <a href="{{route('admin.servicesection.index') . '?language=' . $default->code}}">
                                <span class="sub-item">Service Section</span>
                              </a>
                            </li>

                            @if (hasCategory($be->theme_version))
                            <li class="
                            @if(request()->path() == 'admin/scategorys') active
                            @elseif(request()->is('admin/scategory/*/edit')) active
                            @endif">
                              <a href="{{route('admin.scategory.index') . '?language=' . $default->code}}">
                                <span class="sub-item">Category</span>
                              </a>
                            </li>
                            @endif
                            <li class="
                            @if(request()->path() == 'admin/services') active
                            @elseif(request()->is('admin/service/*/edit')) active
                            @endif">
                              <a href="{{route('admin.service.index') . '?language=' . $default->code}}">
                                <span class="sub-item">Services</span>
                              </a>
                            </li>

                        </ul>
                      </div>
                  </li>
                @endif

                <li class="
                @if(request()->path() == 'admin/approach') active
                @elseif(request()->is('admin/approach/*/pointedit')) active
                @endif">
                  <a href="{{route('admin.approach.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Approach Section</span>
                  </a>
                </li>

                <li class="
                @if(request()->path() == 'admin/statistics') active
                @elseif(request()->is('admin/statistics/*/edit')) active
                @endif">
                  <a href="{{route('admin.statistics.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Statistics Section</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/cta') active @endif">
                  <a href="{{route('admin.cta.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Call to Action Section</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/portfoliosection') active @endif">
                  <a href="{{route('admin.portfoliosection.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Portfolio Section</span>
                  </a>
                </li>
                <li class="
                @if(request()->path() == 'admin/testimonials') active
                @elseif(request()->is('admin/testimonial/*/edit')) active
                @endif">
                  <a href="{{route('admin.testimonial.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Testimonials</span>
                  </a>
                </li>
                <li class="
                @if(request()->path() == 'admin/members') active
                @elseif(request()->is('admin/member/*/edit')) active
                @elseif(request()->path() == 'admin/member/create') active
                @endif">
                  <a href="{{route('admin.member.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Team Section</span>
                  </a>
                </li>
                <li class="
                @if(request()->path() == 'admin/package/background') active
                @endif">
                  <a href="{{route('admin.package.background') . '?language=' . $default->code}}">
                    <span class="sub-item">Package Background</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/blogsection') active @endif">
                  <a href="{{route('admin.blogsection.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Blog Section</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/educationsection') active @endif">
                  <a href="{{route('admin.educationsection.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Education Section</span>
                  </a>
                </li>

                <li class="@if(request()->path() == 'admin/stepssection') active @endif">
                    <a href="{{route('admin.stepsection.index').'?language=' . $default->code}}">
                      <span class="sub-item">Steps Section</span>
                    </a>
                  </li>

                  <li class="@if(request()->path() == 'admin/appsection') active @endif">
                    <a href="{{route('admin.appsection.index').'?language=' . $default->code}}">
                      <span class="sub-item">App Section </span>
                    </a>
                  </li>



                <li class="
                @if(request()->path() == 'admin/partners') active
                @elseif(request()->is('admin/partner/*/edit')) active
                @endif">
                  <a href="{{route('admin.partner.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Partners</span>
                  </a>
                </li>

                <li class="
                @if(request()->path() == 'admin/clients') active
                @elseif(request()->is('admin/client/*/edit')) active
                @endif">
                  <a href="{{route('admin.client.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Client</span>
                  </a>
                </li>

                <li class="
                @if(request()->path() == 'admin/sections') active
                @endif">
                  <a href="{{route('admin.sections.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Section Customization</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Pages', $permissions)))
          {{-- Dynamic Pages --}}
          <li class="nav-item
          @if(request()->path() == 'admin/page/create') active
          @elseif(request()->path() == 'admin/pages') active
          @elseif(request()->is('admin/page/*/edit')) active
          @endif">
            <a data-toggle="collapse" href="#pages">
              <i class="la flaticon-file"></i>
              <p>Pages</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/page/create') show
            @elseif(request()->path() == 'admin/pages') show
            @elseif(request()->is('admin/page/*/edit')) show
            @endif" id="pages">
              <ul class="nav nav-collapse">
                <li class="@if(request()->path() == 'admin/page/create') active @endif">
                  <a href="{{route('admin.page.create')}}">
                    <span class="sub-item">Create Page</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/pages' || request()->is('admin/page/*/edit')) active @endif">
                  <a href="{{route('admin.page.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Pages</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif









        @if (empty($admin->role) || (!empty($permissions) && in_array('Tools', $permissions)))
        <li class="nav-item
        @if(request()->path() == 'admin/metadata-viewer') active
        @elseif(request()->path() == 'admin/imagetopdf') active
        @endif">
          <a data-toggle="collapse" href="#tools">
            <i class="la flaticon-file"></i>
            <p>Tools</p>
            <span class="caret"></span>
          </a>
          <div class="collapse
          @if(request()->path() == 'admin/metadata-viewer') show
          @elseif(request()->path() == 'admin/imagetopdf') show
          @endif" id="tools">
            <ul class="nav nav-collapse">
                <li class="@if(request()->path() == 'admin/metadata-viewer') active @endif">
                  <a href="{{route('admin.metadata-viewer')}}">
                    <span class="sub-item">Meta Viewer</span>
                  </a>
                </li>

                <li class="@if(request()->path() == 'admin/imagetopdf') active @endif">
                  <a href="{{route('admin.imagetopdf')}}">
                    <span class="sub-item">Image To PDF</span>
                  </a>
                </li>

            </ul>
          </div>
        </li>
      @endif


      {{-- Screen Recorder Page --}}
      <li class="nav-item">
        <a href="{{route('admin.screen-recorder.index')}}">
          <i class="fas fa-video"></i>
          <p>Screen Recorder</p>
        </a>
      </li>



        @if (empty($admin->role) || (!empty($permissions) && in_array('Inbox', $permissions)))
          {{-- Inbox Management --}}
          <li class="nav-item
          @if(request()->is('admin/inboxwebmails')) active
          @elseif(request()->is('admin/add-new/inboxwebmail')) active
          @elseif(request()->is('admin/inboxwebmail/edit/*')) active
          @elseif(request()->is('admin/inboxwebmail/view/*')) active
          @elseif(request()->is('admin/inboxwebmail/compose/*')) active
          @endif">
            <a data-toggle="collapse" href="#inbox-management">
              <i class="la flaticon-file"></i>
              <p>Inbox</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->is('admin/inboxwebmails')) show
            @elseif(request()->is('admin/add-new/inboxwebmail')) show
            @elseif(request()->is('admin/inboxwebmail/edit/*')) show
            @elseif(request()->is('admin/inboxwebmail/view/*')) show
            @elseif(request()->is('admin/inboxwebmail/compose/*')) show
            @endif" id="inbox-management">
              <ul class="nav nav-collapse">

                <li class="@if(request()->is('admin/inboxwebmails') || request()->is('admin/add-new/inboxwebmail') || request()->is('admin/inboxwebmail/edit/*')) active @endif">
                  <a href="{{route('admin.inboxwebmails')}}">
                    <span class="sub-item">Settings</span>
                  </a>
                </li>
                <?php
                  $inboxwebmailMenu = \App\InboxwebmailAccount::where('active',1 )->get();
                ?>
                @if(!empty($inboxwebmailMenu))
                    @foreach($inboxwebmailMenu as $labelMenu)
                      <li class="li-email @if((request()->route()->getName() == 'admin.inboxwebmail.view' || request()->route()->getName() == 'admin.inboxwebmail.compose') && \Request::segment(4) == $labelMenu->id) active @endif">
                        <a href="{{route('admin.inboxwebmail.view',$labelMenu->id)}}"><span>{{$labelMenu->email}}</span></a>
                      </li>
                    @endforeach
                @endif

              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Blogs', $permissions)))
          {{-- Blogs --}}
          <li class="nav-item
          @if(request()->path() == 'admin/bcategorys') active
          @elseif(request()->path() == 'admin/blogs') active
          @elseif(request()->path() == 'admin/archives') active
          @elseif(request()->is('admin/blog/*/edit')) active
          @endif">
            <a data-toggle="collapse" href="#blog">
              <i class="la flaticon-chat-4"></i>
              <p>Blogs</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/bcategorys') show
            @elseif(request()->path() == 'admin/blogs') show
            @elseif(request()->path() == 'admin/archives') show
            @elseif(request()->is('admin/blog/*/edit')) show
            @endif" id="blog">
              <ul class="nav nav-collapse">
                <li class="@if(request()->path() == 'admin/bcategorys') active @endif">
                  <a href="{{route('admin.bcategory.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Category</span>
                  </a>
                </li>
                <li class="
                @if(request()->path() == 'admin/blogs') active
                @elseif(request()->is('admin/blog/*/edit')) active
                @endif">
                  <a href="{{route('admin.blog.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Blogs</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/archives') active @endif">
                  <a href="{{route('admin.archive.index')}}">
                    <span class="sub-item">Archives</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('FormBuilder', $permissions)))
          {{-- Dynamic Pages --}}
          <li class="nav-item
          @if(request()->path() == 'admin/form_builder/create') active
          @elseif(request()->path() == 'admin/form_builder') active
          @endif">
            <a data-toggle="collapse" href="#form_builder">
              <i class="la flaticon-folder"></i>
              <p>Form Builder</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/form_builder/create') show
            @elseif(request()->path() == 'admin/form_builder') show
            @elseif(request()->is('admin/form_builder/*/edit')) show
            @endif" id="form_builder">
              <ul class="nav nav-collapse">
                <li class="@if(request()->path() == 'admin/form_builder/create') active @endif">
                  <a href="{{route('admin.form_builder.create')}}">
                    <span class="sub-item">Create Form</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/form_builder') active @endif">
                  <a href="{{route('admin.form_builder.index') . '?language=' . $default->code}}">
                    <span class="sub-item">List</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Gallery Management', $permissions)))
          {{-- Gallery Management To Media Management Change --}}
          <li class="nav-item
           @if(request()->path() == 'admin/gallery') active
           @elseif(request()->path() == 'admin/gallery/create') active
           @elseif(request()->is('admin/gallery/*/edit')) active
           @endif">
            <a href="{{route('admin.gallery.index') . '?language=' . $default->code}}">
              <i class="la flaticon-picture"></i>
              <p>Media Management</p>
            </a>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Contact Page', $permissions)))
          {{-- Contact Page --}}
          <li class="nav-item
            @if(request()->path() == 'admin/contact') active @endif">
            <a href="{{route('admin.contact.index') . '?language=' . $default->code}}">
              <i class="la flaticon-whatsapp"></i>
              <p>Contact Page</p>
            </a>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Footer', $permissions)))
          {{-- Footer --}}
          <li class="nav-item
          @if(request()->path() == 'admin/footers') active
          @elseif(request()->path() == 'admin/ulinks') active
          @elseif(request()->path() == 'admin/powered-by') active
          @endif">
            <a data-toggle="collapse" href="#footer">
                <i class="la flaticon-layers"></i>
              <p>Footer</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/footers') show
            @elseif(request()->path() == 'admin/ulinks') show
            @elseif(request()->path() == 'admin/powered-by') show
            @endif" id="footer">
              <ul class="nav nav-collapse">

                @if(\Auth::user()->role_id == 0)
                  <li class="@if(request()->path() == 'admin/powered-by') active @endif">
                    <a href="{{route('admin.powered-by.index') . '?language=' . $default->code}}">
                      <span class="sub-item">Powered by</span>
                    </a>
                  </li>
                @endif

                <li class="@if(request()->path() == 'admin/footers') active @endif">
                  <a href="{{route('admin.footer.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Logo & Text</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/ulinks') active @endif">
                  <a href="{{route('admin.ulink.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Useful Links</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

                @if (empty($admin->role) || (!empty($permissions) && in_array('Career Page', $permissions)))
          {{-- Career Page --}}
          <li class="nav-item
          @if(request()->path() == 'admin/jcategorys') active
          @elseif(request()->path() == 'admin/job/create') active
          @elseif(request()->is('admin/jcategory/*/edit')) active
          @elseif(request()->path() == 'admin/jobs') active
          @elseif(request()->is('admin/job/*/edit')) active
          @endif">
            <a data-toggle="collapse" href="#career">
                <i class="fas fa-user-md"></i>
              <p>Career Page</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/jcategorys') show
            @elseif(request()->path() == 'admin/job/create') show
            @elseif(request()->is('admin/jcategory/*/edit')) show
            @elseif(request()->path() == 'admin/jobs') show
            @elseif(request()->is('admin/job/*/edit')) show
            @endif" id="career">
              <ul class="nav nav-collapse">
                <li class="
                @if(request()->path() == 'admin/jcategorys') active
                @elseif(request()->is('admin/jcategory/*/edit')) active
                @endif">
                  <a href="{{route('admin.jcategory.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Category</span>
                  </a>
                </li>
                <li class="
                @if(request()->path() == 'admin/jobs') active
                @elseif(request()->is('admin/job/*/edit')) active
                @elseif(request()->is('admin/job/create')) active
                @endif">
                  <a href="{{route('admin.job.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Job Management</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Event Calendar', $permissions)))
          {{-- Calendar --}}
          <li class="nav-item
          @if(request()->path() == 'admin/calendars') active
          @elseif(request()->path() == 'admin/calendar/create') active
          @elseif(request()->is('admin/calendar/*/edit')) active
          @elseif(request()->path() == 'admin/community-calendar') active
          @elseif(request()->path() == 'admin/calendar-settings') active
          @elseif(request()->is('admin/community-calendar/*/edit')) active
          @elseif(request()->is('admin/community-calendar/*/showCommunityCalendar')) active
          @endif">
            <a data-toggle="collapse" href="#generalCalendar">
              <i class="la flaticon-calendar"></i>
              <p>General Calendar</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/calendars') show
            @elseif(request()->path() == 'admin/calendar/create') show
            @elseif(request()->path() == 'admin/community-calendar') show
            @elseif(request()->path() == 'admin/calendar-settings') show
            @elseif(request()->is('admin/calendar/*/edit')) show
            @elseif(request()->is('admin/community-calendar/*/edit')) show
            @elseif(request()->is('admin/community-calendar/*/showCommunityCalendar')) show
            @endif" id="generalCalendar">
              <ul class="nav nav-collapse">

                <li class="
                 @if(request()->path() == 'admin/community-calendar' || request()->is('admin/community-calendar/*/edit') || request()->is('admin/community-calendar/*/showCommunityCalendar')) active
                 @endif">
                  <a href="{{route('admin.communityCalendar.index')}}">
                    <span class="sub-item">Calendar</span>
                  </a>
                </li>

                <li class="
                 @if(request()->path() == 'admin/calendars') active
                 @elseif(request()->path() == 'admin/calendar/create') active
                 @elseif(request()->is('admin/calendar/*/edit')) active
                 @endif">
                  <a href="{{route('admin.calendar.index')}}">
                    <span class="sub-item">Event</span>
                  </a>
                </li>

                <li class="
                 @if(request()->path() == 'admin/calendar-settings') active
                 @endif">
                  <a href="{{route('admin.calendarSetting.index')}}">
                    <span class="sub-item">Settings</span>
                  </a>
                </li>


              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Menu Builder', $permissions)))
          {{-- Drag & Drop Menu Builder --}}
          <li class="nav-item
          @if(request()->path() == 'admin/menu-builder') active
          @elseif(request()->path() == 'admin/top-menu-builder') active
          @endif">
            <a data-toggle="collapse" href="#menu-builder">
                <i class="fas fa-bars"></i>
              <p>Drag & Drop Menu Builder</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/menu-builder') show
            @elseif(request()->path() == 'admin/top-menu-builder') show
            @endif" id="menu-builder">
              <ul class="nav nav-collapse">
                <li class="@if(request()->path() == 'admin/top-menu-builder') active @endif">
                  <a href="{{route('admin.top_menu_builder.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Nav First Section</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/menu-builder') active @endif">
                  <a href="{{route('admin.menu_builder.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Nav Second Section</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Booking Management', $permissions)))
          {{-- Booking system --}}
          <li class="nav-item
          @if(request()->is('admin/booking-services')) active
          @elseif(request()->is('admin/booking-services/create')) active
          @elseif(request()->is('admin/booking-services/*/edit')) active
          @elseif(request()->is('admin/booking')) active
          @elseif(request()->is('admin/booking/setting')) active
          @elseif(request()->is('admin/booking/*')) active
          @elseif(request()->is('admin/booking/search')) active
          @elseif(request()->is('admin/transaction')) active
          @elseif(request()->is('admin/transaction/*')) active
          @endif">
            <a data-toggle="collapse" href="#booking-management">
              <i class="fa fa-book" aria-hidden="true"></i>
              <p>Booking Management</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->is('admin/booking-services')) show
            @elseif(request()->is('admin/booking-services/create')) show
            @elseif(request()->is('admin/booking-services/*/edit')) show
            @elseif(request()->is('admin/booking')) show
            @elseif(request()->is('admin/booking/setting')) show
            @elseif(request()->is('admin/booking/*')) show
            @elseif(request()->is('admin/booking/search')) show
            @elseif(request()->is('admin/transaction')) show
            @elseif(request()->is('admin/transaction/*')) show
            @endif" id="booking-management">
              <ul class="nav nav-collapse">

                @if($admin->role_id == 0)

                <li class="submenu">
                    <a data-toggle="collapse" href="#booking-service-management" aria-expanded="{{(request()->path() == 'admin/booking-services/create' || request()->path() == 'admin/booking-services' || request()->is('admin/booking-services/*/edit')) ? 'true' : 'false' }}">
                      <span class="sub-item">Service</span>
                      <span class="caret"></span>
                    </a>
                    <div class="collapse {{(request()->path() == 'admin/booking-services/create' || request()->path() == 'admin/booking-services' || request()->is('admin/booking-services/*/edit')) ? 'show' : '' }}" id="booking-service-management" style="">
                      <ul class="nav nav-collapse subnav">

                        <li class="@if(request()->path() == 'admin/booking-services/create' || request()->is('admin/booking-services/*/edit')) active @endif">
                          <a href="{{route('booking-services.create')}}">
                            <span class="sub-item">Add Service</span>
                          </a>
                        </li>

                        <li class="@if(request()->path() == 'admin/booking-services') active @endif">
                          <a href="{{route('booking-services.index')}}">
                            <span class="sub-item">Services List</span>
                          </a>
                        </li>

                      </ul>
                    </div>
                </li>

                <li class="@if(request()->path() == 'admin/booking' || request()->path() == 'admin/booking/search') active @endif">
                  <a href="{{ route('booking.index') }}">
                    <span class="sub-item">Booking List</span>
                  </a>
                </li>

                @if(isset($bs) && $bs->booking_payment == 1)
                  <li class="@if(request()->path() == 'admin/transaction' || request()->is('admin/transaction/*')) active @endif">
                    <a href="{{ route('transaction.index') }}">
                      <span class="sub-item">Transaction List</span>
                    </a>
                  </li>
                @endif

                <li class="@if(request()->is('admin/booking/setting')) active @endif">
                  <a href="{{ route('admin.booking.setting') }}">
                    <span class="sub-item">Payment Setting</span>
                  </a>
                </li>

                <li class="@if(request()->is('admin/booking/email-setting')) active @endif">
                  <a href="{{ route('admin.booking.emailSetting') }}">
                    <span class="sub-item">Email Setting</span>
                  </a>
                </li>

                @else
                  <li class="@if(request()->is('admin/my-booking')) active @endif">
                      <a href="{{ route('admin.booking.myBooking') }}">
                        <span class="sub-item">My Booking Lists</span>
                      </a>
                  </li>
                @endif

              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Education Management', $permissions)))
          {{-- Education Management --}}
          <li class="nav-item
          @if(request()->path() == 'admin/education-category') active
          @elseif(request()->path() == 'admin/education-tags') active
          @elseif(request()->path() == 'admin/education-blog') active
          @elseif(request()->is('admin/education-blog/*/edit')) active
          @elseif(request()->path() == 'admin/archives') active
          @endif">
            <a data-toggle="collapse" href="#education-management">
              <i class="la flaticon-chat-4"></i>
              <p>Education Management</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/education-category') show
            @elseif(request()->path() == 'admin/education-blog') show
            @elseif(request()->path() == 'admin/education-tags') show
            @elseif(request()->path() == 'admin/archives') show
            @elseif(request()->is('admin/education-blog/*/edit')) show
            @endif" id="education-management">
              <ul class="nav nav-collapse">
                <li class="@if(request()->path() == 'admin/education-category') active @endif">
                  <a href="{{route('admin.educationCategory.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Category</span>
                  </a>
                </li>
                <li class="
                @if(request()->path() == 'admin/education-tags') active
                @elseif(request()->is('admin/education-tags/*/edit')) active
                @endif">
                  <a href="{{route('admin.educationTags.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Tags</span>
                  </a>
                </li>
                <li class="
                @if(request()->path() == 'admin/education-blog') active
                @elseif(request()->is('admin/education-blog/*/edit')) active
                @endif">
                  <a href="{{route('admin.educationBlog.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Articles</span>
                  </a>
                </li>
                <?php /*
                <li class="@if(request()->path() == 'admin/archives') active @endif">
                  <a href="{{route('admin.archive.index')}}">
                    <span class="sub-item">Archives</span>
                  </a>
                </li> */ ?>
              </ul>
            </div>
          </li>
        @endif

        {{-- Backup Database --}}
        @if (empty($admin->role) || (!empty($permissions) && in_array('ChatDashboard', $permissions)))
          <li class="nav-item
          @if(request()->is('admin/chatboard/*')) active
          @elseif(request()->is('admin/chatboard/history/*')) active
          @endif">
              <a href="{{route('chatboard.index')}}">
                  <i class="fa fa-comment"></i>
                  <p>Chat Dashboard</p>
              </a>
          </li>
        @endif

        {{-- Backup Database --}}
        @if (empty($admin->role) || (!empty($permissions) && in_array('Customers', $permissions)))
          <li class="nav-item
          @if(request()->routeIs('admin.register.user')) active
          @elseif(request()->routeIs('register.user.view')) active
          @elseif(request()->routeIs('admin.register.user.edit')) active
          @elseif(request()->routeIs('admin.register.user.create')) active
          @endif">
              <a href="{{route('admin.register.user')}}">
                  <i class="la flaticon-users"></i>
                  <p>Customers</p>
              </a>
          </li>
        @endif



        @if (empty($admin->role) || (!empty($permissions) && in_array('Subscribers', $permissions)))
          {{-- Subscribers --}}
          <li class="nav-item
          @if(request()->path() == 'admin/subscribers') active
          @elseif(request()->path() == 'admin/mailsubscriber' || request()->is('admin/subscribers/*/edit')) active
          @endif">
            <a data-toggle="collapse" href="#subscribers">
              <i class="la flaticon-envelope"></i>
              <p>Subscribers</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/subscribers') show
            @elseif(request()->path() == 'admin/mailsubscriber' || request()->is('admin/subscribers/*/edit')) show
            @endif" id="subscribers">
              <ul class="nav nav-collapse">
                <li class="@if(request()->path() == 'admin/subscribers' || request()->is('admin/subscribers/*/edit')) active @endif">
                  <a href="{{route('admin.subscriber.index')}}">
                    <span class="sub-item">Subscribers</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/mailsubscriber') active @endif">
                  <a href="{{route('admin.mailsubscriber')}}">
                    <span class="sub-item">Mail to Subscribers</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Package Management', $permissions)))
          {{-- Package Management --}}
          <li class="nav-item
          @if(request()->path() == 'admin/packages') active
          @elseif(request()->path() == 'admin/package/form') active
          @elseif(request()->is('admin/package/*/inputEdit')) active
          @elseif(request()->path() == 'admin/all/orders') active
          @elseif(request()->path() == 'admin/pending/orders') active
          @elseif(request()->path() == 'admin/processing/orders') active
          @elseif(request()->path() == 'admin/completed/orders') active
          @elseif(request()->path() == 'admin/rejected/orders') active
          @endif">
            <a data-toggle="collapse" href="#packages">
              <i class="la flaticon-box-1"></i>
              <p>Package Management</p>
              <span class="caret"></span>
            </a>

            <div class="collapse
            @if(request()->path() == 'admin/packages') show
            @elseif(request()->path() == 'admin/package/form') show
            @elseif(request()->is('admin/package/*/inputEdit')) show
            @elseif(request()->path() == 'admin/all/orders') show
            @elseif(request()->path() == 'admin/pending/orders') show
            @elseif(request()->path() == 'admin/processing/orders') show
            @elseif(request()->path() == 'admin/completed/orders') show
            @elseif(request()->path() == 'admin/rejected/orders') show
            @endif" id="packages">
              <ul class="nav nav-collapse">
                <li class="
                @if(request()->path() == 'admin/package/form') active
                @elseif(request()->is('admin/package/*/inputEdit')) active
                @endif">
                  <a href="{{route('admin.package.form') . '?language=' . $default->code}}">
                    <span class="sub-item">Form Builder</span>

                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/packages') active @endif">
                  <a href="{{route('admin.package.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Packages</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/all/orders') active @endif">
                  <a href="{{route('admin.all.orders')}}">
                    <span class="sub-item">All Orders</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/pending/orders') active @endif">
                  <a href="{{route('admin.pending.orders')}}">
                    <span class="sub-item">Pending Orders</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/processing/orders') active @endif">
                  <a href="{{route('admin.processing.orders')}}">
                    <span class="sub-item">Processing Orders</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/completed/orders') active @endif">
                  <a href="{{route('admin.completed.orders')}}">
                    <span class="sub-item">Completed Orders</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/rejected/orders') active @endif">
                  <a href="{{route('admin.rejected.orders')}}">
                    <span class="sub-item">Rejected Orders</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif


        @if (empty($admin->role) || (!empty($permissions) && in_array('Quote Management', $permissions)))
          {{-- Quotes --}}
          <li class="nav-item
          @if(request()->path() == 'admin/quote/form') active
          @elseif(request()->is('admin/quote/*/inputEdit')) active
          @elseif(request()->path() == 'admin/all/quotes') active
          @elseif(request()->path() == 'admin/pending/quotes') active
          @elseif(request()->path() == 'admin/processing/quotes') active
          @elseif(request()->path() == 'admin/completed/quotes') active
          @elseif(request()->path() == 'admin/rejected/quotes') active
          @elseif(request()->path() == 'admin/quote/nav-menu') active
          @endif">
            <a data-toggle="collapse" href="#quote">
              <i class="la flaticon-list"></i>
              <p>Quote Management</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/quote/form') show
            @elseif(request()->is('admin/quote/*/inputEdit')) show
            @elseif(request()->path() == 'admin/all/quotes') show
            @elseif(request()->path() == 'admin/pending/quotes') show
            @elseif(request()->path() == 'admin/processing/quotes') show
            @elseif(request()->path() == 'admin/completed/quotes') show
            @elseif(request()->path() == 'admin/rejected/quotes') show
            @elseif(request()->path() == 'admin/quote/nav-menu') show
            @endif" id="quote">
              <ul class="nav nav-collapse">
                <li class="
                @if(request()->path() == 'admin/quote/nav-menu') active
                @endif">
                  <a href="{{route('admin.quote.navMenu') . '?language=' . $default->code}}">
                    <span class="sub-item">Nav Menu</span>
                  </a>
                </li>
                <li class="
                @if(request()->path() == 'admin/quote/form') active
                @elseif(request()->is('admin/quote/*/inputEdit')) active
                @endif">
                  <a href="{{route('admin.quote.form') . '?language=' . $default->code}}">
                    <span class="sub-item">Form Builder</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/all/quotes') active @endif">
                  <a href="{{route('admin.all.quotes')}}">
                    <span class="sub-item">All Quotes</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/pending/quotes') active @endif">
                  <a href="{{route('admin.pending.quotes')}}">
                    <span class="sub-item">Pending Quotes</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/processing/quotes') active @endif">
                  <a href="{{route('admin.processing.quotes')}}">
                    <span class="sub-item">Processing Quotes</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/completed/quotes') active @endif">
                  <a href="{{route('admin.completed.quotes')}}">
                    <span class="sub-item">Completed Quotes</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/rejected/quotes') active @endif">
                  <a href="{{route('admin.rejected.quotes')}}">
                    <span class="sub-item">Rejected Quotes</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Product Management', $permissions)))
          {{-- Product --}}
          <li class="nav-item
          @if(request()->path() == 'admin/category') active
          @elseif(request()->path() == 'admin/sub-category') active
          @elseif(request()->path() == 'admin/product') active
          @elseif(request()->is('admin/product/*/edit')) active
          @elseif(request()->path() == 'admin/product-template') active
          @elseif(request()->is('admin/product-template/*/edit')) active
          @elseif(request()->is('admin/category/*/edit')) active
          @elseif(request()->is('admin/sub-category/*/edit')) active
          @elseif(request()->path() == 'admin/product/all/orders') active
          @elseif(request()->path() == 'admin/product/pending/orders') active
          @elseif(request()->path() == 'admin/product/processing/orders') active
          @elseif(request()->path() == 'admin/product/completed/orders') active
          @elseif(request()->path() == 'admin/product/rejected/orders') active
          @elseif(request()->routeIs('admin.product.create')) active
          @elseif(request()->routeIs('admin.product.details')) active
          @elseif(request()->path() == 'admin/shipping') active
          @elseif(request()->routeIs('admin.shipping.edit')) active
          @elseif(request()->routeIs('admin.product.tags')) active
          @endif">
            <a data-toggle="collapse" href="#category">
              <i class="fab fa-product-hunt"></i>
              <p>Product Management</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/category') show
            @elseif(request()->is('admin/category/*/edit')) show
            @elseif(request()->path() == 'admin/product-template') show
            @elseif(request()->is('admin/product-template/*/edit')) show
            @elseif(request()->path() == 'admin/sub-category') show
            @elseif(request()->is('admin/sub-category/*/edit')) show
            @elseif(request()->path() == 'admin/product') show
            @elseif(request()->is('admin/product/*/edit')) show
            @elseif(request()->path() == 'admin/product/all/orders') show
            @elseif(request()->path() == 'admin/product/pending/orders') show
            @elseif(request()->path() == 'admin/product/processing/orders') show
            @elseif(request()->path() == 'admin/product/completed/orders') show
            @elseif(request()->path() == 'admin/product/rejected/orders') show
            @elseif(request()->routeIs('admin.product.create')) show
            @elseif(request()->routeIs('admin.product.details')) show
            @elseif(request()->path() == 'admin/shipping') show
            @elseif(request()->routeIs('admin.shipping.edit')) show
            @elseif(request()->routeIs('admin.product.tags')) show

            @endif" id="category">
              <ul class="nav nav-collapse">

                <li class="submenu">
                  <a data-toggle="collapse" href="#shopset" aria-expanded="{{(request()->path() == 'admin/shipping' || request()->routeIs('admin.shipping.edit')) || request()->routeIs('admin.product.tags') ? 'true' : 'false' }}">
                    <span class="sub-item">Shop Settings</span>
                    <span class="caret"></span>
                  </a>
                  <div class="collapse {{(request()->path() == 'admin/shipping' || request()->routeIs('admin.shipping.edit')) || request()->routeIs('admin.product.tags') ? 'show' : '' }}" id="shopset" style="">
                    <ul class="nav nav-collapse subnav">
                      <li class="
                      @if(request()->path() == 'admin/shipping') active
                      @elseif(request()->routeIs('admin.shipping.edit')) active
                      @endif">
                        <a href="{{route('admin.shipping.index'). '?language=' . $default->code}}">
                          <span class="sub-item">Shipping Charges</span>
                        </a>
                      </li>
                      <li class="@if(request()->routeIs('admin.product.tags')) active @endif">
                        <a href="{{route('admin.product.tags'). '?language=' . $default->code}}">
                          <span class="sub-item">Popular Tags</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>

                <li class="
                @if(request()->path() == 'admin/category') active
                @elseif(request()->is('admin/category/*/edit')) active
                @endif">
                  <a href="{{route('admin.category.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Category</span>
                  </a>
                </li>

                <li class="
                @if(request()->path() == 'admin/sub-category') active
                @elseif(request()->is('admin/sub-category/*/edit')) active
                @endif">
                  <a href="{{route('admin.sub-category.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Sub Category</span>
                  </a>
                </li>

                <li class="
                @if(request()->path() == 'admin/product-template') active
                @elseif(request()->is('admin/product-template/*/edit')) active
                @endif">
                  <a href="{{route('admin.product-template.index'). '?language=' . $default->code}}">
                    <span class="sub-item">Product Template</span>
                  </a>
                </li>


                <li class="
                @if(request()->path() == 'admin/product') active
                @elseif(request()->is('admin/product/*/edit')) active
                @elseif(request()->routeIs('admin.product.create')) active
                @endif">
                  <a href="{{route('admin.product.index'). '?language=' . $default->code}}">
                    <span class="sub-item">Products</span>
                  </a>
                </li>


                <li class="@if(request()->path() == 'admin/product/all/orders') active @endif">
                  <a href="{{route('admin.all.product.orders')}}">
                    <span class="sub-item">All Orders</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/product/pending/orders') active @endif">
                  <a href="{{route('admin.pending.product.orders')}}">
                    <span class="sub-item">Pending Orders</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/product/processing/orders') active @endif">
                  <a href="{{route('admin.processing.product.orders')}}">
                    <span class="sub-item">Processing Orders</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/product/completed/orders') active @endif">
                  <a href="{{route('admin.completed.product.orders')}}">
                    <span class="sub-item">Completed Orders</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/product/rejected/orders') active @endif">
                  <a href="{{route('admin.rejected.product.orders')}}">
                    <span class="sub-item">Rejected Orders</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Portfolio Management', $permissions)))
        <li class="nav-item
           @if(request()->path() == 'admin/portfolio-category') active
           @elseif(request()->path() == 'admin/portfolios') active
           @elseif(request()->path() == 'admin/portfolio/create') active
           @elseif(request()->is('admin/portfolio/*/edit')) active
           @endif">
            <a data-toggle="collapse" href="#portfolio_management">
                <i class="la flaticon-web-1"></i>
                <p>Portfolio Management</p>
                <span class="caret"></span>
            </a>
            <div class="collapse
               @if(request()->path() == 'admin/portfolio-category') show
               @elseif(request()->path() == 'admin/portfolios') show
               @elseif(request()->path() == 'admin/portfolio/create') show
               @elseif(request()->is('admin/portfolio/*/edit')) show
               @endif" id="portfolio_management">
                <ul class="nav nav-collapse">
                    <li class="@if(request()->path() == 'admin/portfolio-category') active @endif">
                        <a href="{{route('admin.portfolio-category.index') . '?language=' . $default->code}}">
                        <span class="sub-item">Category</span>
                        </a>
                    </li>

                    <li class="@if(request()->path() == 'admin/portfolios') active
                     @elseif(request()->path() == 'admin/portfolio/create') active
                     @elseif(request()->is('admin/portfolio/*/edit')) active
                     @endif">
                      <a href="{{route('admin.portfolio.index') . '?language=' . $default->code}}">
                        <span class="sub-item">Portfolio</span>
                      </a>
                    </li>

                </ul>
            </div>
        </li>
        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('FAQ Management', $permissions)))
          {{-- FAQ Management --}}
          <li class="nav-item
          @if(request()->path() == 'admin/faqs') active
          @elseif(request()->is('admin/faq/*/edit')) active
          @elseif(request()->path() == 'admin/customer-faqs') active
          @elseif(request()->is('admin/customer-faq/*/edit')) active
          @elseif(request()->path() == 'admin/faq-category') active
          @elseif(request()->is('admin/faq-category/*/edit')) active
          @endif">
            <a data-toggle="collapse" href="#cusotmer-faq-management">
              <i class="la flaticon-box-1"></i>
              <p>FAQ Management</p>
              <span class="caret"></span>
            </a>

            <div class="collapse
            @if(request()->path() == 'admin/faqs') show
            @elseif(request()->is('admin/faq/*/edit')) show
            @elseif(request()->path() == 'admin/customer-faqs') show
            @elseif(request()->is('admin/customer-faq/*/edit')) show
            @elseif(request()->path() == 'admin/faq-category') show
            @elseif(request()->is('admin/faq-category/*/edit')) show
            @endif" id="cusotmer-faq-management">
              <ul class="nav nav-collapse">

                <li class="@if(request()->path() == 'admin/faq-category' || request()->is('admin/faq-category/*/edit')) active @endif">
                  <a href="{{route('admin.faq-category.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Category</span>
                  </a>
                </li>

                <li class="
                @if(request()->path() == 'admin/customer-faqs') active
                @elseif(request()->is('admin/customer-faq/*/edit')) active
                @endif">
                  <a href="{{route('admin.customer-faq.index') . '?language=' . $default->code}}">
                    <span class="sub-item">Cusotmer FAQ</span>
                  </a>
                </li>

                <li class="
                @if(request()->path() == 'admin/faqs') active
                @elseif(request()->is('admin/faq/*/edit')) active
                @endif">
                  <a href="{{route('admin.faq.index') . '?language=' . $default->code}}">
                    <span class="sub-item">FAQ</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>
      @endif


      @if (empty($admin->role) || (!empty($permissions) && in_array('Tickets', $permissions)))
        {{-- Tickets --}}
        <li class="nav-item
            @if(request()->path() == 'admin/all/tickets') active
            @elseif(request()->path() == 'admin/pending/tickets') active
            @elseif(request()->path() == 'admin/open/tickets') active
            @elseif(request()->path() == 'admin/closed/tickets') active
            @elseif(request()->routeIs('admin.ticket.messages')) active
            @endif">
            <a data-toggle="collapse" href="#tickets">
                <i class="la flaticon-web-1"></i>
                <p>Tickets</p>
                <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/all/tickets') show
            @elseif(request()->path() == 'admin/pending/tickets') show
            @elseif(request()->path() == 'admin/open/tickets') show
            @elseif(request()->path() == 'admin/closed/tickets') show
            @elseif(request()->routeIs('admin.ticket.messages')) show
            @endif" id="tickets">
                <ul class="nav nav-collapse">
                    <li class="@if(request()->path() == 'admin/all/tickets') active @endif">
                        <a href="{{route('admin.tickets.all')}}">
                        <span class="sub-item">All Tickets</span>
                        </a>
                    </li>
                    <li class="@if(request()->path() == 'admin/pending/tickets') active @endif">
                        <a href="{{route('admin.tickets.pending')}}">
                        <span class="sub-item">Pending Tickets</span>
                        </a>
                    </li>
                    <li class="@if(request()->path() == 'admin/open/tickets') active @endif">
                        <a href="{{route('admin.tickets.open')}}">
                        <span class="sub-item">Open Tickets</span>
                        </a>
                    </li>
                    <li class="@if(request()->path() == 'admin/closed/tickets') active @endif">
                        <a href="{{route('admin.tickets.closed')}}">
                        <span class="sub-item">Closed Tickets</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

  @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Payment Gateways', $permissions)))
          {{-- Payment Gateways --}}
          <li class="nav-item
          @if(request()->path() == 'admin/gateways') active
          @elseif(request()->path() == 'admin/offline/gateways') active
          @endif">
            <a data-toggle="collapse" href="#gateways">
              <i class="la flaticon-paypal"></i>
              <p>Payment Gateways</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/gateways') show
            @elseif(request()->path() == 'admin/offline/gateways') show
            @endif" id="gateways">
              <ul class="nav nav-collapse">
                <li class="@if(request()->path() == 'admin/gateways') active @endif">
                  <a href="{{route('admin.gateway.index')}}">
                    <span class="sub-item">Online Gateways</span>
                  </a>
                </li>
                <li class="@if(request()->path() == 'admin/offline/gateways') active @endif">
                  <a href="{{route('admin.gateway.offline') . '?language=' . $default->code}}">
                    <span class="sub-item">Offline Gateways</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

        @endif

        @if (empty($admin->role) || (!empty($permissions) && in_array('Basic Settings', $permissions)))
          {{-- Basic Settings --}}
          <li class="nav-item
          @if(request()->path() == 'admin/roles') active
          @elseif(request()->is('admin/role/*/permissions/manage')) active
          @elseif(request()->path() == 'admin/users') active
          @elseif(request()->is('admin/user/*/edit')) active
          @elseif(request()->path() == 'admin/languages') active
          @elseif(request()->is('admin/language/*/edit')) active
          @elseif(request()->is('admin/language/*/edit/keyword')) active
          @elseif(request()->path() == 'admin/sitemap') active
          @elseif(request()->path() == 'admin/backup') active
          @elseif(request()->path() == 'admin/rss/create') active
          @elseif(request()->path() == 'admin/rss/feeds') active
          @elseif(request()->path() == 'admin/rss') active
          @elseif(request()->is('admin/rss/edit/*')) active
          @endif">
            <a data-toggle="collapse" href="#siteSettings">
              <i class="la flaticon-settings"></i>
              <p>Site Settings</p>
              <span class="caret"></span>
            </a>
            <div class="collapse
            @if(request()->path() == 'admin/roles') show
            @elseif(request()->is('admin/role/*/permissions/manage')) show
            @elseif(request()->path() == 'admin/users') show
            @elseif(request()->is('admin/user/*/edit')) show
            @elseif(request()->path() == 'admin/languages') show
            @elseif(request()->is('admin/language/*/edit')) show
            @elseif(request()->is('admin/language/*/edit/keyword')) show
            @elseif(request()->path() == 'admin/sitemap') show
            @elseif(request()->path() == 'admin/backup') show
            @elseif(request()->path() == 'admin/rss/create') show
            @elseif(request()->path() == 'admin/rss/feeds') show
            @elseif(request()->path() == 'admin/rss') show
            @elseif(request()->is('admin/rss/edit/*')) show
            @endif" id="siteSettings">
              <ul class="nav nav-collapse">

                @if (empty($admin->role) || (!empty($permissions) && in_array('Role Management', $permissions)))
                  {{-- Role Management Page --}}
                  <li class="@if(request()->path() == 'admin/roles') active
                    @elseif(request()->is('admin/role/*/permissions/manage')) active
                    @endif">
                    <a href="{{route('admin.role.index')}}">
                      <span class="sub-item">Role Management</span>
                    </a>
                  </li>
                @endif

                @if (empty($admin->role) || (!empty($permissions) && in_array('Users Management', $permissions)))
                  {{-- Role Management Page --}}
                  <li class="@if(request()->path() == 'admin/users') active
                   @elseif(request()->is('admin/user/*/edit')) active
                   @endif">
                    <a href="{{route('admin.user.index')}}">
                      <span class="sub-item">Users Management</span>
                    </a>
                  </li>
                @endif

                @if (empty($admin->role) || (!empty($permissions) && in_array('Technicians Management', $permissions)))
                {{-- Role Management Page --}}
                <li class="@if(request()->path() == 'admin/technicians') active
                 @elseif(request()->is('admin/technician/*/edit')) active
                 @endif">
                  <a href="{{route('admin.technician.index')}}">
                    <span class="sub-item"> Technicians</span>
                  </a>
                </li>
              @endif


              @if (empty($admin->role) || (!empty($permissions) && in_array('Customers Management', $permissions)))
              {{-- Role Management Page --}}
              <li class="@if(request()->path() == 'admin/companies') active
               @elseif(request()->is('')) active
               @endif">
                <a href="{{route('admin.customers.index')}}">
                  <span class="sub-item">Customers</span>
                </a>
              </li>
            @endif




                @if (empty($admin->role) || (!empty($permissions) && in_array('Language Management', $permissions)))
                  {{-- Language Management Page --}}
                  <li class="@if(request()->path() == 'admin/languages') active
                   @elseif(request()->is('admin/language/*/edit')) active
                   @elseif(request()->is('admin/language/*/edit/keyword')) active
                   @endif">
                    <a href="{{route('admin.language.index')}}">
                      <span class="sub-item">Language Management </span>
                    </a>
                  </li>
                @endif

                @if (empty($admin->role) || (!empty($permissions) && in_array('Sitemap', $permissions)))
                  {{-- Sitemap--}}
                  <li class="@if(request()->path() == 'admin/sitemap') active @endif">
                    <a href="{{route('admin.sitemap.index') . '?language=' . $default->code}}">
                      <span class="sub-item">Sitemap</span>
                    </a>
                  </li>
                @endif

                @if (empty($admin->role) || (!empty($permissions) && in_array('Backup', $permissions)))
                {{-- Backup Database --}}
                <li class="@if(request()->path() == 'admin/backup') active
                 @endif">
                  <a href="{{route('admin.backup.index')}}">
                    <span class="sub-item">Backup</span>
                  </a>
                </li>
                @endif

                {{-- Cache Clear --}}
                <li class="">
                  <a href="{{route('admin.cache.clear')}}">
                    <span class="sub-item">Clear Cache</span>
                  </a>
                </li>

                @if (empty($admin->role) || (!empty($permissions) && in_array('RSS Feeds', $permissions)))
                  <li class="submenu">
                      <a data-toggle="collapse" href="#rss" aria-expanded="{{(request()->path() == 'admin/rss/create' || request()->path() == 'admin/rss/feeds' || request()->path() == 'admin/rss' || request()->is('admin/rss/edit/*')) ? 'true' : 'false' }}">
                        <span class="sub-item">RSS Feeds</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse {{(request()->path() == 'admin/rss/create' || request()->path() == 'admin/rss/feeds' || request()->path() == 'admin/rss' || request()->is('admin/rss/edit/*')) ? 'show' : '' }}" id="rss" style="">
                        <ul class="nav nav-collapse subnav">

                          <li class="@if(request()->path() == 'admin/rss/create') active @endif">
                            <a href="{{route('admin.rss.create')}}">
                              <span class="sub-item">Import RSS Feeds</span>
                            </a>
                          </li>

                          <li class="@if(request()->path() == 'admin/rss/feeds') active @endif">
                            <a href="{{route('admin.rss.feed'). '?language=' . $default->code}}">
                              <span class="sub-item">RSS Feeds</span>
                            </a>
                          </li>

                          <li class="@if(request()->path() == 'admin/rss') active @endif">
                            <a href="{{route('admin.rss.index'). '?language=' . $default->code}}">
                              <span class="sub-item">RSS Posts</span>
                            </a>
                          </li>

                        </ul>
                      </div>
                  </li>
                @endif

              </ul>
            </div>
          </li>
        @endif

      </ul>
    </div>
  </div>
</div>
