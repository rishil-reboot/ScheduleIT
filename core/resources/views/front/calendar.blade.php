@extends("front.$version.layout")

@section('pagename')
 - {{__('Event Calendar')}}
@endsection

@section('meta-keywords', "$be->calendar_meta_keywords")
@section('meta-description', "$be->calendar_meta_description")

@section('styles')

<link href='{{asset("assets/front/css/calendar.css")}}' rel='stylesheet' />
<link href='{{asset("assets/front/calendar/css/master.css")}}?={{rand()}}' rel='stylesheet' />
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
                 <span>{{convertUtf8($be->event_calendar_title)}}</span>
                 <h1>{{convertUtf8($be->event_calendar_subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{convertUtf8($be->event_calendar_title)}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


    <!-- Calendar -->
    <section class="web-calendar">
        <div class="container-fluid">
            <div class="custom-row">
                <div class="custom-col-left">
                    <div class="calender-wrapp">
                        <div id="calendar"></div>
                        <div class="buttons">
                            <?php /*<span class="event-yellow" data-toggle="modal" data-target=".add-event">Add Event</span>
                            <span class="event-pink" data-toggle="modal" data-target=".edit-event">Edit Event</span> */ ?>
                            <span class="event-ferozi detail-model" style="display:none;" data-toggle="modal" data-target=".event-detail">Event Detail</span>
                        </div>
                    </div>
                </div>
                <div class="custom-col-right" id="right-side-wrapp">
                    <div class="calender-wrapp">
                        @if($bs->download_calendar == 1)
                        <div class="event-box event-blue">
                            <a href="{{route('front.downloadCalenderAllEvent')}}" style="color:white"> Download Calendar</a>
                        </div>
                        @endif
                        @include('front.common._get_calendar_right_section')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Calendar Ends -->

    
   <!-- Add Event Modal -->
    <div class="modal fade add-event" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span><i class="fa fa-plus" aria-hidden="true"></i></span> Add Event</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-10">
                                <div class="form-group">
                                    <label>Event Name <span>*</span></label>
                                    <input type="text" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-xs-2">
                                <div class="form-group">
                                    <label>Color</label>
                                    <input type="color" placeholder="" class="form-control color-select">
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label>Where <span>*</span></label>
                                    <input type="text" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description <span>*</span></label>
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Start On <span>*</span></label>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="06-01-2021" class="form-control">
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="03:30 PM" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Ends On <span>*</span></label>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="06-01-2021" class="form-control">
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="03:30 PM" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><input type="checkbox" value=""> All Employees</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Add Attendees <span>*</span></label>
                                    <input type="text" placeholder="Choose Member, Select Client" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><input type="checkbox" value=""> Repeat</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><input type="checkbox" value=""> Send Reminder</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Event Modal -->
    <div class="modal fade edit-event" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Event</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-10">
                                <div class="form-group">
                                    <label>Event Name <span>*</span></label>
                                    <input type="text" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-1 col-xs-2">
                                <div class="form-group">
                                    <label>Color</label>
                                    <input type="color" placeholder="" class="form-control color-select">
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <label>Where <span>*</span></label>
                                    <input type="text" placeholder="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description <span>*</span></label>
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Start On <span>*</span></label>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="06-01-2021" class="form-control">
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="03:30 PM" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Ends On <span>*</span></label>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="06-01-2021" class="form-control">
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-xs-12">
                                            <input type="text" placeholder="03:30 PM" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><input type="checkbox" value=""> All Employees</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Add Attendees <span>*</span></label>
                                    <input type="text" placeholder="Choose Member, Select Client" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><input type="checkbox" value=""> Repeat</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label><input type="checkbox" value=""> Send Reminder</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info"><i class="far fa-edit"></i> Edit</button>
                    <button type="button" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div class="modal fade event-detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Event Detail</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-xs-10">
                                <div class="event-detail-box">
                                    <h3>Event Name</h3>
                                    <p class="event_detail_html_class"></p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="event-detail-box">
                                    <h3>Description</h3>
                                    <p class="event_des_html_class"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-10">
                                <div class="event-detail-box">
                                    <h3>Start On</h3>
                                    <p class="event_start_html_class"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-5 col-xs-12">
                                <div class="event-detail-box">
                                    <h3>Ends On</h3>
                                    <p class="event_end_html_class"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script src="{{asset('assets/front/calendar/new_design')}}/jquery-3.2.1.min.js"></script>
<script src="{{asset('assets/front/calendar/new_design')}}/bootstrap.min.js"></script>

<!-- rrule lib -->
<script src="{{asset('assets/front/calendar/rrule')}}/rrule.min.js"></script>

<!-- fullcalendar bundle -->
<script src="{{asset('assets/front/calendar/new_design')}}/main.js"></script>

<!-- the rrule-to-fullcalendar connector. must go AFTER the rrule lib -->
<script src="{{asset('assets/front/calendar/rrule')}}/main.global.min.js"></script>



<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var eventsList ={!! json_encode($formattedEvents) !!};

    var calendar = new FullCalendar.Calendar(calendarEl, {
         
         headerToolbar: {
           center: 'prev,next',
           left: 'title',
           right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
         },
         initialDate: "{{date('Y-m-d')}}",
         navLinks: true,
         nowIndicator: true,

         weekNumbers: false,
         weekNumberCalculation: 'ISO',

         editable: true,
         selectable: true,
         dayMaxEvents: true,
         events: eventsList,
         eventClick: function(info) {
        
            $(".event_detail_html_class").html(info.event.title);
            $(".event_des_html_class").html(info.event.extendedProps.description);
            $(".event_start_html_class").html(info.event.start);
            $(".event_end_html_class").html(info.event.end);

            $(".detail-model").trigger("click");            
         }

    });

    calendar.render();
  });
</script>

@endsection
