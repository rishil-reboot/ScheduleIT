@extends("front.$version.layout")

@section('pagename')
 - Partner
@endsection

@section('meta-keywords', "$bs->partner_meta_keyword")
@section('meta-description', "$bs->partner_meta_description")

@section('styles')
<style type="text/css">
   .contact-form-section {
       padding: 50px 0px 50px !important; 
   }
</style>
@endsection
@section('content')
   
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
                 <span>{{convertUtf8($bs->partner_section_title)}}</span>
                 <h1>{{convertUtf8($bs->partner_section_subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{ $bs->partner_section_title }}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


   <!--    contact form and map start   -->
   @if(!empty($bs->partner_section_description))
     <div class="contact-form-section">
        <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  {!! $bs->partner_section_description !!}
               </div>
              
            </div>
         </div>
     </div>
   @endif

   @if ($bs->partner_section == 1 && isset($partners) && !$partners->isEmpty())

      <section class="client-section" style="padding-bottom: 50px;">
          <div class="container">

              <div class="team-carousel common-carousel owl-carousel owl-theme">
                  @foreach ($partners as $key => $partner)
                  
                  <div class="item">
                      <div class="client-section-box">
                          <a href="@if(!empty($partner->slug))  {{route('front.partnerDetail',$partner->slug)}} @else javascript:void(0) @endif">
                              <div class="img-holder zoom-effect">
                                  <img src="{{asset('assets/front/img/partners/'.$partner->image)}}" alt="">
                              </div>
                          </a>
                      </div>
                  </div>
                  @endforeach
              </div>
          </div>
      </section>

   @endif

  <!--    contact form and map end   -->
@endsection

@section('scripts')


@endsection


