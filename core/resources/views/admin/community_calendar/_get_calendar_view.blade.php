@extends('admin.layout')
@section('styles')
<link href='{{asset("assets/front/css/calendar.css")}}' rel='stylesheet' />
<style>
  .fc-unthemed .fc-content, .fc-unthemed .fc-divider, .fc-unthemed .fc-list-heading td, .fc-unthemed .fc-list-view, .fc-unthemed .fc-popover, .fc-unthemed .fc-row, .fc-unthemed tbody, .fc-unthemed td, .fc-unthemed th, .fc-unthemed thead {
      border-color: blanchedalmond;
      color: white;
  }
  .fc-unthemed td.fc-today {
    background: darkblue;
  }
</style>

<link href='{{asset("assets/front/calendar/css/admin_master.css")}}' rel='stylesheet' />

@endsection
@section('content')
  <div class="page-header">
    <h4 class="page-title">Calendar</h4>
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
        <a href="#">Calendar</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">View Calendar</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
       
          <div class="card-header">
            <div class="card-title d-inline-block">View Calendar</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.communityCalendar.index')}}">
              <span class="btn-label">
                <i class="fas fa-backward" style="font-size: 12px;"></i>
              </span>
              Back
            </a>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-12">

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
                                          <a href="{{route('front.downloadCalender',$calendar->slug)}}" style="color:white"> Download Calendar</a>
                                      </div>
                                      @endif
                                      @include('front.common._get_calendar_right_section')
                                  </div>
                              </div>
                          </div>
                      </div>
                  </section>

              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

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


<script src="{{asset('assets/front/calendar/new_design')}}/main.js"></script>

<!-- rrule lib -->

<script src="{{asset('assets/front/calendar/rrule')}}/rrule.min.js"></script>

<!-- fullcalendar bundle -->

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
