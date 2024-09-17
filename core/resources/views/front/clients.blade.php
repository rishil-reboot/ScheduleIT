@extends("front.$version.layout")

@section('pagename')
 - Partner
@endsection

@section('meta-keywords', "$bs->client_meta_keyword")
@section('meta-description', "$bs->client_meta_description")

@section('styles')
<style type="text/css">
   .contact-form-section {
       padding: 50px 0px 50px;
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
                 <span>{{convertUtf8($bs->client_section_title)}}</span>
                 <h1>{{convertUtf8($bs->client_section_subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{ $bs->client_section_title }}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


  <div class="contact-form-section">
     <div class="container">
         <div class="row">
            <div class="col-lg-12">
               {{convertUtf8($bs->client_section_title)}}
            </div>
           
         </div>
      </div>
  </div>
   
   @if(isset($clients) && !$clients->isEmpty())
      <section class="client-section">
         <div class="container">
            <div class="team-carousel common-carousel owl-carousel owl-theme">
                @foreach ($clients as $key => $partner)
                     <a href=@if(!empty($partner->slug))  {{route('front.clientDetail',$partner->slug)}} @else javascript:void(0) @endif>
                       <div class="single-team-member">
                             <div class="team-img-wrapper">
                                 <img src="{{asset('assets/front/img/client/'.$partner->image)}}" alt="">
                             </div>
                       </div>
                     </a>
                @endforeach
            </div>
         </div>
      </section>
   @endif

    <!--    contact form and map start   -->
   @if(!empty($bs->client_section_description))
     <div class="contact-form-section">
        <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  {!! $bs->client_section_description !!}
               </div>
              
            </div>
         </div>
     </div>
   @endif

  <!--    contact form and map end   -->
@endsection

@section('scripts')


@endsection


