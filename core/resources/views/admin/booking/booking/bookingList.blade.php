@extends('admin.layout')

@php
$selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp

@section('styles')
    
    @if(!empty($selLang) && $selLang->rtl == 1)
        <style>
            form:not(.modal-form) input,
            form:not(.modal-form) textarea,
            form:not(.modal-form) select,
            select[name='language'] {
                direction: rtl;
            }
            form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endif
    
    <link href="{!! asset('assets/booking/admin/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet" type="text/css" />

@include('admin.booking_common._booking_common_css')

@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Bookings</h4>
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
        <a href="#">Booking Management</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
         <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Bookings</div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
                <div class="box-body table-responsive">
                    <div class="row no-gutters mrgn_10b">
                        <div class="col-md-10">
                            {!! Form::open(array('route' => 'admin.booking.search', 'id' => 'booking-search-form', 'class' => 'form-inline','method' => 'POST')) !!}
                            <div class="form-group">
                                {!! Form::label('search', trans('admin/common.search')) !!}
                                <div style="margin-right: 5px;"></div>
                                {!! Form::select('search_by',array(''=>trans('admin/common.search_by'), 'service' => trans('admin/booking.service'), 'user' => trans('admin/booking.user_name'), 'name' => trans('admin/booking.booking_name'), 'email' => trans('admin/booking.booking_email'),  'phone' => trans('admin/booking.booking_mobile'), 'booking_date' => trans('admin/booking.booking_date')), session('SEARCH.SEARCH_BY') , array('class'=>'form-control', 'id' => 'search_by')) !!}
                            </div>
                            <div class="form-group">
                            <?php if (session('SEARCH.SEARCH_BY') == 'service' || session('SEARCH.SEARCH_BY') == 'user' || session('SEARCH.SEARCH_BY') == 'booking_date'): ?>
                                {!! Form::text('search_txt', session('SEARCH.SEARCH_TXT') ,array('id' => 'search_txt', 'class' => 'form-control', 'style' => 'display:none;')) !!}
                            <?php else: ?>
                                {!! Form::text('search_txt', session('SEARCH.SEARCH_TXT') ,array('id' => 'search_txt', 'class' => 'form-control','placeholder'=>trans('admin/common.search'))) !!}
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
                                <?php if (session('SEARCH.SEARCH_BY') == 'user'): ?>
                                    {!! Form::select('user_id',$userList, session('SEARCH.USER_ID') , array('class'=>'form-control', 'id' => 'user_id', 'style' => 'display:inline-block;')) !!}
                                <?php else: ?>
                                    {!! Form::select('user_id',$userList, session('SEARCH.USER_ID') , array('class'=>'form-control', 'id' => 'user_id', 'style' => 'display:none;')) !!}
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <?php if(session('SEARCH.SEARCH_BY')=='booking_date'):?>
                                <div class="input-group search_date">
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
                            
                            <div class="form-group">
                                {!! Form::submit(trans('admin/common.search'), array('id' => 'search', 'name' => '', 'class' => 'btn btn-info')) !!} <div style="margin-right: 5px;"></div>
                                {!! Form::button(trans('admin/common.reset'),array('type'=>'submit','id' => 'reset', 'name' => 'reset', 'value' => '1', 'class' => 'btn btn-defult')) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-md-2">
                            <a href="{!! url('admin/booking/export') !!}" class="btn btn-sm btn-info pull-right">{!! trans('admin/booking.export_csv') !!}</a>
                        </div>
                    </div>
                    <table id="booking_list" class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">{!! trans('admin/booking.service') !!}</th>
                                <th scope="col">{!! trans('admin/booking.user_name') !!}</th>
                                <th scope="col">{!! trans('admin/booking.booking_name') !!}</th>
                                <th scope="col">{!! trans('admin/booking.booking_email') !!}</th>
                                <th scope="col">{!! trans('admin/booking.booking_mobile') !!}</th>
                                <th scope="col">{!! trans('admin/booking.date') !!}</th>
                                <th scope="col">{!! trans('admin/common.status') !!}</th>
                                <th scope="col">{!! trans('admin/common.action') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($bookings))
                            @foreach ($bookings as $data)
                                <tr>
                                    
                                    <td>{!! $data->service->title !!}</td>
                                    <td>{!! $data->user->username !!}</td>
                                    <td>{!! $data->full_name !!}</td>
                                    <td>{!! $data->email !!}</td>
                                    <td>{!! $data->phone !!}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="spnToggle" id="bookingDetail_<?php echo $data->id; ?>">{!! trans('admin/common.view') !!}</a>
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
                                    <td>
                                        @if($data->status == 'pending')
                                        <select class="form-control status-btn" id="{!! $data->id !!}">
                                            <option value="pending" selected="selected">{!! trans('admin/booking.pending') !!}</option>
                                            <option value="confirm">{!! trans('admin/booking.confirm') !!}</option>
                                            <option value="cancel">{!! trans('admin/booking.cancel') !!}</option>
                                        </select>
                                        @elseif($data->status == 'cancel')
                                        <a class="btn btn-danger" style="color:white" title="{!! trans('admin/booking.cancelled_booking') !!}" data-toggle="tooltip">{!! trans('admin/booking.'.$data->status) !!}</a>
                                        @elseif($data->status == 'confirm')
                                        <a class="btn btn-success" style="color:white" title="{!! trans('admin/booking.confirmed_booking') !!}" data-toggle="tooltip">{!! trans('admin/booking.'.$data->status) !!}</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('admin/booking')}}/{!! $data->id !!}" id="{!! $data->id !!}" class="btn btn-primary view-btn" title="{!! trans('admin/common.view') !!}" data-toggle="tooltip"><i class="fa fa-eye"></i></a>&nbsp;
                                        <a href="javascript:;" id="{!! $data->id !!}" class="btn btn-danger delete-btn" title="{!! trans('admin/common.delete') !!}" data-toggle="tooltip"><i class="fa fa-times"></i></a>&nbsp;
                                    </td>
                                </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8" class="text-center">
                                    {!! trans('admin/booking.no_bookings_found') !!}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="col-md-12 offset-5 text-center pagination pagination-sm no-margin">
                        @if($bookings)
                            {!! $bookings->render() !!} 
                        @endif
                    </div>
                    <div class="col-md-12 text-center">
                        <a class="btn">{!! trans('admin/common.total') !!} {!! $bookings->total() !!} </a>
                    </div>
                </div><!-- /. box-footer -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')

@include('admin.booking_common._booking_common_js')

<script type="text/javascript">
    
    $(document).ready(function() {
        $("#booking_list").on('click', '.delete-btn', function() {
            var $btn = $(this);
            var id = $(this).attr('id');
            var r = confirm("{!! trans('admin/common.delete_confirmation') !!}");
            if (!r) {
                return false
            }
            $.ajax({
                type: "POST",
                url: "{{url('admin/booking')}}/" + id,
                data: {
                    _method: 'DELETE',
                    _token: "{!! csrf_token() !!}"
                },
                dataType: 'json',
                beforeSend: function() {
                    $btn.attr('disabled', true);
                    $('.alert .msg-content').html('');
                    $('.alert').hide();
                },
                success: function(resp) {
                    window.location.href = window.location.href;
                },
                error: function(e) {
                    alert('Error: ' + e);
                }
            });
        });

        $("#booking_list").on('change', '.status-btn', function() {
            var id = $(this).attr('id');
            var val = $(this).val();
            var r = confirm("{!! trans('admin/common.status_confirmation') !!}");
            if (!r) {
                return false
            }
            $.ajax({
                type: "POST",
                url: "{{route('admin.booking.changeBookingStatus')}}",
                data: {
                    id: id,
                    value: val,
                    _token: "{!! csrf_token() !!}"
                },
                dataType: 'json',
                beforeSend: function() {
                    
                },
                success: function(resp) {
                    window.location.href = window.location.href
                },
                error: function(e) {
                    alert('Error: ' + e);
                }
            });
        });
        
        $(".spnToggle").click(function(){
           $('span#'+$(this).attr('id')).toggle();
        });
        
        $('#search_by').change(function () {
            if ($('#search_by').val() == 'service') {
                $("#service_id").show();
                $("#user_id").hide();
                $("#search_txt").hide();
                $(".search_date").hide();
            }else if ($('#search_by').val() == 'user') {
                $("#service_id").hide();
                $("#user_id").show();
                $("#search_txt").hide();
                $(".search_date").hide();
            }else if ($('#search_by').val() == 'booking_date') {
                $("#service_id").hide();
                $("#user_id").hide();
                $("#search_txt").hide();
                $(".search_date").show();
            } else {
                $("#service_id").hide();
                $("#user_id").hide();
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

    $(document).ready(function(){

        $("#currency_list_filter input[type='search']").addClass('form-control');
        $("#currency_list_length select[name='currency_list_length']").addClass('form-control');

    });

</script>

@endsection
