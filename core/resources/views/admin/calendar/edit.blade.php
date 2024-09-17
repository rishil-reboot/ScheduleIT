@extends('admin.layout')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/daterangepicker.css')}}" />
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
        <a href="#">Edit Event</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
       <form action="{{route('admin.calendar.update')}}" method="post">
          <div class="card-header">
            <div class="card-title d-inline-block">Edit Event</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.calendar.index')}}">
							<span class="btn-label">
								<i class="fas fa-backward" style="font-size: 12px;"></i>
							</span>
							Back
						</a>
          </div>
          <div class="card-body pt-5 pb-5">
              <div class="row">
                  @csrf 
                  <input type="hidden" name="event_id" value="{{$event->id}}">
                  <div class="col-lg-6 offset-lg-3">

                      <div class="form-group">
                        <label for="">Title **</label>
                        <input name="title" class="form-control" placeholder="Enter Title" type="text" value="{{$event->title}}">
                        @if($errors->has('title'))
                          <p class="mb-0 text-danger">{{$errors->first('title')}}</p>
                        @endif
                      </div>

                  </div>

                   <div class="col-lg-6 offset-lg-3">
                      <div class="form-group">
                        <label class="control-label">
                          Recurring 
                        </label>
                        <label class="control-label offset-lg-1">
                          <input type="radio" name="is_recurring" class="is_recurring" value="1" @if($event->is_recurring == 1) checked @endif>
                          None
                        </label>
                        <label class="control-label offset-lg-1">
                          <input type="radio" name="is_recurring" class="is_recurring" value="2" @if($event->is_recurring == 2) checked @endif>
                          Custom
                        </label>
                      </div>
                  </div>

                  <div class="col-lg-6 offset-lg-3 show_hide_event_perio" style="display:none">
  
                      <div class="form-group">
                        <label for="">Event Period **</label>
                        <input type="text" name="datetimes" value="{{$event->start_date}}-{{$event->end_date}}" class="form-control ltr" placeholder="Enter Event Period" autocomplete="off"/>
                        <input type="hidden" id="start_date" name="start_date" value="{{$event->start_date}}">
                        <input type="hidden" id="end_date" name="end_date" value="{{$event->end_date}}">
                        <p id="errstart_date" class="mb-0 text-danger em"></p>
                        <p id="errend_date" class="mb-0 text-danger em"></p>
                        @if($errors->has('start_date') || $errors->has('end_date'))
                          <p class="mb-0 text-danger">This field is required.</p>
                        @endif
                      </div>
                  </div>

                  <div class="col-lg-6 offset-lg-3 show_hide_recurring_class" style="display:none;">
                    
                      <div class="form-group">
                        <label for="">Repeat</label>
                        <select class="form-control" name="recurring_type" id="recurringType">
                            @foreach(repeatIntervalType() as $key=>$v)
                              <option value="{{$key}}" @if($event->recurring_type == $key) selected @endif>{{$v}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('start_date') || $errors->has('end_date'))
                          <p class="mb-0 text-danger">This field is required.</p>
                        @endif
                      </div>
                  </div>
              </div>
                
              <div class="row show_hide_recurring_class" id="dynamicRecurringeventData" style="display:none;">

              </div>
              
              <div class="col-lg-6 offset-lg-3 show_hide_recurring_class" style="display: none;">
                <hr>
                <div class="form-group">
                  <label class="control-label">
                    End 
                  </label>
                  <label class="control-label offset-lg-1">
                    <input type="radio" name="recurring_end_action" class="recurring_end_action" value="never" @if($event->recurring_end_action == 'never') checked @endif>
                    Never 
                  </label>
                  <label class="control-label offset-lg-1">
                    <input type="radio" name="recurring_end_action" class="recurring_end_action" value="after" @if($event->recurring_end_action == 'after') checked @endif>
                    After
                  </label>
                  <label class="control-label offset-lg-1">
                    <input type="radio" name="recurring_end_action" class="recurring_end_action" value="date" @if($event->recurring_end_action == 'date') checked @endif>
                    On date 
                  </label>
                </div>
              </div>

              <div class="row endactionClassData">
                  
              </div>


              <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="form-group">
                      <label for="">Description</label> 
                      <textarea class="form-control summernote" name="event_note" data-editor="event_note" rows="3" placeholder="Enter Note" data-height="100">{!!$event->event_note!!}</textarea>
                      @if($errors->has('event_note'))
                        <p class="mb-0 text-danger">{{$errors->first('event_note')}}</p>
                      @endif
                    </div>
                </div>

                <div class="col-lg-6 offset-lg-3">
                    <div class="form-group">
                      <label for="">Note</label> 
                      <textarea class="form-control" name="notes" rows="3" placeholder="Enter Notes" data-height="100">{!! $event->notes !!}</textarea>
                      @if($errors->has('notes'))
                        <p class="mb-0 text-danger">{{$errors->first('notes')}}</p>
                      @endif
                    </div>
                </div>

                <div class="col-lg-6 offset-lg-3">
                    <div class="form-group">
                        <label class="control-label">
                          Featured 
                        </label>
                        <label class="control-label" style="margin-left:10px">
                          <input type="checkbox" name="is_featured" value="1" class="is_featured" @if($event->is_featured == 1) checked @endif>
                        </label>
                    </div>
                </div>

              </div>

          </div>
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- Include the media selection modal -->
@include('admin.partials.media-selection-modal', ['mediaData' => $mediaData])
@endsection


@section('scripts')

<script type="text/javascript" src="{{asset('assets/front/js/select2.min.js')}}"></script>

<script type="text/javascript" src="{{asset('assets/admin/js/plugin/daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/js/plugin/daterangepicker/daterangepicker.js')}}"></script>

<script>
        
  $(document).ready(function(){

      $("#event_id").select2({

        placeholder:"Select Calendar Event"

      });  

  });

  $(function() {

      $('input[name="datetimes"]').daterangepicker({
          autoUpdateInput: false,
          timePicker: true,
          locale: 
          {
              cancelLabel: 'Clear'
          }
      });

      $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('MM/DD/YYYY hh:mm A') + ' - ' + picker.endDate.format('MM/DD/YYYY hh:mm A'));
          $("#start_date").val(picker.startDate.format('MM/DD/YYYY hh:mm A'));
          $("#end_date").val(picker.endDate.format('MM/DD/YYYY hh:mm A'));
      });

      $('input[name="datetimes"]').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
          $("#start_date").val('');
          $("#end_date").val('');
      });

  });

  $(document).on("change","#recurringType",function(){

      repeatChangeTypeAction();

  });

  function repeatChangeTypeAction(page)
  {   
      var repeatType = $("#recurringType").val();
      var eventId = "{{$event->id}}";
      $.ajax({
       type:"post",
       url:"{{route('admin.calendar.changeRepeatIntervalType')}}",
       data:{"_token": "{{ csrf_token() }}",repeatType:repeatType,eventId:eventId},
       success:function(data)
       {
          $('#dynamicRecurringeventData').html(data);

          if (repeatType == 'weekly') {

            weeklyDayChange();
          }

       }
      });
  }

    repeatChangeTypeAction();

  $(document).on("change",".recurring_end_action",function(){

      endActionChange();

  });

  function endActionChange()
    {   
      var endAction = $(".recurring_end_action:checked").val();
      var eventId = "{{$event->id}}";
      $.ajax({
       type:"post",
       url:"{{route('admin.calendar.changeEndActionType')}}",
       data:{"_token": "{{ csrf_token() }}",endAction:endAction,eventId:eventId},
       success:function(data)
       {
        $('.endactionClassData').html(data);
       }
      });
    }

    endActionChange();

    $(document).on('change','.weekly_days',function(){

        weeklyDayChange();

    });

    function weeklyDayChange(){

      var length = $(".weekly_days:checked").length;

      if (length == 0) {

          $(".weekly_days:first").prop("checked",true);
      }
                
    }


    $(document).on('change','.is_recurring',function(){

        recurringShowHide();

    });

    function recurringShowHide(){

      var recurringValue = $(".is_recurring:checked").val();

      if (recurringValue == 1) {

          $(".show_hide_recurring_class").hide();          
          $(".show_hide_event_perio").show();

      }else{

          $(".show_hide_recurring_class").show();   
          $(".show_hide_event_perio").hide();       
      }

    }

    recurringShowHide();
</script>
@endsection
