<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
  	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>{{$bs->website_title}}</title>
  	<link rel="icon" href="{{asset('assets/front/img/'.$bs->favicon)}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/login.css')}}">
  </head>
  <body>
    <div class="login-page">
      <div class="text-center mb-4">
        <img class="login-logo" src="{{asset('assets/front/img/'.$bs->logo)}}" alt="">
      </div>
      <div class="form">
        @if (session()->has('alert'))
          <div class="alert alert-danger fade show" role="alert" style="font-size: 14px;">
            <strong>Oops!</strong> {{session('alert')}}
          </div>
        @endif
        <form class="login-form" action="{{route('admin.auth')}}" method="POST">
          @csrf
          <input type="text" name="username" placeholder="username"/>
          @if ($errors->has('username'))
            <p class="text-danger text-left">{{$errors->first('username')}}</p>
          @endif
          <input type="password" name="password" placeholder="password"/>
          @if ($errors->has('password'))
            <p class="text-danger text-left">{{$errors->first('password')}}</p>
          @endif

          @if ($bs->is_recaptcha == 1)


                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}
                @if ($errors->has('g-recaptcha-response'))
                @php
                    $errmsg = $errors->first('g-recaptcha-response');
                @endphp
                <p class="text-danger mb-0 mt-2">{{__("$errmsg")}}</p>
                @endif
          @endif


          <button type="submit">login</button>
        </form>
        <a class="forget-link" href="{{route('admin.forget.form')}}">Forgot Password / Username ?</a>
      </div>
    </div>


    <!-- jquery js -->
    <script src="{{asset('assets/front/js/jquery-3.3.1.min.js')}}"></script>
    <!-- popper js -->
    <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
    <!-- Bootstrap Notify -->
    <script src="{{asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    @if (session()->has('warning'))
    <script>
      var content = {};

      content.message = '{{session('warning')}}';
      content.title = 'Sorry!';
      content.icon = 'fa fa-bell';

      $.notify(content,{
        type: 'warning',
        placement: {
          from: 'top',
          align: 'right'
        },
        showProgressbar: true,
        time: 1000,
        delay: 4000,
      });
    </script>
    @endif

    <script type="text/javascript">
         $(function(){
            function rescaleCaptcha(){
              var width = $('.g-recaptcha').parent().width();
              var scale;
              if (width < 302) {
                scale = width / 302;
              } else{
                scale = 1.0;
              }

              $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
              $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
              $('.g-recaptcha').css('transform-origin', '0 0');
              $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
            }

            rescaleCaptcha();
            $( window ).resize(function() { rescaleCaptcha(); });

          });
    </script>

  </body>
</html>
