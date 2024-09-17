@extends('admin.layout')

@section('styles')

@include('admin.booking_common._booking_common_css')

@endsection

@section('content')

  <div class="page-header">
    <h4 class="page-title">{!! trans('admin/chat.chat_history') !!}</h4>
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
        <a href="#">Customer</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <!-- Notifications -->
                @include('admin.includes.notifications')
                <!-- ./ notifications -->
            </div>
            <?php if ($user): ?>
                <div class="col-md-12">
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
                        <div class="box-body" id="">
                            <!-- Conversations are loaded here -->
                            <div class="direct-chat-messages" id="">
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
                    </div><!--/.direct-chat -->
                </div><!-- /.col -->
            <?php endif; ?>
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
    </div>

@endsection

@section('scripts')

@include('admin.booking_common._booking_common_js')


@endsection


