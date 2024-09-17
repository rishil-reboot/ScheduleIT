<div class="top_footer" id="contact">
    <!-- animation line -->
    <div class="anim_line dark_bg">
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
    <!-- container start -->
    <div class="container">
        <!-- row start -->
        <div class="row">
            <!-- footer link 1 -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="abt_side">
                    <div class="logo"></div>
                    <ul>
                        <li class="text-white"><i class="fa fa-home me-4"></i><span>{{convertUtf8($bs->contact_address)}}</span>
                        </li>
                     <li class="text-white"><i class="fa fa-phone"></i><span>{{convertUtf8($bs->contact_number)}}</span></li>
                           <li class="text-white"><i class="far fa-envelope"></i><span>{{convertUtf8($be->to_mail)}}</span></li>
                    </ul>
                    <ul class="social_media">
                        @foreach($socials as $social)
                        <li><a href="{{$social->url}}" target="_blank"><i class="{{$social->icon}}"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <?php

            $footerGroupLink = \App\FooterGroupLinkName::with(['ulink'])
                                    ->orderBy('serial_number','ASC')
                                    ->has('ulink')
                                    ->get();
          ?>

            <!-- footer link 2 -->
            @if(isset($footerGroupLink) && !$footerGroupLink->isEmpty())

            @foreach($footerGroupLink as $key=>$value2)
            <div class="col-lg-3 col-md-6 col-12">
                <div class="links">
                    <h3>{{$value2->name}}</h3>
                    @foreach($value2->ulink as $key3=>$value3)
                    <ul>
                        <li><a href="{{$value3->url}}">{{$value3->name}}</a></li>
                    </ul>
                    @endforeach
                </div>
            </div>
            @endforeach
            @endif
            <!-- footer link 3 -->
            {{-- <div class="col-lg-3 col-md-6 col-12">
                <div class="links">
                    @if (strlen(convertUtf8($bs->footer_text)) > 194)
                    {{substr(convertUtf8($bs->footer_text), 0, 194)}}<span style="display: none;">{{substr(convertUtf8($bs->footer_text), 194)}}</span>
                        <p> <a href="#" class="see-more">see more...</a></p>
                        @else
                       <p> {{convertUtf8($bs->footer_text)}}</p>
                     @endif
                </div>
            </div> --}}





            <!-- footer link 4 -->
            <div class="col-lg-2 col-md-6 col-12">
                <div class="try_out">
                    <h3>Let’s Try Out</h3>
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
        </div>
        <!-- row end -->
    </div>
    <!-- container end -->
</div>

<!-- last footer -->
<div class="bottom_footer">
    <!-- container start -->
    <div class="container">
        <!-- row start -->
        <div class="row">
            <div class="col-md-6">
                <p>{!! replaceBaseUrl(str_replace('###YEAR###',date('Y'),$bs->copyright_text)) !!}</p>
            </div>
            <div class="col-md-6">
                <p class="developer_text">{{$bs->powered_by_text}}    <a href="@if(!empty($bs->powered_by_url)) {{$bs->powered_by_url}} @else javascript:void(0) @endif" @if(!empty($bs->powered_by_url)) target="_blank" @endif>
                    <img src="{{asset('assets/front/img/'.$bs->powered_by_logo)}}" style="max-width: 50px" class="mr-4">
                 </a></p>
            </div>
        </div>


        <!-- row end -->
    </div>
    <!-- container end -->
</div>

<!-- go top button -->
<div class="go_top">
    <span><img src="{{ asset('assets/front/theme-images/go_top.png') }}" alt="image"></span>
</div>
