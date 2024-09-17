@extends("front.$version.layout")

@section('pagename')
 - {{convertUtf8($clientDetail->name)}}
@endsection

@section('meta-keywords', "$clientDetail->meta_keywords")
@section('meta-description', "$clientDetail->meta_description")

@section('content')
   
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
                 <h1>{{strlen(convertUtf8($clientDetail->name)) > 30 ? substr(convertUtf8($clientDetail->name), 0, 30) . '...' : convertUtf8($clientDetail->name)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>Partner</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  
  <div class="blog-details-section section-padding">
     <div class="container">
        <div class="row">
           <div class="col-lg-7">
               <div class="blog-details">

                 <h2 class="blog-details-title">{{convertUtf8($clientDetail->name)}}</h2>

                @if(!empty($clientDetail->url))

                    <ul class="blog-commment mb-15 mt-15" style="display:flex;margin-bottom: 20px;">
                        
                        @if(!empty($clientDetail->url))
                            <li style="margin-left:10px">
                                <strong>
                                    <a style="color:#007bff" href="{{$clientDetail->url}}" target="_blank">Visit Link</a>
                                </strong> 
                            </li>
                        @endif  

                    </ul>

                @endif
                
                  @if(!empty($clientDetail->description))
                     <div style="margin-bottom:20px">
                        <p>{{ $clientDetail->description }}</p>
                     </div>
                  @endif
                  @if(!empty($clientDetail->long_description))
                     <div class="blog-details-body">
                      {!! replaceBaseUrl(convertUtf8($clientDetail->long_description)) !!}
                     </div>
                  @endif
              </div>
            </div>

            <div class="col-lg-4">
               <div class="sidebar">
                     <div class="blog-sidebar-widgets">
                       <div class="searchbar-form-section">
                           <div class="img-holder zoom-effect">
                               <img width="250px" src="{{asset('assets/front/img/client/'.$clientDetail->image)}}" alt="">
                           </div>        
                       </div>
                     </div>
                     <div class="blog-sidebar-widgets category-widget">
                        <div class="category-lists job">
                           <h4>Address</h4>
                           @if(!empty($clientDetail->address))
                            {!! $clientDetail->address !!}
                           @endif

                           @if(!empty($clientDetail->state))
                              <br> <span style="color:#007bff">State:</span> {{$clientDetail->state}}
                           @endif
                           @if(!empty($clientDetail->city))
                              <br> <span style="color:#007bff">City:</span> {{$clientDetail->city}}
                           @endif
                           @if(!empty($clientDetail->zip))
                              <br> <span style="color:#007bff">Zipcode:</span> {{$clientDetail->zip}}
                           @endif
                        </div>
                     </div>
               </div>
           </div>


         </div>
     </div>
  </div>
   


@endsection

@section('scripts')

@endsection
