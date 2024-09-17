@extends("front.$version.layout")

@section('pagename')
- {{__('Login with OTP')}}
@endsection

@section('meta-keywords', "$be->login_meta_keywords")
@section('meta-description', "$be->login_meta_description")

@section('content')
<!-- Hero Area Start -->
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
                        <h1>{{__('Sign In')}}</h1>
                        <ul class="breadcumb">
                            <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                            <li>{{__('Sign In')}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-area-overlay"></div>
    </div>
    <!--   hero area end    -->
    <!-- OTP Form Area Start -->
    <div class="login-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="login-content">
                        <div class="login-title">
                            <h3 class="title">{{__('Login with OTP')}}</h3>
                        </div>
                        <form action="{{ route('user.login.sendOtpTwilio') }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <span>{{__('Phone Number')}} *</span>
                                <input type="text" name="number" value="{{ $phoneNumber  }}" required>
                                @error('number')
                                <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="input-btn mt-4">
                                <button type="submit">{{__('Send OTP')}}</button>
                            </div>
                        </form>

                        @if (session('success'))
                        <!-- Verification Form -->
                        <form action="{{ route('user.login.verifyMOtp') }}" method="POST">
                            @csrf
                            <div class="input-box">
                                <span>{{__('Enter OTP')}} *</span>
                                <input type="hidden" name="number" value="{{ old('number', $phoneNumber) }}">
                                <input type="text" name="otp" required>
                                @error('otp')
                                <p class="text-danger mb-2 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="input-btn mt-4">
                                <button type="submit">{{__('Verify OTP')}}</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- OTP Form Area End -->


    @endsection