@extends("front.$version.layout")

@section('pagename')
-
{{__('Login')}}
@endsection


@section('meta-keywords', "$be->login_meta_keywords")
@section('meta-description', "$be->login_meta_description")


@section('content')
<!--   hero area start   -->
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


    <!--   hero area start    -->
    <div class="login-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="login-content">
                        <div class="login-title">
                            <h3 class="title">{{__('Login')}}</h3>
                        </div>
                        <form id="loginForm" action="{{route('user.login')}}" method="POST">
                            @csrf
                            <div class="input-box">
                                <span>{{__('Email')}} *</span>
                                <input type="email" name="email" value="{{Request::old('email')}}">
                                @if(Session::has('err'))
                                <p class="text-danger mb-2 mt-2">{{Session::get('err')}}</p>
                                @endif
                                @error('email')
                                <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                                @enderror
                            </div>
                            <div class="input-box mb-4">
                                <span>{{__('Password')}} *</span>
                                <input type="password" name="password" value="{{Request::old('password')}}">
                                @error('password')
                                <p class="text-danger mb-2 mt-2">{{ convertUtf8($message) }}</p>
                                @enderror
                            </div>

                            @if ($bs->is_recaptcha == 1)
                            <div class="d-block mb-4">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                @php
                                $errmsg = $errors->first('g-recaptcha-response');
                                @endphp
                                <p class="text-danger mb-0 mt-2">{{__("$errmsg")}}</p>
                                @endif
                            </div>
                            @endif
                            @if($bex->is_terms_and_conditions == 1)
                            <div class="d-block mb-2">
                                <label class="form-check-label" for="terms_and_conditions">By logging in, you agree to our </label> <a href="#" data-toggle="modal" data-target="#terms-and-conditions-modal">Terms and Conditions</a>
                            </div>
                            @endif


                            <!-- Modal -->
                            <div class="modal fade" id="terms-and-conditions-modal" tabindex="-1" role="dialog" aria-labelledby="terms-and-conditions-modal-label" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="terms-and-conditions-modal-label">Terms and Conditions</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div style="height: 300px; overflow-y: auto;">
                                                {!! replaceBaseUrl(convertUtf8($terms_and_conditions->body)) !!}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="input-btn">
                                <button type="submit">{{__('LOG IN')}}</button><br>
                                <p class="float-lg-right float-left">{{__("Don't have an account ?")}} <a href="{{route('user-register')}}">{{__('Click Here')}}</a> {{__('to create one.')}}</p>
                                <a class="mr-3" href="{{route('user-forgot')}}">{{__('Lost your password?')}}</a>
                                @if($be->is_twilio == 1)
                                <a href="{{ route('user.login.otp') }}">Login with OTP</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   hero area end    -->
    @endsection