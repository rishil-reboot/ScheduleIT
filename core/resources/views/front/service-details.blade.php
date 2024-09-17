@extends("front.$version.layout")

@section('pagename')
 - {{__('Service')}} - {{convertUtf8($service->title)}}
@endsection

@section('meta-keywords', "$service->meta_keywords")
@section('meta-description', "$service->meta_description")

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
                 <span>{{convertUtf8($bs->service_details_title)}}</span>
                 <h1>{{convertUtf8($service->title)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{__('Service Details')}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


  <!--    services details section start   -->
  <div class="pt-115 pb-110 service-details-section">
     <div class="container">
        <div class="row">
           <div class="col-lg-7">
              <div class="service-details">
                {!! replaceBaseUrl(convertUtf8($service->content)) !!}
              </div>
           </div>
           <!--    service sidebar start   -->
           <div class="col-lg-4">
             <div class="blog-sidebar-widgets">
                <div class="searchbar-form-section">
                   <form action="{{route('front.services')}}">
                      <div class="searchbar">
                         <input name="category" type="hidden" value="{{request()->input('category')}}">
                         <input name="term" type="text" placeholder="{{__('Search Services')}}" value="{{request()->input('term')}}">
                         <button type="submit"><i class="fa fa-search"></i></button>
                      </div>
                   </form>
                </div>
             </div>
             @if (hasCategory($be->theme_version))
             <div class="blog-sidebar-widgets category-widget">
                <div class="category-lists job">
                   <h4>{{__('Categories')}}</h4>
                   <ul>
                      @foreach ($scats as $key => $scat)
                        <li class="single-category {{(!empty($service->scategory) && $service->scategory->id == $scat->id) ? 'active' : ''}}"><a href="{{route('front.serviceCategory',$scat->slug)}}">{{convertUtf8($scat->name)}}</a></li>
                      @endforeach
                   </ul>
                </div>
             </div>
             @endif
            @include('front.subscribe_common')
           </div>
           <!--    service sidebar end   -->
        </div>
     </div>
  </div>
  <!--    services details section end   -->

@endsection
