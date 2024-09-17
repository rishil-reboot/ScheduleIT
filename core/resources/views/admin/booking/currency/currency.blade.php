@extends('admin.layout')

@section('styles')

@include('admin.booking_common._booking_common_css')

@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">
        @if(isset($currency))
            Edit Currency
        @else
            Add Currency
        @endif
    </h4>
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
        <a href="#">Basic Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Currency</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        @if(isset($currency))
            <a href="#">Edit Currency</a>
        @else
            <a href="#">Add Currency</a>
        @endif
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        @if(isset($currency))
            
            {!! Form::model($currency, array('route' => array('currency.update', $currency->id), 'method' => 'PATCH', 'id' => 'currency-form', 'files' => true )) !!}

        @else
           {!! Form::open(array('route' => 'currency.store', 'id' => 'currency-form', 'files' => true)) !!}
        @endif
          <div class="card-header">
            <div class="card-title d-inline-block">
                @if(isset($currency))
                    Edit Currency
                @else
                    Add Currency
                @endif
            </div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('currency.index')}}">
				<span class="btn-label">
					<i class="fas fa-backward" style="font-size: 12px;"></i>
				</span>
				Back
			</a>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
                @csrf 
         
                <div class="col-lg-6 offset-3">
                    <div class="form-group has-feedback">
                        {!! Form::label('name', trans('admin/currency.currency_name')) !!}
                        {!! Form::text('name', old('name'),array('class'=>'form-control numberInput')) !!}
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>

                <div class="col-lg-6 offset-3">
                    <div class="form-group has-feedback">
                        {!! Form::label('code', trans('admin/currency.currency_code')) !!}
                        {!! Form::text('code', old('price'),array('class'=>'form-control')) !!}
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                    
            </div>
        
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                    {!! Form::submit(trans('admin/common.submit'),array('class'=>'btn btn-primary', 'id'=>'submitform')) !!}
                    <a href="{!! URL::route('currency.index') !!}" class="btn btn-default">{!! trans('admin/common.cancel') !!}</a>
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

@endsection
