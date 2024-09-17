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
                        <h1>My Transaction</h1>
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
                                {!! trans('user/transaction.my_transactions_list') !!}
                                <a style="color:white;" href="{{ route('reservation.index') }}" class="btn btn-sm btn-lbs mrgn_5t pull-right btn-primary">{!! trans('user/transaction.reservation') !!}</a>
                            </div>

                        </div>

                        <div class="bac" style="margin-bottom:20px">
                            
                            {!! Form::open(array('route' => 'admin.transaction.search', 'id' => 'transaction-search-form', 'class' => 'form-inline','method' => 'POST')) !!}
                            
                            <div class="form-group">
                                {!! Form::label('search', trans('user/common.search')) !!}
                                <div style="margin-right: 10px;"></div>
                                {!! Form::select('search_by',array(''=>trans('user/common.search_by'), 'trans_id' => trans('user/transaction.transaction_id'),  'transaction_date' => trans('user/transaction.transaction_date')), session('SEARCH.SEARCH_BY') , array('class'=>'form-control', 'id' => 'search_by')) !!}

                            </div>
                            <div style="margin-right: 10px;"></div>

                            <div class="form-group">
                                <?php if (session('SEARCH.SEARCH_BY') == 'transaction_date'): ?>
                                    {!! Form::text('search_txt', session('SEARCH.SEARCH_TXT') ,array('id' => 'search_txt', 'class' => 'form-control', 'style' => 'display:none;')) !!}
                                <?php else: ?>
                                    {!! Form::text('search_txt', session('SEARCH.SEARCH_TXT') ,array('id' => 'search_txt', 'class' => 'form-control','placeholder'=>trans('user/common.search'))) !!}
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <?php if (session('SEARCH.SEARCH_BY') == 'transaction_date'): ?>
                                    <div class="input-group search_date" style="display:inline-table;">
                                        {!! Form::text('search_date',session('SEARCH.SEARCH_DATE'),['id' => 'search_date','class' => 'datepicker form-control',]) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                <?php else: ?>
                                    <div class="input-group search_date" style="display:none;">
                                        {!! Form::text('search_date',session('SEARCH.SEARCH_DATE'),['id' => 'search_date','class' => 'datepicker form-control',]) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group" style="padding:15px">
                                {!! Form::submit(trans('user/common.search'), array('id' => 'search', 'name' => '', 'class' => 'btn btn-primary ')) !!}
                                <div style="margin-right: 10px;"></div>
                                {!! Form::button(trans('user/common.reset'),array('type'=>'submit','id' => 'reset', 'name' => 'reset', 'value' => '1', 'class' => 'btn btn-defult')) !!}

                                <div style="margin-right: 15px;"></div>    

                                <a style="color: white" href="{{ route('front.transaction.export') }}" class="btn btn-primary btn-sm btn-lbs mrgn_5t pull-right">{!! trans('user/transaction.export_csv') !!}</a>
                            </div>

                            {!! Form::close() !!}
                            
                        </div>

                        <div class="widget-body"> 
                            <div class="table-responsive">  
                                <table class="table table-condensed no-margin table-custome">
                                    <thead>
                                        <tr class="table-head">
                                            <th>{!! trans('user/transaction.transaction_id') !!}</th>
                                            <th>{!! trans('user/transaction.payment_method') !!}</th>
                                            <th>{!! trans('user/transaction.credit') !!}</th>
                                            <th>{!! trans('user/transaction.amount') !!}</th>
                                            <th>{!! trans('user/transaction.transaction_date') !!}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($transactions))
                                            @foreach ($transactions as $data)
                                                <tr>
                                                    <td>{!! $data->trans_id !!}</td>
                                                    <td>{!! $data->payment_method !!}</td>
                                                    <td>{!! $data->credit !!}</td>
                                                    <td>{!! $data->amount .' '. $data->currency !!}</td>
                                                    <td>{!! date('d-m-Y h:i:s A',strtotime($data->created_at)) !!}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                {!! trans('user/transaction.no_transactions_found') !!}
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="clearfix"></div>
                                <div class="col-lg-9 offset-5 pagination" style="margin-top:10px">
                                    @if($transactions)
                                        {!! $transactions->render() !!} 
                                    @endif
                                </div>
                                <div style="padding:10px"></div>
                                <div class="col-lg-12 text-center">
                                    <a style="color:white" class="btn">{!! trans('user/common.total') !!} {!! $transactions->total() !!} </a>
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
        $('#search_by').change(function () {
            if ($('#search_by').val() == 'transaction_date') {
                $("#search_txt").hide();
                $(".search_date").show();
            } else {
                $(".search_date").hide();
                $("#search_txt").show();
            }
        });

        $(window).on('load', function () {
            $('#search_by').trigger('change');
        });

        $('.datepicker').datepicker({
            format: "dd-mm-yyyy",
            //startDate: "od",
            todayHighlight: true,
            todayBtn: true,
            autoclose: true
        }).inputmask('dd-mm-yyyy', {"placeholder": "dd-mm-yyyy", alias: "date", "clearIncomplete": true});
    });
</script>
@endsection
