@extends('admin.layout')

@section('styles')

@include('admin.booking_common._booking_common_css')

<style type="text/css">
    .input-group-addon, .input-group-btn {
        width: 11% !important;
    }
</style>
@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Chat Dashboard</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Chat Dashboard</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body pt-5 pb-5">
                    <div class="content-wrapper">
                        <!-- Content Header (Page header) -->
                        <section class="content-header">
                            <h1>{!! trans('admin/chat.online_users_list') !!}</h1>
                        </section>
                        <!-- Main content -->
                        <section class="content">
                            <!-- Main row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Notifications -->
                                    @include('admin.includes.notifications')
                                    <!-- ./ notifications -->
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-success">
                                        <div class="box-body" id="online-list">
                                            <ul class="products-list product-list-in-box" id="user-list">
                                                <?php foreach ($users as $data): ?>
                                                    <?php 
                                                    $img = !empty($data->photo) ? asset('assets/front/img/user/'.$data->photo) : asset('assets/front/img/user/default.png');
                                                    $msgCount = \App\BookingChat::where('user_id', $data->id)->where('message_read', '0')->where('message_type', 'in-msg')->count();
                                                    ?>
                                                    <li class="item">
                                                        <div class="product-img">
                                                            <img src="{!! $img !!}" width="100" alt="User Image">
                                                        </div>
                                                        <div class="product-info">
                                                            <a href="{{ route('admin.chatboard.showhistory',$data->id)}}" class="product-title">
                                                                @if($data->fname !=null && $data->lname !=null)
                                                                    {!! $data->fname .' '. $data->lname !!} 
                                                                @else
                                                                    {!! $data->username !!} 
                                                                @endif

                                                                <span class="online-status"><img src="{{asset('assets/booking/admin/img/online.png')}}"></span>
                                                                @if($msgCount)
                                                                <span class="label label-danger pull-right">{!! $msgCount !!}</span>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </li><!-- /.item -->
                                                <?php endforeach; ?>
                                            </ul>
                                        </div> <!-- /. box body -->
                                    </div> <!-- /.box -->
                                </div> <!-- /.col-sm-4 -->
                                <?php if ($user): ?>
                                    <div class="col-md-8">
                                        <!-- DIRECT CHAT -->
                                        <div class="box box-warning direct-chat direct-chat-primary">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">
                                                    @if($user->fname !=null && $user->lname !=null)
                                                        {!! $user->fname .' '. $user->lname !!} 
                                                    @else
                                                        {!! $user->username !!} 
                                                    @endif
                                                    <span class="online-status"><img src="{{asset('assets/booking/admin/img/online.png')}}"></span></h3>
                                            </div><!-- /.box-header -->
                                            <div class="box-body" id="msg-box">
                                                <!-- Conversations are loaded here -->
                                                <div class="direct-chat-messages" id="message-list">
                                                    <?php foreach ($chatMessages as $message): ?>
                                                        <?php
                                                        $time = date("Y-m-d", strtotime($message->created_at));
                                                        $now = date("Y-m-d");

                                                        if ($time == $now) {
                                                            $time = date("h:i A", strtotime($message->created_at));
                                                        } else {
                                                            $time = date("d-m-Y", strtotime($message->created_at));
                                                        }
                                                        if ($message->message_type == 'in-msg') {
                                                            
                                                            if ($user->fname !=null && $user->lname !=null) {
                                                                
                                                                $name = $user->fname . ' ' . $user->lname;

                                                            }else{

                                                                $name = $user->username;
                                                            }

                                                            $msgType = '';
                                                            $nameClass = 'pull-left';
                                                            $timeClass = 'pull-right';
                                                            $img = !empty($user->photo) ? asset('assets/front/img/user/'.$user->photo) : asset('assets/front/img/user/default.png');
                                                        } else {
                                                            $name = auth()->guard('admin')->user()->first_name . ' ' . auth()->guard('admin')->user()->last_name;
                                                            $msgType = 'right';
                                                            $nameClass = 'pull-right';
                                                            $timeClass = 'pull-left';
                                                            $img = asset('assets/front/img/'.$bs->logo);
                                                        }
                                                        ?>
                                                        <div class="direct-chat-msg {!! $msgType !!}">
                                                            <div class="direct-chat-info clearfix">
                                                                <span class="direct-chat-name {!! $nameClass !!}">{!! $name !!}</span>
                                                                <span class="direct-chat-timestamp {!! $timeClass !!}">{!! $time !!}</span>
                                                            </div>
                                                            <img class="direct-chat-img" src="{!! $img !!}" width="100" alt="Image" />
                                                            <div class="direct-chat-text">
                                                                {!! $message->message_content !!}
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div><!--/.direct-chat-messages-->
                                            </div><!-- /.box-body -->
                                            <div class="box-footer">
                                                <form onsubmit="return false" action="#" method="post">
                                                    <div class="input-group">
                                                        <input type="text" name="messages_content" id="messages_content" placeholder="{!! trans('admin/chat.type_message') !!}" class="form-control" />
                                                        <span class="input-group-btn">
                                                            <button type="submit" class="btn btn-warning btn-flat" id="sendMessage">{!! trans('admin/chat.send') !!}</button>
                                                        </span>
                                                    </div>
                                                </form>
                                            </div><!-- /.box-footer-->
                                        </div><!--/.direct-chat -->
                                    </div><!-- /.col -->
                                <?php else: ?>
                                    <div class="col-md-8">
                                        <!-- DIRECT CHAT -->
                                        <div class="box box-warning direct-chat direct-chat-primary">
                                            <div class="box-body direct-chat-messages">
                                                <h3 class="text-center">{!! trans('admin/chat.start_chat') !!}</h3>
                                            </div><!-- /.box-body -->
                                        </div><!--/.direct-chat -->
                                    </div><!-- /.col -->
                                <?php endif; ?>
                            </div><!-- /.row (main row) -->

                        </section><!-- /.content -->
                    </div><!-- /.content-wrapper -->
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@include('admin.booking_common._booking_common_js')

<script>
$(function () {
    $('#sendMessage').click(function () {
        var message = $('#messages_content').val();

        if (message == "") {
            return false;
        }
        $.ajax({
            type: "POST",
            url: "{{route('chatboard.store')}}",
            data: {
                id: '{!! request()->segment("3") !!}',
                message: message,
                _token: "{!! csrf_token() !!}"
            },
            success: function () {
                $('#messages_content').val('');
            }
        });
    });
});


$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
        cache: false    //use for i.e browser to clean cache
    });
    $(setInterval(function () {
        //refresh notification count for each user
        $('#online-list-notification').load(location.href + " #user-list-notification");
        $('#online-list-notification').prop({scrollTop: $('#online-list-notification').prop('scrollHeight')})

        $.ajax({
            type: "POST",
            url: "/laravel_new_template/admin/chatboard/notificationCount",
            data: {
               _token: "{!! csrf_token() !!}"
            },
            success: function (data) {
                if(data){
                    $('#total-count').show();
                    $('#total-count').html(data);
                }else{
                    $('#total-count').hide();
                }
            }
        });
        
        //refresh online user list
        $('#online-list').load(location.href + " #user-list");
        
        //refresh message box
        $('#msg-box').load(location.href + " #message-list", function () {
            $('#message-list').prop({scrollTop: $('#message-list').prop('scrollHeight')}) //if the messages overflowed this line tells the textarea to focus the latest message
        });
        
    }, 2000));
});

</script>

@endsection


