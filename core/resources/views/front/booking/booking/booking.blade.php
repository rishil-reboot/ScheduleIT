@extends("front.$version.layout")

@section('pagename')
 - Reservation
@endsection

@section('styles')

{{-- fullcalendar --}}
<link href="{!! asset('assets/booking/user/css/fullcalendar/fullcalendar.min.css') !!}" rel="stylesheet">

<link href="{{asset('assets/booking/user/css/new.css')}}?={{rand()}}" rel="stylesheet" type="text/css" />

<style>
    .fc-day:hover{background:lightblue;cursor: pointer;}
    .fc-day-grid-event{padding: 5px;font-size: 15px;}
    .fc-day-grid-event{border-radius: 0px;padding: 5px;font-size: 15px;}
    .fc-day-grid-event:hover{border-radius: 10px}
    
    @media only screen and (max-width:480px){
        .fc-day-grid-event{padding: 0px;font-size: 10px;}
    }
    @media only screen and (min-width:480px) and (max-width:767px){
        .fc-day-grid-event{padding: 0px;font-size: 11px;}
    }
</style>

<style type="text/css">
    .dashboard-wrapper{
        background: white !important;
    }
    .widget{
        border: 1px solid #dbdbdb;
    }
    .fc-center h2{
        color: black !important;
    }
    .fc-day-header span{
        color: black !important;
    }
    .fc-day-number{color: black;}
    .fc-more{color: black !important;}
    .help-block{color: red;}
</style>

@endsection

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
                 <h1>Reservation</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>Reservation</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->

  <!-- Dashboard Wrapper Start -->
  <div class="dashboard-wrapper">
    {{-- Row Start --}}
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php
                        $service_id = request()->segment('3');
                        $service = \App\BookingService::find($service_id);
                            
                        $timestamp = request()->segment('4');
                        //$date = date('l jS \of F Y', $timestamp);
                        $date = date('m/d/Y',$timestamp);
                        $day = strtolower(date('l',$timestamp));
                        ?>
                        {!! trans('user/booking.book_spot') !!}: {!! $date !!} ({!! trans('user/booking.'.$day) !!})
                    </div>
                    <a href="{!! route('reservation.index') !!}" class="btn btn-sm btn-lbs mrgn_5t pull-right">{!! trans('user/common.back') !!}</a>
                </div>
                <div class="clearfix"></div> 
                <div class="widget-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            @include('admin.includes.notifications')
                            {!! Form::open(array('route' => 'front.booking.store', 'name'=>'booking-form', 'id' =>'booking-form', 'class' => 'form-horizontal no-margin', 'files'=>'true')) !!}
                            {!! Form::hidden('service_id',$service_id) !!}
                            {!! Form::hidden('reservation_date',$timestamp) !!}
                            <?php
                            //$scheduleArray = App\Http\Controllers\Frontend\ReservationController::getScheduleService($service_id, $timestamp);
                            $availabilityArr = $scheduleArray['availability'];
                            $bookedArr = $scheduleArray['booked'];
                            $totalSpots = $scheduleArray['total_spots'];
                            $int = $scheduleArray['duration'];
                            ?>
                            <div class="form-group">
                                {!! Form::label('role',trans('user/booking.spots'), array('class' => 'col-sm-2 control-label required-sign')) !!}
                                <div class="row checkbox">
                                    <?php foreach ($availabilityArr as $k => $v): ?>
                                        <?php echo '<label class="col-lg-5 offset-1">'; ?>
                                        <?php
                                        $chk = $disabled = in_array($v, $bookedArr) ? true : false;
                                        $chkName = in_array($v, $bookedArr) ? 'booked[]' : 'spots[]';
                                        $chkClass = in_array($v, $bookedArr) ? 'booked' : '';
                                        ?>
                                        {!! Form::checkbox($chkName, $v.'-'.date("H:i",strtotime($v . " +" . $int . " minutes")),$chk, array('id'=>'spots_'.$k,'class' => 'chbox '.$chkClass, 'disabled'=>$disabled)) !!} 
                                        {!! date("h:i A",strtotime($v)).' - '. date("h:i A",strtotime($v . " +" . $int . " minutes")) !!} 
                                        {!! $chk ? ' - Already Booked' : ''!!}
                                        <?php echo '</label>'; ?>
                                    <?php endforeach; ?>
                                </div>
                                <div class="col-sm-offset-2 col-sm-10 error-msg"></div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('full_name',trans('user/booking.full_name'), array('class' => 'col-sm-2 control-label required-sign')) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('full_name',old('full_name'),array('id' => 'full_name', 'class'=>'form-control')) !!}   
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('email', trans('user/booking.email'), array('class' => 'col-sm-2 control-label required-sign')) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('email',old('email'),array('id'=>'email','class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('mobile', trans('user/booking.mobile_number'), array('class' => 'col-sm-3 control-label required-sign')) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('phone',old('phone'),array('id'=>'mobile','class' => 'form-control numberInput')) !!}
                                    <span class="msgNumber"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('address', trans('user/booking.address'), array('class' => 'col-sm-2 control-label required-sign')) !!}
                                <div class="col-sm-10">
                                    {!! Form::textarea('address',old('address'),['id'=>'address','class'=>'form-control', 'rows' => 5, 'style' => "height:auto !important"]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    {!! Form::submit(trans('user/booking.book_now'), array('name'=>'save','id'=>'save','class' =>'btn btn-lbs btn-lg')) !!}
                                </div>
                            </div>
                            {!! Form::close()!!}
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <div class="widget">
                                <div class="widget-header">
                                    <div class="title">{!! trans('user/booking.service_details') !!}</div>
                                    <span class="tools"><i class="fa fa-bars"></i></span>
                                </div>
                                <div class="widget-body">
                                    <ul class="list-group">
                                        @if(isset($bs) && $bs->booking_payment == 1)
                                            <li class="list-group-item">{!! trans('user/booking.price_details') !!} <strong>{!! $service->price !!}/Cr</strong></li>
                                        @endif

                                        <li class="list-group-item">{!! trans('user/booking.maximum_spot_details') !!} <strong>{!! $service->max_spot_limit !!} spot</strong></li>
                                    </ul>
                                    {!! $service->description !!}
                                </div>
                            </div>
                            
                            @if(isset($bs) && $bs->booking_payment == 1)
                                <div class="widget">
                                    <div class="widget-header">
                                        <div class="title">{!! trans('user/booking.cart_total') !!}</div>
                                        <span class="tools">Cr</span>
                                    </div>
                                    <div class="widget-body">
                                        <h3 class="text-center text-success">
                                            <span id="amount">0</span>
                                            <span>Cr</span>
                                        </h3>
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div> {{-- widget-body End --}}
            </div>
        </div>
    </div>
    {{-- Row End --}}
</div>      

@endsection

@section('scripts')

<script src="{!! asset('assets/booking/user/js/validation/jquery.validate.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('assets/booking/user/js/validation/additional-methods.js') !!}" type="text/javascript"></script>

{{-- common for validation --}}
<script src="{!! asset('assets/booking/user/js/common.js') !!}" type="text/javascript"></script>

{{-- custom --}}
<script src="{!! asset('assets/booking/user/js/custom.js') !!}" type="text/javascript"></script>

{{-- numeric --}}
<script src="{!! asset('assets/booking/user/js/numeric.js') !!}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".numberInput").forceNumeric(); // for number input force enter numeric
        var $chkArray = [];
        $("input[type='checkbox'][name='spots[]']").click(function () {
            var $this = $(this);

            var $totalSpots = $("input[type='checkbox'][name='spots[]']:checked").not(":disabled").length;
            var $amount = '{!! $service->price !!}';
            var $totalAmount = $amount * $totalSpots;
            $("#amount").text($totalAmount);

            if ($(this).is(':checked')) {
                $chkArray.push($(this).attr('id'));
            } else {
                $chkArray = $chkArray.filter(function (i) {
                    return i != $this.attr('id')
                });
            }
            var $max_spot = '{!! $service->max_spot_limit !!}';
            if ($totalSpots >= $max_spot) {
                $("input[type='checkbox'][name='spots[]']").attr('disabled', 'disabled');
                for (var i = 0; i < $chkArray.length; i++) {
                    $("#" + $chkArray[i]).attr('disabled', false);
                }
            } else {
                $("input[type='checkbox'][name='spots[]']:not('.booked')").attr('disabled', false);
            }
        });
    });
</script>
@endsection
