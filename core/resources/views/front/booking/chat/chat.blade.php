@extends('user.layout')

@section('pagename')
 - {{__('Dashboard')}}
@endsection

@section('styleSection')
    
    <link href="{{asset('assets/booking/user/css/new.css')}}" rel="stylesheet" type="text/css" />
    
    <style type="text/css">
        
        /*chat start*/
        .chat-scroll{height: 500px; overflow-y: auto;}

        .messages-list li .chat-img-client{
            position: absolute;
            top: 0px;
            width: 48px; height: 48px;
        }
        .messages-list li.out-msg .chat-img-client{
            right: -80px;
        }

        .messages-list li.in-msg .chat-img-client{
            left: -80px;
        }
        /*chat end*/
        
    </style>

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
                        <h1>Chat</h1>
                        <ul class="breadcumb">
                            <li>{{__('Dashboard')}}</li>
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
                <div class="widget">
                    <div class="widget-header" id="client-name">
                        <div class="widget-header" id="client-name">
                            <div class="title"> {{ $authDetail->username }}</div>
                        </div>
                    </div>
                    <br>
                    <div class="widget-body chat-scroll" id="msg-box">
                        <ul class="messages-list clearfix mrgn_20b" id="message-list">
                            <!--<div class="refresh"></div>-->
                            <?php
                            foreach ($chatMessages as $message) {
                                $time = date("Y-m-d", strtotime($message->created_at));
                                $now = date("Y-m-d");

                                if ($time == $now) {
                                    $time = date("h:i A", strtotime($message->created_at));
                                } else {
                                    $time = date("d-m-Y", strtotime($message->created_at));
                                }
                                if ($message->message_type == 'in-msg') {
                                    $msgType = 'out-msg';
                                    $img = !empty($authDetail->photo) ? asset('assets/front/img/user/'.$authDetail->photo) : asset('assets/front/img/user/default.png');
                                } else {
                                    $msgType = 'in-msg';
                                    $img =  asset('assets/front/img/'.$bs->logo);
                                }
                                echo '<li class="' . $msgType . '"><img src="'. $img . '" class="chat-img-client">' . $message->message_content . ' <span class="msg-time">(' . $time . ')</span></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="panel-footer" style="margin-top: 15px;">
                        <form onsubmit="return false" action="" class="newMessage" name="newMessage">
                            <div class="input-group" id="client-messager">
                                <input type="text" name="messages_content" id="messages_content" class="form-control input-lg" placeholder="{!! trans('user/chat.type_message') !!}"  style="height:46px !important;">
                                <span class="input-group-btn">
                                    <input name="submit" value="{!! trans('user/chat.send') !!}" id="sendMessage" class="btn btn-primary" type="submit" style="padding: 12px 25px;">
                                </span> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')

<script>
    //refresh chatbox
    $.ajaxSetup({
        cache: false    //use for i.e browser to clean cache
    });

    $(setInterval(function () {
        $('#msg-box').load(location.href + " #message-list", function () {
            $('#msg-box').prop({scrollTop: $('#msg-box').prop('scrollHeight')}) //if the messages overflowed this line tells the textarea to focus the latest message
        });
    }, 2000));
    //end code

    $(function () {
        $('#sendMessage').click(function () {
            var message = $('#messages_content').val();

            if (message == "") {
                return false;
            }
            $.ajax({
                type: "POST",
                url: "{{route('user-chat-store')}}",
                data: {
                    message: message,
                    _token: "{!! csrf_token() !!}"
                },
                success: function () {
                    $('#messages_content').val('');
                }
            });
        });
    });

</script>

@endsection
