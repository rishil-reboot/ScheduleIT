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

    <!-- Row Start -->
    <div class="row">
        <div class="col-lg-9 col-md-9">
            <div id="loading-overlay">
                <div class="loading-icon"></div>
            </div>
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        {!! trans('user/reservation.calendar') !!}
                    </div>
                    <span class="tools">
                        <i class="fa fa-cogs"></i>
                    </span>
                </div>
                <div class="widget-body">
                    @include('admin.includes.notifications')
                    <div id='calendar'></div>
                </div>
            </div>{{-- widget-body End --}}
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">{!! trans('user/reservation.available_services') !!}</div>
                    <span class="tools"><i class="fa fa-bars"></i></span>
                </div>
                <div class="widget-body">
                    <ul class="list-group">
                        @if(!$services->isEmpty())
                            @foreach($services as $key => $service)
                            <li class="list-group-item">{!! $service->title !!}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>{{-- widget-body End --}}
        </div>{{-- col-lg-4 col-md-4 End --}}
    </div>{{-- Row End --}}
</div>{{-- Dashboard Wrapper End --}}
    
@endsection

@section('scripts')

<script src="{!! asset('assets/booking/user/js/fullcalendar/moment.min.js') !!}"></script>
<script src="{!! asset('assets/booking/user/js/fullcalendar/fullcalendar.min.js') !!}"></script>
<script src="{!! asset('assets/booking/user/js/fullcalendar/locale-all.js') !!}"></script>

<script>
    $(document).ready(function () {
        var mydate = new Date();
        var d = mydate.getDate();
        var m = mydate.getMonth() + 1;
        var y = mydate.getFullYear();
        var currDate = y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);

        var calendar = $('#calendar').fullCalendar({
            locale: "{!! config('app.locale') !!}",
            header: {
                left: 'prev,next today',
                center: 'title',
                //right: 'month,agendaWeek,agendaDay'
                right: ''
            },
            select: function (start, end) {
                if (start.isBefore(moment())) {
                    $('#calendar').fullCalendar('unselect');
                    return false;
                }
            },
            defaultView: 'month',
            dayRender: function (moment, cell) {
                var tomorrow = moment.add(2, 'day');
                var day = moment.add(-1, 'day').date();
                var today = new Date();
                if (tomorrow < today) {
                    cell.css("background-color", "#e6e6e6");
                }
            },
            eventLimit: true, // allow "more" link when too many events
            events: function (start, end, timezone, callback) {
                $.ajax({
                    url: '{{route("front.reservation.getServices")}}',
                    dataType: 'json',
                    cache: false,
                    data: {
                        // our hypothetical feed requires UNIX timestamps
                        //start: start.unix(),
                        //end: end.unix()
                    },
                    success: function (events) {
                        callback(events);
                    }
                });
            },
            loading: function (bool) {
                $("#loading-overlay").toggle(bool);
            }
        });
    });
</script>

@endsection
