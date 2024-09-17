@extends('admin.layout')

@php
$selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/daterangepicker.css')}}" />
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

@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Services</h4>
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
                    <div class="card-title d-inline-block">Service</div>
                </div>
                <div class="col-lg-3"></div>
                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                    <a href="{{route('booking-services.create')}}" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Service</a>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
                
                <div class="table-responsive">
                    <table id="services_list" class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">{!! trans('admin/service.title') !!}</th>
                                <th scope="col">{!! trans('admin/service.service_type') !!}</th>
                                <th scope="col">{!! trans('admin/service.price') !!}</th>
                                <th scope="col">{!! trans('admin/service.duration') !!}</th>
                                <th scope="col">{!! trans('admin/common.status') !!}</th>
                                <th scope="col">{!! trans('admin/common.action') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{asset('assets/admin/plugin/datatable/jquery.dataTables.js')}}"></script>
<script type="text/javascript">
    var oTable;
    $(document).ready(function() {
        oTable = $('#services_list').dataTable({
            "dom": "<'row no-gutters'<'col-md-4 no-padding'l><'col-md-4'r><'col-md-4 no-padding'f>>t<'row no-gutters'<'col-md-4 no-padding'i><'col-md-4'><'col-md-4 no-padding'p>>",
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admin.booking-services.getServicesData') }}",
            "columnDefs": [
                {"orderable": false, "targets": [2, 3, 4, 5]},
            ],
            "order": [[0, "asc"]],
            "language": {
                "emptyTable": "{!! trans('admin/common.datatable.empty_table') !!}",
                "info": "{!! trans('admin/common.datatable.info') !!}",
                "infoEmpty": "{!! trans('admin/common.datatable.info_empty') !!}",
                "infoFiltered": "({!! trans('admin/common.datatable.info_filtered') !!})",
                "lengthMenu": "{!! trans('admin/common.datatable.length_menu') !!}",
                "loadingRecords": "{!! trans('admin/common.datatable.loading') !!}",
                "processing": "{!! trans('admin/common.datatable.processing') !!}",
                "search": "{!! trans('admin/common.datatable.search') !!}:",
                "zeroRecords": "{!! trans('admin/common.datatable.zero_records') !!}",
                "paginate": {
                    "first": "{!! trans('admin/common.datatable.first') !!}",
                    "last": "{!! trans('admin/common.datatable.last') !!}",
                    "next": "{!! trans('admin/common.datatable.next') !!}",
                    "previous": "{!! trans('admin/common.datatable.previous') !!}"
                },
            }
        });

        $("#services_list").on('click', '.delete-btn', function() {
            var id = $(this).attr('id');
            var r = confirm("{!! trans('admin/common.delete_confirmation') !!}");
            if (!r) {
                return false
            }
            $.ajax({
                type: "POST",
                url: "{{url('admin/booking-services')}}/" + id,
                data: {
                    _method: 'DELETE',
                    _token: "{!! csrf_token() !!}"
                },
                dataType: 'json',
                beforeSend: function() {
                    $(this).attr('disabled', true);
                    $('.alert .msg-content').html('');
                    $('.alert').hide();
                },
                success: function(resp) {
                    $('.alert:not(".session-box")').show();
                    if (resp.success) {
                        $('.alert-success .msg-content').html(resp.message);
                        $('.alert-success').removeClass('hide');
                    } else {
                        $('.alert-danger .msg-content').html(resp.message);
                        $('.alert-danger').removeClass('hide');
                    }
                    $(this).attr('disabled', false);
                    oTable.fnDraw();
                },
                error: function(e) {
                    alert('Error: ' + e);
                }
            });
        });

        $("#services_list").on('click', '.status-btn', function() {
            var id = $(this).attr('id');
            var r = confirm("{!! trans('admin/common.status_confirmation') !!}");
            if (!r) {
                return false
            }
            $.ajax({
                type: "POST",
                url: "{{url('admin/booking-services/changeStatus')}}",
                data: {
                    id: id,
                    _token: "{!! csrf_token() !!}"
                },
                dataType: 'json',
                beforeSend: function() {
                    $(this).attr('disabled', true);
                    $('.alert .msg-content').html('');
                    $('.alert').hide();
                },
                success: function(resp) {
                    $('.alert:not(".session-box")').show();
                    if (resp.success) {
                        $('.alert-success .msg-content').html(resp.message);
                        $('.alert-success').removeClass('hide');
                    } else {
                        $('.alert-danger .msg-content').html(resp.message);
                        $('.alert-danger').removeClass('hide');
                    }
                    $(this).attr('disabled', false);
                    oTable.fnDraw();
                },
                error: function(e) {
                    alert('Error: ' + e);
                }
            });
        });
    });

    $(document).ready(function(){

        $("#services_list_filter input[type='search']").addClass('form-control');
        $("#services_list_length select[name='services_list_length']").addClass('form-control');

    });

</script>
@endsection
