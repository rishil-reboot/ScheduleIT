@extends('admin.layout')

@section('styles')


@include('admin.booking_common._booking_common_css')

<style>
    .detailBox > .row:nth-of-type(2n+1) {
        background-color: #f9f9f9;
    }
    .detailBox > .row{
        margin: 0px 0px 5px 0px !important;
    }
    .detailBox > .row{
        padding: 10px !important;
    }
</style>

<link href="{!! asset('assets/booking/admin/font-awesome/css/font-awesome.min.css')!!}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Booking Details</h4>
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
                               
                                    <div class="box">
                                        <div class="box-body detailBox">
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/booking.user_name') !!}</div>
                                                <div class="col-md-10">{!! $booking->user->username !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/booking.booking_name') !!}</div>
                                                <div class="col-md-10">{!! $booking->full_name !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/booking.booking_email') !!}</div>
                                                <div class="col-md-10">{!! $booking->email !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/booking.booking_mobile') !!}</div>
                                                <div class="col-md-10">{!! $booking->phone !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/booking.booking_address') !!}</div>
                                                <div class="col-md-10">{!! $booking->address !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/booking.service') !!}</div>
                                                <div class="col-md-10">{!! $booking->service->title !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/booking.booking_date') !!}</div>
                                                <div class="col-md-10">
                                                    <?php $spots = $booking->bookingDetail?>
                                                    <?php foreach ($spots as $key => $spot):?>
                                                    <span>{!! date('d-m-Y h:i A', strtotime($spot->start_time)) !!} to {!! date('d-m-Y h:i A', strtotime($spot->end_time)) !!}</span><br>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/booking.credits') !!}</div>
                                                <div class="col-md-10">{!! $booking->amount !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/booking.booking_status') !!}</div>
                                                <div class="col-md-10">
                                                    @if($booking->status == 'pending')
                                                    <button class="btn btn-default">{!! trans('admin/booking.'.$booking->status) !!}</button>
                                                    @elseif($booking->status == 'cancel')
                                                    <button class="btn btn-danger">{!! trans('admin/booking.'.$booking->status) !!}</button>
                                                    @elseif($booking->status == 'confirm')
                                                    <button class="btn btn-success">{!! trans('admin/booking.'.$booking->status) !!}</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <a href="{{ route('booking.index') }}" class="btn btn-primary">{!! trans('admin/common.back') !!}</a>
                                        </div>
                                    </div> <!-- /.box -->
                               
                            </div><!-- /.row (main row) -->

                        </section><!-- /.content -->
                </div><!-- /.content-wrapper -->
        </div>
    </div>
</div>

@endsection

@section('scripts')

@include('admin.booking_common._booking_common_js')

    

@endsection
