<div class="col-lg-6 col-md-12" data-aos="fade-right" data-aos-duration="1500">
    <!-- banner text -->
    <div class="banner_text">
        <h1 style="font-size: {{$be->hero_section_title_font_size}}px">{{convertUtf8($bs->hero_section_title)}}</h1>
        <p style="font-size: {{$be->hero_section_text_font_size}}px">{{convertUtf8($bs->hero_section_text)}}
        </p>
        @if (!empty($bs->hero_section_button_url) && !empty($bs->hero_section_button_text))
               <a href="{{$bs->hero_section_button_url}}" class="hero-boxed-btn" target="_blank" style="font-size: {{$be->hero_section_button_text_font_size}}px">{{convertUtf8($bs->hero_section_button_text)}}</a>
               @endif
    </div>
    <!-- app buttons -->
    <ul class="app_btn">
        <li>
            <a href="{{$bs->hero_section_button_url}}" target="_blank">
                <img class="blue_img"
                    src="{{ asset('assets/front/theme-images/googleplay_blue.png') }}"
                    alt="image">
                <img class="white_img"
                    src="{{ asset('assets/front/theme-images/googleplay_white.png') }}"
                    alt="image">
            </a>
        </li>
    </ul>
</div>
