@extends('user.layout')

@section('pagename')
 - {{__('Billing Details')}}
@endsection

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
        <div class="breadcrumb-txt" style="padding:{{$breadcumPaddingDashboard}}">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>{{__('Billing Details')}}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
                        <li>{{__('Billing Details')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area-overlay"></div>
</div>
<!--   hero area end    -->
     <!--====== CHECKOUT PART START ======-->
     <section class="user-dashbord">
        <div class="container">
            <div class="row">
                @include('user.inc.site_bar')
                <div class="col-lg-9">
                    <div class="row justify-content-md-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header"><strong>Two Factor Authentication</strong></div>
                                <div class="card-body">
                                    <p style="margin-bottom: 20px">Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>
                                    
                                    @if($data['user']->loginSecurity == null)
                                        <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                                            {{ csrf_field() }}
                                            <hr>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    Generate Secret Key to Enable 2FA
                                                </button>
                                            </div>
                                        </form>
                                    @elseif(!$data['user']->loginSecurity->google2fa_enable)
                                        1. Scan this QR code with your Google Authenticator App. Alternatively, you can use the code: <code>{{ $data['secret'] }}</code><br/>
                                        <img src="{{$data['google2fa_url'] }}" alt="">
                                        <br/><br/>
                                        2. Enter the pin from Google Authenticator app:<br/><br/>
                                        <form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                                <label for="secret" class="control-label">Authenticator Code</label>
                                                <input id="secret" type="password" class="form-control col-md-4" name="secret" required>
                                                @if ($errors->has('verify-code'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('verify-code') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                Enable 2FA
                                            </button>
                                        </form>
                                    @elseif($data['user']->loginSecurity->google2fa_enable)
                                        <div class="alert alert-success">
                                            2FA is currently <strong>enabled</strong> on your account.
                                        </div>
                                        <p style="margin-bottom: 20px">If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.</p>
                                        <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                                <label for="change-password" class="control-label">Current Password</label>
                                                    <input id="current-password" type="password" class="form-control col-md-4" name="current-password" required>
                                                    @if ($errors->has('current-password'))
                                                        <span class="help-block">
                                                    <strong>{{ $errors->first('current-password') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                            <button type="submit" class="btn btn-primary ">Disable 2FA</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

