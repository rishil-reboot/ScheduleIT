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
    <h4 class="page-title">Transaction Details</h4>
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
                                                <div class="col-md-2">{!! trans('admin/transaction.user_name') !!}</div>
                                                <div class="col-md-10">{!! $transaction->user->username !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/transaction.user_email') !!}</div>
                                                <div class="col-md-10">{!! $transaction->user->email !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/transaction.user_photo') !!}</div>
                                                <div class="col-md-10">
                                                    <?php 

                                                        $img = !empty($transaction->user->photo) ? asset('assets/front/img/user/'.$transaction->user->photo) : asset('assets/front/img/user/default.png');

                                                    ?>
                                                    <img src="{!! $img !!}" width="100">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/transaction.transaction_id') !!}</div>
                                                <div class="col-md-10">{!! $transaction->trans_id !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/transaction.payment_method') !!}</div>
                                                <div class="col-md-10">{!! $transaction->payment_method !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/transaction.credit') !!}</div>
                                                <div class="col-md-10">{!! $transaction->credit !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/transaction.amount') !!}</div>
                                                <div class="col-md-10">{!! $transaction->amount.' '.$transaction->currency !!}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">{!! trans('admin/transaction.transaction_status') !!}</div>
                                                <div class="col-md-10">
                                                    @if($transaction->status == 'success')
                                                    <button class="btn btn-success">{!! trans('admin/transaction.success') !!}</button>
                                                    @else
                                                    {!! $transaction->status !!}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <a href="{!! url('admin/transaction') !!}" class="btn btn-primary">{!! trans('admin/common.back') !!}</a>
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
