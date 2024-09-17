@extends('front.default.layout')

@section('pagename')
 - {{__('Team Members')}}
@endsection

@section('meta-keywords', "$be->team_meta_keywords")
@section('meta-description', "$be->team_meta_description")

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
                 <span>{{convertUtf8($bs->team_title)}}</span>
                 <h1>{{convertUtf8($bs->team_subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{__('Team Members')}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


  <!--   team page start   -->
  <div class="team-page">
    <div class="container">
      <div class="row">
        @foreach ($members as $key => $member)
          <div class="col-lg-3 col-sm-6">
            <div class="single-team-member" data-link="{{route('front.dynamicMemberPage',$member->slug)}}">
               <div class="team-img-wrapper">
                  <img src="{{asset('assets/front/img/members/'.$member->image)}}" alt="">
                  @if($member->display_facebook == 1 ||
                        $member->display_instagram == 1 ||
                        $member->display_linkedin == 1 || 
                        $member->display_twitter == 1
                  )
                  <div class="social-accounts">
                     <ul class="social-account-lists">
                        @if($member->display_facebook == 1)

                           @if (!empty($member->facebook))
                                    <li class="single-social-account"><a target="_blank" href="{{$member->facebook}}"><i class="fab fa-facebook-f"></i></a></li>
                                 @else
                                    <li class="single-social-account"><a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a></li>
                                 @endif

                        @endif

                        @if($member->display_twitter == 1)

                              @if (!empty($member->twitter))
                                 <li class="single-social-account"><a target="_blank" href="{{$member->twitter}}"><i class="fab fa-twitter"></i></a></li>
                              @else
                                 <li class="single-social-account"><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>
                              @endif

                        @endif

                        @if($member->display_linkedin == 1)

                              @if (!empty($member->linkedin))
                                 <li class="single-social-account"><a target="_blank" href="{{$member->linkedin}}"><i class="fab fa-linkedin-in"></i></a></li>
                              @else
                                 <li class="single-social-account"><a href="javascript:void(0)"><i class="fab fa-linkedin-in"></i></a></li>
                              @endif

                        @endif

                        @if($member->display_instagram == 1)

                              @if (!empty($member->instagram))
                                 <li class="single-social-account"><a target="_blank" href="{{$member->instagram}}"><i class="fab fa-instagram"></i></a></li>
                              @else
                                 <li class="single-social-account"><a href="javascript:void(0)"><i class="fab fa-instagram"></i></a></li>
                              @endif

                        @endif
                     </ul>
                  </div>
                  @endif
               </div>
               <div class="member-info">
                  <h5 class="member-name">{{convertUtf8($member->name)}}</h5>
                  <small>{{convertUtf8($member->rank)}}</small>
               </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <!--   team page end   -->
@endsection

@section('scripts')
  <script>

      $(document).on('click','.single-team-member',function(){
         
         var link = $(this).attr('data-link');
         window.location = link;
      });
  </script>
@endsection
