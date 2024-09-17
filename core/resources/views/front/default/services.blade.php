@extends('front.default.layout')

@section('pagename')
 -
 @if (empty($category))
 {{__('All')}}
 @else
 {{$category->name}}
 @endif
 {{__('Services')}}
@endsection

@section('meta-keywords', "$be->services_meta_keywords")
@section('meta-description', "$be->services_meta_description")

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
                 <span>{{convertUtf8($bs->service_title)}}</span>
                 <h1>{{convertUtf8($bs->service_subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{__('Services')}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


  <!--    services section start   -->
  <div class="service-section">
     <div class="container">
        <div class="row">
           <div class="col-lg-8">
              <div class="row">
                @if (count($services) == 0)
                  <div class="col-12 bg-light py-5">
                    <h3 class="text-center">{{__('NO SERVICE FOUND')}}</h3>
                  </div>
                @else
                  @foreach ($services as $key => $service)
                    <div class="col-md-6">
                       <div class="single-service">
                          <div class="service-img-wrapper">
                             <img src="{{asset('assets/front/img/services/'.$service->main_image)}}" alt="">
                          </div>
                          <div class="service-txt">

                            <h4 class="service-title"><a @if($service->details_page_status == 1) href="{{route('front.servicedetails', [$service->slug])}}" @endif>{{convertUtf8(strlen($service->title)) > 18 ? convertUtf8(substr($service->title, 0, 18)) . '...' : convertUtf8($service->title)}}</a></h4>

                            <p class="service-summary">
                                @if (strlen(convertUtf8($service->summary)) > 102)
                                   {{substr(convertUtf8($service->summary), 0, 102)}}<span style="display: none;">{{substr(convertUtf8($service->summary), 102)}}</span>
                                   <a href="#" class="see-more">see more...</a>
                                @else
                                   {{convertUtf8($service->summary)}}
                                @endif
                            </p>

                             @if ($service->details_page_status == 1)
                             <a href="{{route('front.servicedetails', [$service->slug])}}" class="readmore-btn"><span>{{__('Read More')}}</span></a>
                             @endif

                          </div>
                       </div>
                    </div>
                  @endforeach
                @endif
              </div>
              <div class="row">
                 <div class="col-md-12">
                    <nav class="pagination-nav">
                      {{$services->appends(['category' => request()->input('category'), 'term' => request()->input('term')])->links()}}
                    </nav>
                 </div>
              </div>
           </div>
           <!--    service sidebar start   -->
           <div class="col-lg-4">
             <div class="blog-sidebar-widgets">
                <div class="searchbar-form-section">
                   @if(!empty($sCategorySlug))
                     <form action="{{route('front.serviceCategory',$sCategorySlug)}}">
                   @else
                     <form action="{{route('front.services')}}">
                   @endif
                      <div class="searchbar">
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
                       <li class="single-category {{$scat->slug == $sCategorySlug ? 'active' : ''}}"><a href="{{route('front.serviceCategory',$scat->slug)}}">{{convertUtf8($scat->name)}}</a></li>
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
  <!--    services section end   -->
@endsection
