   @extends("front.$version.layout")
    @section('content')
        <!-- Preloader -->
        <div id="preloader">
            <div id="loader"></div>
        </div>

        <!-- Banner-Section-Start -->
        <section class="banner_section">
            <!-- container start -->
            <div class="container">
                <!-- vertical animation line -->
                <div class="anim_line">
                    <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}" alt="anim_line"></span>
                    <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}" alt="anim_line"></span>
                </div>
                <!-- row start -->
                <div class="row">
                    <!--   hero area start   -->
                    @if ($bs->home_version == 'static')
                      @includeif("front.$version.partials.static")
                    @endif

                    <!-- banner slides start -->
                    <div class="col-lg-6 col-md-12" data-aos="fade-in" data-aos-duration="1500">
                        <div class="banner_slider">
                            <div class="left_icon">
                                <img src="{{ asset('assets/front/theme-images/message_icon.png') }}" alt="image">
                            </div>
                            <div class="right_icon">
                                <img src="{{ asset('assets/front/theme-images/shield_icon.png') }}" alt="image">
                            </div>
                            <div id="frmae_slider" class="owl-carousel owl-theme">
                                @foreach($portfolioimgs as $portfolio_image)
                                <div class="item">
                                    <div class="slider_img">
                                        <img src="{{ asset('assets/front/img/portfolios/sliders/' . $portfolio_image) }}" alt="image">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{-- <div class="slider_frame">
                                <img src="{{ asset('assets/front/theme-images/mobile_frame_svg.svg') }}"
                                    alt="image">
                            </div> --}}
                        </div>
                    </div>
                    <!-- banner slides end -->

                </div>
                <!-- row end -->
            </div>
            <!-- container end -->
        </section>
        <!-- Banner-Section-end -->

        <!-- Features-Section-Start -->
        <section class="row_am features_section" id="features">
            <!-- container start -->
            <div class="container">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                    <!-- h2 -->
                    <h2>{{$bs->feature_section_title}}</h2>
                    <!-- p -->
                    <p>{{$bs->feature_section_subtitle}}</p>
                </div>
                <div class="feature_detail">
                    <!-- feature box left -->

                    @php
                        $half = ceil($page_feature->count() / 2);
                        // dd($half,$page_feature->slice(0, $half),$page_feature->slice($half));
                        $leftFeatures = $page_feature->slice(0, $half);
                        $rightFeatures = $page_feature->slice($half);
                    @endphp

                    <div class="left_data feature_box">
                        @foreach ($leftFeatures as $feature)
                            <!-- feature box -->
                            <div class="data_block" data-aos="fade-right" data-aos-duration="1500">
                                <div class="icon">
                                    <i class="{{$feature->icon}}"></i>
                                </div>
                                <div class="text">
                                    <h4>{{ $feature->title }}</h4>
                                    <p>{{ $feature->subtitle }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        <!-- feature box -->
                    </div>

                    <!-- feature box right -->
                    <div class="right_data feature_box">
                        @foreach ($rightFeatures as $feature)
                            <!-- feature box -->
                            <div class="data_block" data-aos="fade-left" data-aos-duration="1500">
                                <div class="icon">
                                    <i class="{{$feature->icon}}"></i>
                                </div>
                                <div class="text">
                                    <h4>{{ $feature->title }}</h4>
                                    <p>{{ $feature->subtitle }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- feature image -->
                    <div class="feature_img" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                        <img src="{{asset('assets/front/img/portfolios/featured/' . $portfolio60->featured_image)}}" alt="image"style="max-height: 650px;">
                    </div>
                </div>
            </div>
            <!-- container end -->
        </section>
        <!-- Features-Section-end -->

        <!-- About-App-Section-Start -->
        <section class="row_am about_app_section">
            <!-- container start -->
            <div class="container">
                <!-- row start -->
                <div class="row">
                    <div class="col-lg-6">

                        <!-- about images -->
                        <div class="about_img" data-aos="fade-in" data-aos-duration="1500">
                            <div class="frame_img">
                                <img src="{{asset('assets/front/img/'.$be->statistics_bg)}}" alt="image" class="img-fluid" style="max-height: 650px;">
                            </div>
                            <div class="screen_img">
                                <img class="moving_animation img-fluid" src="{{ asset('assets/front/img/'.$bs->logo) }}" alt="image" style="max-width: 150px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">

                        <!-- about text -->
                        <div class="about_text">
                            <div class="section_title" data-aos="fade-up" data-aos-duration="1500"
                                data-aos-delay="100">

                                <!-- h2 -->
                                <h2>{{ $bs->statistics_section_title}}</h2>

                                <!-- p -->
                                <p>
                                    {{$bs->statistics_section_subtitle}}
                                </p>
                            </div>

                            <!-- UL -->
                            <ul class="app_statstic" id="counter" data-aos="fade-in" data-aos-duration="1500">
                                @foreach ($statistics as $stats)
                                    @if ($stats->title == 'HAPPY CLIENTS')
                                        <li>
                                            <div class="icon">
                                                <i class="{{$stats->icon}}"></i>
                                            </div>
                                            <div class="text">
                                                <p><span class="counter-value"
                                                        data-count="{{ $stats->quantity }}">0</span><span></span>
                                                </p>
                                                <p>{{convertUtf8($stats->title)}}</p>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($stats->title == 'COMPLETED PROJECTS')
                                        <li>
                                            <div class="icon">
                                                <i class="{{$stats->icon}}"></i>
                                            </div>
                                            <div class="text">
                                                <p><span class="counter-value" data-count="{{ $stats->quantity }}">0
                                                    </span><span></span></p>
                                                <p>{{convertUtf8($stats->title)}}</p>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($stats->title == 'POSITIVE REVIEWS')
                                        <li>
                                            <div class="icon">
                                                <i class="{{$stats->icon}}"></i>
                                            </div>
                                            <div class="text">
                                                <p><span class="counter-value"
                                                        data-count="{{ $stats->quantity }}"></span><span>+</span></p>
                                                <p>{{convertUtf8($stats->title)}}</p>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($stats->title == 'COUNTRIES')
                                        <li>
                                            <div class="icon">
                                                <i class="{{$stats->icon}}"></i>
                                            </div>
                                            <div class="text">
                                                <p><span class="counter-value"
                                                        data-count="{{ $stats->quantity }}"></span><span>+</span></p>
                                                <p>{{convertUtf8($stats->title)}}</p>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <!-- UL end -->

                        </div>
                    </div>
                </div>
                <!-- row end -->
            </div>
            <!-- container end -->
        </section>
        <!-- About-App-Section-end -->

        <!-- How-It-Workes-Section-Start -->
        <section class="row_am how_it_works" id="how_it_work">
            <!-- container start -->
            <div class="container">
                <div class="how_it_inner">
                    <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                        <!-- h2 -->
                        <h2>{{$bs->steps_section_title}}</h2>
                        <!-- p -->
                        <p>{{$bs->steps_section_subtitle}}</p>
                    </div>
                    <div class="step_block">
                        <!-- UL -->
                        <ul>
                            @foreach($steps as $step)
                            <li>
                                @if($step->serial_number % 2 !== 0)
                                <div class="step_text" data-aos="fade-right" data-aos-duration="1500">
                                    <h4>{{ $step->title }}</h4>
                                    <div class="app_icon">
                                        <a href="#"><i class="icofont-brand-android-robot"></i></a>
                                    </div>
                                    <p>{{ $step->description }}</p>
                                </div>
                                <div class="step_number">
                                    <h3>{{ $step->step_number }}</h3>
                                </div>
                                <div class="step_img" data-aos="fade-left" data-aos-duration="1500">
                                    <img src="{{asset('assets/front/img/steps/'.$step->image)}}" alt="image">
                                </div>
                                @else
                                <div class="step_text" data-aos="fade-left" data-aos-duration="1500">
                                    <h4>{{ $step->title }}</h4>
                                    {{-- <span>14 days free trial</span> --}}
                                    <p>{{ $step->description }}</p>
                                </div>
                                <div class="step_number">
                                    <h3>{{ $step->step_number }}</h3>
                                </div>
                                <div class="step_img" data-aos="fade-right" data-aos-duration="1500">
                                    <img src="{{asset('assets/front/img/steps/'.$step->image)}}" alt="image">
                                </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

                <!-- video section start -->
                <div class="yt_video" data-aos="fade-in" data-aos-duration="1500">
                    <!-- animation line -->
                    <div class="anim_line dark_bg">
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                    </div>
                    <div class="thumbnil">
                        <img src="{{ asset('assets/front/theme-images/yt_thumb.png') }}" alt="image">
                        <a class="popup-youtube play-button"
                            data-url="{{ $bs->hero_section_video_link }}" data-toggle="modal"
                            data-target="#myModal" title="XJj2PbenIsU">
                            <span class="play_btn">
                                <img src="{{ asset('assets/front/theme-images/play_icon.png') }}" alt="image">
                                <div class="waves-block">
                                    <div class="waves wave-1"></div>
                                    <div class="waves wave-2"></div>
                                    <div class="waves wave-3"></div>
                                </div>
                            </span>
                            {{$bs->hero_section_title}}
                            <span> {{$bs->hero_section_button_text}}</span>
                        </a>
                    </div>
                </div>
                <!-- video section end -->
            </div>
            <!-- container end -->
        </section>
        <!-- How-It-Workes-Section-end -->

        <!-- Testimonial-Section start -->
        <section class="row_am testimonial_section">
            <!-- container start -->
            <div class="container">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                    <!-- h2 -->
                    <h2><span>{{$bs->testimonial_title}}</span></h2>
                    <!-- p -->
                    <p>{{$bs->testimonial_subtitle}}</p>
                </div>
                <div class="testimonial_block" data-aos="fade-in" data-aos-duration="1500">
                    <div id="testimonial_slider" class="owl-carousel owl-theme">
                        @foreach ($testimonials as $testimonial)
                            <!-- user 1 -->
                            <div class="item">
                                <div class="testimonial_slide_box">
                                    <div class="rating">
                                        <span><i class="icofont-star"></i></span>
                                        <span><i class="icofont-star"></i></span>
                                        <span><i class="icofont-star"></i></span>
                                        <span><i class="icofont-star"></i></span>
                                        <span><i class="icofont-star"></i></span>
                                    </div>

                                    <p class="review">
                                        {{ $testimonial->comment }}
                                    </p>
                                    <div class="testimonial_img">
                                        <img src="{{asset('assets/front/img/testimonials/' .$testimonial->image) }}" alt="image">
                                    </div>
                                    <h3>{{ $testimonial->name }}</h3>
                                    <span class="designation">{{ $testimonial->rank }}</span>
                                </div>
                            </div>
                        @endforeach
                        <!-- user 3 -->
                    </div>

                    <!-- total review -->
                    <div class="total_review">
                        <div class="rating">
                            <span><i class="icofont-star"></i></span>
                            <span><i class="icofont-star"></i></span>
                            <span><i class="icofont-star"></i></span>
                            <span><i class="icofont-star"></i></span>
                            <span><i class="icofont-star"></i></span>
                            <p>5.0 / 5.0</p>
                        </div>
                        <h3>{{ $testimonials->count() }}</h3>
                        <a href="#">TOTAL USER REVIEWS <i class="icofont-arrow-right"></i></a>
                    </div>

                    <!-- avtar faces -->
                    <div class="avtar_faces">
                        <img src="{{ asset('assets/front/theme-images/avtar_testimonial.png') }}" alt="image">
                    </div>
                </div>
            </div>
            <!-- container end -->
        </section>
        <!-- Testimonial-Section end -->

        <!-- Pricing-Section -->
        <section class="row_am pricing_section" id="pricing">
            <!-- container start -->
            <div class="container">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                    <!-- h2 -->
                    <h2>{{ $be->pricing_title }}</h2>
                    <!-- p -->
                    <p>{{ $be->pricing_subtitle }}</p>
                </div>
                <!-- pricing box  monthly start -->
                <div class="pricing_pannel monthly_plan active" data-aos="fade-up" data-aos-duration="1500">
                    <!-- row start -->
                    <div class="row">
                        <!-- pricing box 1 -->
                        @foreach ($packages as $package)
                        {{-- @if($package->price_type==2) --}}
                            <div class="col-md-4">
                                <div class="pricing_block ">
                                    <div class="icon">
                                        <img src="{{asset('assets/front/img/packages/' .$package->image) }}" alt="image">
                                    </div>
                                    <div class="pkg_name">
                                        <h3>{{ $package->title }}</h3>
                                        <span>For the basics</span>
                                    </div>
                                    <span class="price">{{ $package->price }}</span>
                                    <ul class="benifits">
                                        <li>
                                            <p> {!! replaceBaseUrl(convertUtf8($package->description)) !!}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- @endif --}}
                        @endforeach

                    </div>
                    <!-- row end -->
                </div>
                <!-- pricing box monthly end -->

                <p class="contact_text" data-aos="fade-up" data-aos-duration="1500">Not sure what to choose ? <a
                        href="{{route('front.contact')}}">contact us</a> for custom packages</p>
            </div>
            <!-- container start end -->
        </section>
        <!-- Pricing-Section end -->

        <!-- FAQ-Section start -->
        <section class="row_am faq_section">
            <!-- container start -->
            <div class="container">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                    <!-- h2 -->
                    <h2><span>{{$bs->faq_title}}</span> </h2>
                    <!-- p -->
                    <p>{{$bs->faq_subtitle}}</p>
                </div>
                <!-- faq data -->
                <div class="faq_panel">
                    <div class="accordion" id="accordionExample">
                        @foreach($faqs as $index => $faq)
                        <div class="card" data-aos="fade-up" data-aos-duration="1500">
                            <div class="card-header" id="heading{{$index}}">
                                <h2 class="mb-0">
                                    <button type="button" class="btn btn-link {{ $loop->first ? '' : 'collapsed' }}" data-toggle="collapse"
                                        data-target="#collapse{{$index}}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{$index}}">
                                        <i class="icon_faq icofont-plus"></i>{{$faq->question}}
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse{{$index}}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{$index}}"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <p>{{$faq->answer}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <!-- container end -->
        </section>
        <!-- FAQ-Section end -->

        <!-- Beautifull-interface-Section start -->
        <section class="row_am interface_section">
            <!-- container start -->
            <div class="container-fluid">
                <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
                    <!-- h2 -->
                    <h2>{{$bs->portfolio_title}}</h2>
                    <!-- p -->
                    {{-- @foreach($portfolios as $portfolio)
                    @if($portfolio->title=='YouTextme') --}}
                    <p>
                        {{$bs->portfolio_subtitle}}
                    </p>
                    {{-- @endif
                    @endforeach --}}
                </div>

                <!-- screen slider start -->
                <div class="screen_slider">
                    <div id="screen_slider" class="owl-carousel owl-theme">
                        @foreach($portfolioimgs as $portfolio_image)
                        <div class="item">
                            <div class="screen_frame_img">
                                <img src="{{ asset('assets/front/img/portfolios/sliders/' . $portfolio_image) }}" alt="image">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- screen slider end -->
            </div>
            <!-- container end -->
        </section>
        <!-- Beautifull-interface-Section end -->

        <!-- Download-Free-App-section-Start  -->
        <section class="row_am free_app_section" id="getstarted">
            <!-- container start -->
            <div class="container">
                <div class="free_app_inner" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
                    <!-- vertical line animation -->
                    <div class="anim_line dark_bg">
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                        <span><img src="{{ asset('assets/front/theme-images/anim_line.png') }}"
                                alt="anim_line"></span>
                    </div>
                    <!-- row start -->
                    <div class="row">
                        <!-- content -->

                        <div class="col-md-6">
                            <div class="free_text">
                                <div class="section_title">
                                    @if ($FreeAppSections)
                                        <h2>{{ $FreeAppSections->title }}</h2>
                                        <p>{{ $FreeAppSections->subtitle }}</p>
                                    @else
                                        <h2>YouTextme</h2>
                                        <p>Click on below link to download</p>
                                    @endif
                                </div>
                                <ul class="app_btn">
                                    <li>
                                        <a href="{{$bs->hero_section_button_url}}" target="_blank">
                                            <img src="{{ asset('assets/front/theme-images/googleplay_blue.png') }}"
                                                alt="image">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- images -->
                        <div class="col-md-6">
                            <div class="free_img">
                                {{-- <p>{{$FreeAppSections->freeAppsectionImages}}</p> --}}
                                @foreach ($FreeAppSections->freeAppsectionImages as $image)
                                        <img src="{{ asset('assets/front/theme-images/' . $image->image) }}" style="max-height:500px" alt="">
                                        <img class="mobile_mockup" src="{{ asset('assets/front/img/free-app/sliders/' . $image->image) }}" style="max-height:500px" alt="image">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- row end -->
                </div>
            </div>
            <!-- container end -->
        </section>
        <!-- Download-Free-App-section-end  -->

        <!-- Story-Section-Start -->
        <section class="row_am latest_story" id="blog">
            <!-- container start -->
            <div class="container">
                <div class="section_title" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
                    <h2>{{$bs->blog_section_title}}<span></span></h2>
                    <p>{{$bs->blog_section_subtitle}}</p>
                </div>
                <!-- row start -->
                <div class="row">
                    <!-- story -->
                    @foreach($blogs as $blog)
                    <div class="col-md-4">
                        <div class="story_box" data-aos="fade-up" data-aos-duration="1500">
                            <div class="story_img">
                                <img src="{{asset('assets/front/img/blogs/' .$blog->main_image) }}" alt="image">
                                <span>{{$blog->publish_at}}</span>
                            </div>
                            <div class="story_text">
                                <h3>{{$blog->title}}</h3>
                                <p>{{$blog->meta_description}}</p>
                                <a href="{{route('front.blogdetails', [$blog->slug])}}" class="readmore-btn"><span>{{__('Read More')}}</span></a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <!-- row end -->
            </div>
            <!-- container end -->
        </section>
        <!-- Story-Section-end -->

        <!-- News-Letter-Section-Start -->
        <section class="newsletter_section">
            <!-- container start -->
            <div class="container">
                <div class="newsletter_box">
                    <div class="section_title" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100">
                        <!-- h2 -->
                        <h2>Subscribe newsletter</h2>
                        <!-- p -->
                        <p>{{$bs->newsletter_text}}</p>
                    </div>
                    <form  action="{{route('front.subscribe')}}"  method="post" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="100"
                    class="footer-newsletter" id="footerSubscribeForm" >
                    @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" >
                            <p id="erremail" class="text-danger mb-0 err-email"></p>
                        </div>
                        <div class="form-group">
                            <button class="btn">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- container end -->
        </section>
        <!-- News-Letter-Section-end -->

        <!-- VIDEO MODAL -->
        <div class="modal fade youtube-video" id="myModal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <button id="close-video" type="button" class="button btn btn-default text-right"
                        data-dismiss="modal">
                        <i class="icofont-close-line-circled"></i>
                    </button>
                    <div class="modal-body">
                        <div id="video-container" class="video-container">
                            <iframe id="youtubevideo" src="" width="640" height="360" frameborder="0"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>

        <div class="purple_backdrop"></div>
        @endsection

        @section('scripts')

        <script>
            $(document).ready(function() {
              $("#subscribeForm, #footerSubscribeForm").on('submit', function(e) {
                // console.log($(this).attr('id'));

                e.preventDefault();

                let formId = $(this).attr('id');
                let fd = new FormData(document.getElementById(formId));
                let $this = $(this);

                $.ajax({
                  url: $(this).attr('action'),
                  type: $(this).attr('method'),
                  data: fd,
                  contentType: false,
                  processData: false,
                  success: function(data) {
                    // console.log(data);
                        if ((data.errors)) {
                    $this.find(".err-email").html(data.errors.email[0]);
                    } else {
                    toastr["success"]("You are subscribed successfully!");
                    $this.trigger('reset');
                    $this.find(".err-email").html('');
                    }
                  }
                });
              });
            });
          </script>
@endsection
