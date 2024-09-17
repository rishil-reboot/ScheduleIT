@extends("front.$version.layout")

@section('pagename')
 - Testimonial
@endsection

@section('meta-keywords', "$be->testimonial_meta_keyword")
@section('meta-description', "$be->testimonial_meta_description") 


@section('content')
        
        <style type="text/css">
        
        .owl-dots .owl-dot.active {
            background-color: white !important;
        }

        .owl-dots .owl-dot {
            background: white !important;
        }
    </style>

  <!--   breadcrumb area start   -->
    @if($bs->breadcum_type == 1)

      <div class="breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
    @else

      <div class="breadcrumb-area blogs video-container">
         <video autoplay muted loop>
            <source src="{{asset('assets/front/img/breadcrumb/')}}/{{$bs->breadcum_video}}" type="video/mp4" />
         </video>
    @endif
      
      <div class="container">
        <div class="breadcrumb-txt" style="padding:{{$breadcumPadding}}">
           <div class="row">
              <div class="col-xl-7 col-lg-8 col-sm-10">
                 <h1>{{convertUtf8($bs->testimonial_title)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{convertUtf8($bs->testimonial_title)}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->



  @if ($bs->testimonial_section == 1)
  <!--   Testimonial section start    -->
  <div class="testimonial-section pb-115">
     <div class="container">
        <div class="row text-center">
           <div class="col-lg-6 offset-lg-3">
              <h2 class="section-summary">{{convertUtf8($bs->testimonial_subtitle)}}</h2>
           </div>
        </div>
        <div class="row">
           <div class="col-md-12">
              <div class="testimonial-carousel owl-carousel owl-theme">
                 @foreach ($testimonials as $key => $testimonial)
                   <div class="single-testimonial">
                      <div class="img-wrapper"><img src="{{asset('assets/front/img/testimonials/'.$testimonial->image)}}" alt=""></div>
                      <div class="client-desc">
                         <p class="comment">{{convertUtf8($testimonial->comment)}}</p>
                         <h6 class="name">{{convertUtf8($testimonial->name)}}</h6>
                         <p class="rank">{{convertUtf8($testimonial->rank)}}</p>
                      </div>
                   </div>
                 @endforeach
              </div>
           </div>
        </div>
     </div>
  </div>
  <!--   Testimonial section end    -->
  @endif
  <!--   about company section end   -->
@endsection
@section('scripts')
<script>
    
    var rtl = {{ $rtl }};

    // testimonial carousel
    var testimonialResponsive = {
        0: {
            items: 1
        },
        992: {
            items: 2
        },
    };
    owlCarsouelActivate('.testimonial-carousel', false, testimonialResponsive, 5000, 1500, true, false, 1500, true, 30);

    // Partner carousel
    var partnerResponsive = {
        0: {
            items: 2
        },
        576: {
            items: 3
        },
        992: {
            items: 5
        },
    };
    owlCarsouelActivate('.partner-carousel', true, partnerResponsive, 3000, 500, false, false, 1500, true, 30);

    //owl carousel activate function
    function owlCarsouelActivate(selector, nav, responsive, autoplayTimeout, autoplaySpeed, dots, animateOut, smartSpeed, autoplayHoverPause, margin = 0, loop = false, autoplay = false) {
        var $selector = $(selector);
        if ($selector.length > 0) {
            $selector.owlCarousel({
                loop: loop,
                autoplay: false,
                autoplayTimeout: autoplayTimeout,
                autoplaySpeed: autoplaySpeed,
                dots: dots,
                nav: nav,
                navText: ["<i class='flaticon-left-arrow'></i>", "<i class='flaticon-right-arrow'></i>"],
                smartSpeed: smartSpeed,
                autoplayHoverPause: autoplayHoverPause,
                animateOut: animateOut,
                margin: margin,
                responsive: responsive,
                rtl: rtl == 1 ? true : false
            });
        }
    }

</script>

@endsection
