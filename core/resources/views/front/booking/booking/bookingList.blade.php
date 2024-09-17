@extends('user.layout')

@section('pagename')
 - {{__('Dashboard')}}
@endsection

@section('styleSection')

{{-- Date Picker --}}
<link href="{!! asset('assets/booking/user/plugins/datepicker/css/bootstrap-datepicker3.min.css') !!}" rel="stylesheet" type="text/css" />


<style type="text/css">
        
    input[type="submit"], button[type="submit"]{

        padding: 8px 18px !important;
    }
    
    input[type="text"], input[type="email"], input[type="date"], input[type="number"], input[type="tel"], input[type="url"], input[type="color"], input[type="datetime-local"], input[type="range"], input[type="month"], input[type="week"], input[type="search"], input[type="time"]{

        height: 38px !important;
    }

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
                        <h1>My Booking</h1>
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
                <div class="widget user-profile-details">
                    
                    <div class="account-info">
                        
                        <div class="widget-header">
                            <div class="title">
                                {!! trans('user/booking.my_bookings_list') !!}
                                <a style="color:white;" href="{{ route('reservation.index') }}" class="btn btn-sm btn-lbs mrgn_5t pull-right btn-primary">{!! trans('user/booking.reservation') !!}</a>
                            </div>
                        </div>
                        <div class="bac" style="margin-bottom:20px">
                            
                            {!! Form::open(array('route' => 'front.booking.search', 'id' => 'booking-search-form', 'class' => 'form-inline','method' => 'POST')) !!}
                            
                            <div class="form-group">
                                {!! Form::label('search', trans('user/common.search')) !!}
                                <div style="margin-right: 10px;"></div>
                                {!! Form::select('search_by',array(''=>trans('user/common.search_by'), 'service' => trans('user/booking.service'), 'name' => trans('user/booking.booking_name'), 'email' => trans('user/booking.booking_email'),  'phone' => trans('user/booking.booking_mobile'), 'booking_date' => trans('user/booking.booking_date')), session('SEARCH.SEARCH_BY') , array('class'=>'form-control', 'id' => 'search_by')) !!}
                            </div>
                            <div style="margin-right: 10px;"></div>
                            <div class="form-group">
                                <?php if (session('SEARCH.SEARCH_BY') == 'service' || session('SEARCH.SEARCH_BY') == 'booking_date'): ?>
                                    {!! Form::text('search_txt', session('SEARCH.SEARCH_TXT') ,array('id' => 'search_txt', 'class' => 'form-control', 'style' => 'display:none;')) !!}
                                <?php else: ?>
                                    {!! Form::text('search_txt', session('SEARCH.SEARCH_TXT') ,array('id' => 'search_txt', 'class' => 'form-control','placeholder'=>trans('user/common.search'))) !!}
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group">
                                <?php if (session('SEARCH.SEARCH_BY') == 'service'): ?>
                                    {!! Form::select('service_id',$serviceList, session('SEARCH.SERVICE_ID') , array('class'=>'form-control', 'id' => 'service_id', 'style' => 'display:inline-block;')) !!}
                                <?php else: ?>
                                    {!! Form::select('service_id',$serviceList, session('SEARCH.SERVICE_ID') , array('class'=>'form-control', 'id' => 'service_id', 'style' => 'display:none;')) !!}
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <?php if(session('SEARCH.SEARCH_BY')=='booking_date'):?>
                                <div class="input-group search_date" style="display:inline-table;">
                                    {!! Form::text('search_date',session('SEARCH.SEARCH_DATE'),['id' => 'search_date','class' => 'datepicker form-control',]) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <?php else:?>
                                <div class="input-group search_date" style="display:none;">
                                    {!! Form::text('search_date',session('SEARCH.SEARCH_DATE'),['id' => 'search_date','class' => 'datepicker form-control',]) !!}
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <?php endif;?>
                            </div>
                             
                            
                            <div class="form-group" style="padding:15px">
                                {!! Form::submit(trans('user/common.search'), array('id' => 'search', 'name' => '', 'class' => 'btn btn-primary ')) !!}
                                <div style="margin-right: 10px;"></div>
                                {!! Form::button(trans('user/common.reset'),array('type'=>'submit','id' => 'reset', 'name' => 'reset', 'value' => '1', 'class' => 'btn btn-primary')) !!}

                                <div style="margin-right: 15px;"></div>    

                                <a style="color: white" href="{{route('front.booking.export')}}" class="btn btn-primary btn-sm btn-lbs mrgn_5t pull-right">{!! trans('user/booking.export_csv') !!}</a>

                            </div>

                            {!! Form::close() !!}
                            
                        </div>

                        <div class="widget-body"> 
                            <div class="table-responsive">  
                                <table class="table table-condensed no-margin table-custome">
                                    <thead>
                                        <tr class="table-head">
                                            <th>{!! trans('user/booking.service') !!}</th>
                                            <th>{!! trans('user/booking.booking_name') !!}</th>
                                            <th>{!! trans('user/booking.booking_email') !!}</th>
                                            <th>{!! trans('user/booking.booking_mobile') !!}</th>
                                            <th>{!! trans('user/booking.credits') !!}</th>
                                            <th>{!! trans('user/booking.booking_date') !!}</th>
                                            <th>{!! trans('user/common.status') !!}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($bookings))
                                        @foreach ($bookings as $key=>$data)
                                            <tr class="@if($key % 2 == 0) even @else odd @endif">
                                                <td>{!! $data->service->title !!}</td>
                                                <td>{!! $data->full_name !!}</td>
                                                <td>{!! $data->email !!}</td>
                                                <td>{!! $data->phone !!}</td>
                                                <td>{!! $data->amount !!}</td>
                                                <td>
                                                    <a href="javascript:void(0);" class="spnToggle" id="bookingDetail_<?php echo $data->id; ?>">{!! trans('user/common.view') !!}</a>
                                                    <span id="bookingDetail_<?php echo $data->id; ?>" style="display:none;" class="">
                                                        <table class="table table-bordered table-condensed">
                                                            <tbody>
                                                                <?php $spots = $data->bookingDetail?>
                                                                <?php foreach ($spots as $key => $spot):?>
                                                                    <tr>
                                                                        <td width='115'>{!! date('d-m-Y h:i A', strtotime($spot->start_time)) !!} to {!! date('d-m-Y h:i A', strtotime($spot->end_time)) !!}</td>
                                                                    </tr>
                                                                <?php endforeach;?>
                                                            </tbody>
                                                        </table>
                                                    </span>
                                                </td>
                                                <td width='100'>
                                                    @if($data->status == 'pending')
                                                    <button style="color:white;" class="btn btn-primary" title="{!! trans('user/booking.pending_booking') !!}" data-toggle="tooltip">{!! trans('user/booking.pending') !!}</button>
                                                    @elseif($data->status == 'cancel')
                                                    <button class="btn btn-danger" title="{!! trans('user/booking.cancelled_booking') !!}" data-toggle="tooltip">{!! trans('user/booking.cancel') !!}</button>
                                                    @elseif($data->status == 'confirm')
                                                    <button class="btn btn-success" title="{!! trans('user/booking.confirmed_booking') !!}" data-toggle="tooltip">{!! trans('user/booking.confirm') !!}</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                {!! trans('user/booking.no_bookings_found') !!}
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="clearfix"></div>
                                <div class="col-lg-9 offset-5 pagination" style="margin-top:10px">
                                    @if($bookings)
                                        {!! $bookings->render() !!} 
                                    @endif
                                </div>
                                <div style="padding:10px"></div>
                                <div class="col-lg-12 text-center">
                                    <a style="color:white" class="btn">{!! trans('user/common.total') !!} {!! $bookings->total() !!} </a>
                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
    
{{-- date-picker --}}


{{-- InputMask --}}

<script src="{!! asset('assets/booking/user/plugins/input-mask/jquery.inputmask.js') !!}" type="text/javascript"></script>

<script src="{!! asset('assets/booking/user/plugins/input-mask/jquery.inputmask.date.extensions.js') !!}" type="text/javascript"></script>

<script src="{!! asset('assets/booking/user/plugins/input-mask/jquery.inputmask.extensions.js') !!}" type="text/javascript"></script>

<script src="{!! asset('assets/booking/user/plugins/datepicker/js/bootstrap-datepicker.js') !!}" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({
            //placement: "bottom"
        });
        
        $(".spnToggle").click(function(){
           $('span#'+$(this).attr('id')).toggle();
        });
        
        $('#search_by').change(function () {
            if ($('#search_by').val() == 'service') {
                $("#service_id").show();
                $("#search_txt").hide();
                $(".search_date").hide();
            }else if ($('#search_by').val() == 'booking_date') {
                $("#service_id").hide();
                $("#search_txt").hide();
                $(".search_date").show();
            } else {
                $("#service_id").hide();
                $(".search_date").hide();
                $("#search_txt").show();
            }
        });
        
        $(window).on('load',function(){
            $('#search_by').trigger('change');
        });
        
        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            //startDate: "od",
            todayHighlight: true,
            todayBtn : true,
            autoclose: true
        }).inputmask('dd-mm-yyyy', {"placeholder": "dd-mm-yyyy", alias: "date", "clearIncomplete": true});
    });
</script>
@endsection
