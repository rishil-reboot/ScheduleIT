@extends("front.$version.layout")


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
                    <h1>{{__('Success!')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                        <li>{{__('Success')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area-overlay"></div>
  </div>


  <div class="checkout-message">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="checkout-success">
                      <div class="icon text-success"><i class="far fa-check-circle"></i></div>
                      <h2>{{__('Success!')}}</h2>
                      <p>{{__('Your order has been placed successfully!')}}</p>
                      <p>{{__('We have sent you a mail with an invoice.')}}</p>
                      <p class="mt-4">{{__('Thank you.')}}</p>
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
