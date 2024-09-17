@extends('admin.layout')

@section('styles')

@include('admin.booking_common._booking_common_css')

<link href="{!! asset('assets/booking/admin/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/select2.min.css')}}">
@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Service</h4>
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
        @if(isset($service))
            <a href="#">Edit Service</a>
        @else
            <a href="#">Add Service</a>
        @endif
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        @if(isset($service))
            {!! Form::model($service, array('route' => array('booking-services.update', $service->id), 'method' => 'PATCH', 'id' => 'service-form', 'files' => true )) !!}
        @else
            {!! Form::open(array('route' => 'booking-services.store', 'id' => 'service-form', 'files' => true)) !!}
        @endif
          <div class="card-header">
            <div class="card-title d-inline-block">
                @if(isset($service))
                    Edit Service
                @else
                    Add Service
                @endif
            </div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('booking-services.index')}}">
				<span class="btn-label">
					<i class="fas fa-backward" style="font-size: 12px;"></i>
				</span>
				Back
			</a>
          </div>
          <div class="card-body pt-5 pb-5">
              <div class="row">
                 @csrf 
             
                    <div class="col-lg-12">
                    
                        <div class="form-group has-feedback">
                            {!! Form::label('title', trans('admin/service.title')) !!}
                            {!! Form::text('title', old('title'),array('class'=>'form-control')) !!}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                    </div>
                    <?php 

                        $adminUserList = (new \App\Admin)->getEmailDropdown();

                        $assignedUser = [];

                        if (isset($service) && !$service->bookingServiceUser->isEmpty()) {

                            $assignedUser = $service->bookingServiceUser->pluck('admin_id')->toArray();    
                        }

                    ?>
                    <div class="col-lg-12">
                        <div class="form-group has-feedback">
                            {!! Form::label('title', 'Assign User') !!}
                            {!! Form::select('service_user[]',$adminUserList,$assignedUser,array('class'=>'form-control','id'=>'assign_user','multiple'=>true)) !!}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>

                  <div class="col-lg-12">
                      
                      <div class="form-group has-feedback">
                          {!! Form::label('description', trans('admin/service.description')) !!}
                          {!! Form::textarea('description', old('description'),array('class'=>'form-control')) !!}
                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                      </div>

                  </div>

                  <div class="col-lg-12">

                    <div class="form-group has-feedback">
                        {!! Form::label('price', trans('admin/service.price')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.price_info') !!}"></i>
                        <div class="input-group">
                            <span class="input-group-addon">Cr</span>
                            {!! Form::text('price', old('price'),array('class'=>'form-control numberInput')) !!}
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    
                  </div>


                  <div class="col-lg-12">

                    <div class="form-group">
                        {!! Form::label('duration', trans('admin/service.duration')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.duration_info') !!}"></i>
                        <?php $durationArray = array(''=>trans('admin/service.select'),30=>'30 '.trans('admin/service.minutes'),60=>'1 '.trans('admin/service.hour'),90=>'1.5 '.trans('admin/service.hours'),120=>'2 '.trans('admin/service.hours'))?>
                        {!! Form::select('duration', $durationArray, old('duration') ,array('class'=>'form-control')) !!}
                    </div>
                    
                  </div>


                  <div class="col-lg-12">

                      <div class="form-group">
                          {!! Form::label('max_spot_limit', trans('admin/service.max_spot_limit')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.max_spot_limit_info') !!}"></i>
                          <?php $limitArray = array(1=>1, 2=>2, 3=>3, 4=>4)?>
                          {!! Form::select('max_spot_limit', $limitArray, old('max_spot_limit') ,array('class'=>'form-control')) !!}
                      </div>
                    
                  </div>

                  <div class="col-lg-12">

                    <div class="form-group">
                        {!! Form::label('close_booking_before_time', trans('admin/service.close_booking_before_time')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.close_booking_before_time_info') !!}"></i>
                        <?php $timeArray = array(''=>trans('admin/service.select'),30=>'30 '.trans('admin/service.minutes'),60=>'1 '.trans('admin/service.hour'),90=>'1.5 '.trans('admin/service.hours'),120=>'2 '.trans('admin/service.hours'),180=>'3 '.trans('admin/service.hours'),240=>'4 '.trans('admin/service.hours'))?>
                        {!! Form::select('close_booking_before_time', $timeArray, old('close_booking_before_time') ,array('class'=>'form-control')) !!}
                    </div>
                    
                  </div>
                    
                  <div class="col-lg-12">
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                {!! Form::label('service_type', trans('admin/service.service_type')) !!}
                            </div>
                            <div class="col-sm-12">
                                <label class="radio-inline">
                                    {!! Form::radio('service_type', 'daily', true, array('class'=>'service_type')) !!} {!! trans('admin/service.daily') !!}
                                </label>
                                <label class="radio-inline">
                                  {!! Form::radio('service_type', 'weekly', false, array('class'=>'service_type')) !!} {!! trans('admin/service.weekly') !!}
                                </label>
                                <label class="radio-inline">
                                  {!! Form::radio('service_type', 'monthly', false, array('class'=>'service_type')) !!} {!! trans('admin/service.monthly') !!}
                                </label>
                                <label class="radio-inline">
                                  {!! Form::radio('service_type', 'yearly', false, array('class'=>'service_type')) !!} {!! trans('admin/service.yearly') !!}
                                </label>
                            </div>
                        </div>
                    </div>

                  </div>

                <?php 
                if(isset($service)){
                    $start_date = $service->start_date != "" ? date('d-m-Y', strtotime($service->start_date)) : "";
                    $end_date = $service->end_date !="" ? date('d-m-Y', strtotime($service->end_date)) : "";
                    
                    if ($service->service_type == 'weekly') {
                        $timeDisplay = 'none';
                        $weekDisplay = 'block';
                    }else{
                        $timeDisplay = 'block';
                        $weekDisplay = 'none';
                    }
                }else{
                    
                    $start_date = old('start_date') ? old('start_date') : '';
                    $end_date = old('end_date') ? old('old_date') : '';
                    
                    if (old('service_type') == 'weekly') {
                        $timeDisplay = 'none';
                        $weekDisplay = 'block';
                    }else{
                        $timeDisplay = 'block';
                        $weekDisplay = 'none';
                    }
                }

                ?>
                <div class="col-lg-12">
                    <div class="daily">
                        <div class="row daily-date">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('start_date', trans('admin/service.start_date')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.start_date_info') !!}"></i>
                                    <div class="input-group">
                                        {!! Form::text('start_date', $start_date,array('id'=>'start_date','class'=>'form-control datepicker')) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('end_date', trans('admin/service.end_date')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.end_date_info') !!}"></i>
                                    <div class="input-group">
                                        {!! Form::text('end_date', $end_date,array('id'=>'end_date','class'=>'form-control datepicker')) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row daily-time" style="display: <?php echo $timeDisplay;?>">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('start_time', trans('admin/service.start_time')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.start_time_info') !!}"></i>
                                    <div class="input-group">
                                        {!! Form::text('start_time', old('start_time'),array('id'=>'start_time','class'=>'form-control')) !!}
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('end_time', trans('admin/service.end_time')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.end_time_info') !!}"></i>
                                    <div class="input-group">
                                        {!! Form::text('end_time', old('end_time'),array('id'=>'end_time','class'=>'form-control')) !!}
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> {{-- daily --}}
                </div>

                <div class="col-lg-12">
                    
                <div class="weekly" style="display: <?php echo $weekDisplay; ?>">
                    <?php $dayName = array(0 =>trans('admin/service.sunday'),1=>trans('admin/service.monday'),2=>trans('admin/service.tuesday'),3=>trans('admin/service.wednesday'),4=>trans('admin/service.thursday'),5=>trans('admin/service.friday'),6=>trans('admin/service.saturday')) ?>
                    <?php 
                    if(isset($service) && $service->service_type=='weekly'){
                        $scheduleArray = array();
                        for($i=0;$i<7;$i++){
                             if(isset($service->schedule[$i])){
                                 $scheduleArray[$service->schedule[$i]->week_number] = $service->schedule[$i];
                             }
                        }
                    }
                    ?>
                    <?php for($i=0;$i<7;$i++):?>
                    <?php 
                    if(isset($service) && $service->service_type=='weekly'){
                        $start_time = isset($scheduleArray[$i]) ? date('h:i A',  strtotime($scheduleArray[$i]->start_time)) : '';
                        $end_time = isset($scheduleArray[$i]) ? date('h:i A',  strtotime($scheduleArray[$i]->end_time)) : '';
                    }else{
                        $start_time = '';
                        $end_time = '';
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-2">
                            {!! Form::label('', $dayName[$i], array('style'=>'margin-top:25px')) !!}
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                {!! Form::label('start_time', trans('admin/service.start_time')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.start_time_info') !!}"></i>
                                <div class="input-group">
                                    {!! Form::text('start_time_'.$i, old('start_time_'.$i)!='' ? old('start_time_'.$i) : $start_time ,array('id'=>'start_time_'.$i,'class'=>'form-control')) !!} 
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                {!! Form::label('end_time', trans('admin/service.end_time')) !!} <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="{!! trans('admin/service.end_time_info') !!}"></i>
                                <div class="input-group">
                                    {!! Form::text('end_time_'.$i, old('end_time_'.$i)!='' ? old('end_time_'.$i) : $end_time ,array('id'=>'end_time_'.$i,'class'=>'form-control')) !!}
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endfor;?>
                </div> {{-- weekly --}}
                
                </div>

          </div>
        
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  {!! Form::submit(trans('admin/common.submit'),array('class'=>'btn btn-primary', 'id'=>'submitform')) !!}
                  <a href="{!! URL::route('booking-services.index') !!}" class="btn btn-default">{!! trans('admin/common.cancel') !!}</a>
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>

@endsection

@section('scripts')

@include('admin.booking_common._booking_common_js')

<script type="text/javascript" src="{{asset('assets/front/js/select2.min.js')}}"></script>
<script type="text/javascript">
    CKEDITOR.replace('description', {
        toolbar: 'BlogToolbar',
    });
    $(document).ready(function(){
        $(".service_type").change(function(){
            var service_type = $(this).val();
            if(service_type=='weekly'){
                $('.daily-time').slideUp();
                $('.weekly').slideDown();
                
                $("#start_time").rules("remove", "required");
                $("#end_time").rules("remove", "required");
                
            }else{
                $('.daily-time').slideDown();
                $('.weekly').slideUp();
                
                $("#start_time").rules("add", "required");
                $("#end_time").rules("add", "required");
                
                /*if(service_type=='monthly' || service_type=='yearly'){
                    $('.daily-date').slideDown();
                    
                    $("#start_date").rules("add", "required");
                    $("#end_date").rules("add", "required");
                    
                }else{
                    $('.daily-date').slideUp();
                    
                    $("#start_date").rules("remove", "required");
                    $("#end_date").rules("remove", "required");
                }*/
            }
        });
        
        var service_type = $(".service_type:checked").val();
        if(service_type=='weekly'){
            $("#start_time").rules("remove", "required");
            $("#end_time").rules("remove", "required");

        }
        
        $(".numberInput").forceNumeric(); // for number input force enter numeric
        
        $(".datepicker").inputmask('dd-mm-yyyy', {"placeholder": "dd-mm-yyyy", alias: "date", "clearIncomplete": true});
        
        $("#start_date").datepicker({
            format: "dd-mm-yyyy",
            //startDate: "od",
            todayHighlight: true,
            todayBtn : true,
            autoclose: true
        }).on('changeDate', function(e) {
            var minDate = new Date(e.date.valueOf());
            $('#end_date').datepicker('setStartDate', minDate);
        });
        
        
        $('#end_date').datepicker({
            format: "dd-mm-yyyy",
            startDate: "od",
            todayHighlight: true,
            todayBtn : true,
            autoclose: true
        }).on('changeDate', function(e) {
            var maxDate = new Date(e.date.valueOf());
            $('#start_date').datepicker('setEndDate', maxDate);
        });
        
        //var minDate = moment().add(-1, 'seconds').toDate();
        $('input[id^=start_time]').datetimepicker({
            format: 'LT',
        }).inputmask('hh:mm t', {"placeholder": "hh:mm t", alias: "date", "clearIncomplete": true});
        $('input[id^=end_time]').datetimepicker({
            format: 'LT',
            useCurrent: false //Important! See issue #1075
        }).inputmask('hh:mm t', {"placeholder": "hh:mm t", alias: "date", "clearIncomplete": true});
        
        $("input[id^=start_time]").on("dp.change", function (e) {
            $(this).closest('.row').find('input[id^=end_time]').data("DateTimePicker").minDate(e.date.add(30, 'minutes').toDate());
        });
        $("input[id^=end_time]").on("dp.change", function (e) {
            $(this).closest('.row').find('input[id^=start_time]').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>    

<script>
      
  $("#assign_user").select2({

    placeholder:"Select users"

  });  

</script>

@endsection
