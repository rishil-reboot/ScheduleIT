@extends("front.$version.layout")

@section('pagename')
-
Verify
@endsection

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
                        <h1>Verify</h1>
                        <ul class="breadcumb">
                            <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                            <li>Verify</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-area-overlay"></div>
    </div>

    <div class="login-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="login-content">
                        <div class="login-title">
                            <h3 class="title">Verify</h3>
                        </div>
                        <form id="loginForm" action="{{route('user.login.verifyAndLogin')}}" method="POST">
                            @csrf
                            <div class="input-box mb-4">
                                @if(Session::has('phoneNumber'))
                                @php
                                $credit = \App\TwilioCredit::all();
                                @endphp
                                @if(!$credit->isEmpty())
                                <span>{{ $credit->first()->verify_page_text }} {{ substr(Session::get('phoneNumber'), -4) }}</span>
                                @endif
                                @else
                                <span>One Time Password *</span>
                                @endif
                                <input type="password" name="otp" value="{{Request::old('otp')}}">
                                @error('otp')
                                <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                                @enderror
                                @if(Session::has('err'))
                                <p class="text-danger mb-2 mt-2">{{Session::get('err')}}</p>
                                @endif
                            </div>

                            <div class="input-btn">
                                <button type="submit">Verify</button>
                                @if(Session::has('phoneNumber'))
                                <a class="ml-2" href="{{route('user.login.resendOtp')}}">Resend Code</a>
                                @endif
                                <br>
                                <p class="float-lg-right float-left">{{__("Don't have an account ?")}} <a href="{{route('user-register')}}">{{__('Click Here')}}</a> {{__('to create one.')}}</p>
                                <a class="mr-3" href="{{route('user.login')}}">Click here to Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection