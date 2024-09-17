@extends('admin.layout')


@section('styles')

@include('admin.booking_common._booking_common_css')

<link href="{!! asset('assets/booking/admin/plugins/bootstrap3-editable/css/bootstrap-editable.css') !!}" rel="stylesheet" type="text/css" />
<style>
    .credit-txt{cursor: pointer;}

    .fade:not(.show) {
        opacity: 1;
    }

    .popover-title {
        padding: 8px 14px;
        margin: 0;
        font-size: 14px;
        background-color: #f7f7f7;
        border-bottom: 1px solid #ebebeb;
        border-radius: 5px 5px 0 0;
    }
    #userFrom5{
      padding: 40px;
    }

</style>

@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">
        Customers
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
        <a href="#">Customers</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

        <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title">Default User Credit</div>
                </div>
            </div>
        </div>
        <form class="" action="{{route('register.user.updateDefaultCredit')}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-lg-5 offset-3">
                <div class="form-group">
                  <label>Credit **</label>
                  <input class="form-control" name="default_credit" value="{{$bs->default_credit}}" placeholder="Add default credit">
                  @if ($errors->has('default_credit'))
                    <p class="mb-0 text-danger">{{$errors->first('default_credit')}}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card-title">
                        Customers
                    </div>
                </div>
                <div class="col-lg-6">

                    <a href="{{route('admin.register.user.create')}}" class="btn btn-primary float-lg-right float-left btn-sm"><i class="fas fa-plus"></i> Add Customer</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.order.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                    <a href="#" class="btn btn-primary float-lg-right btn-sm mr-2" data-toggle="modal" data-target="#createModal"><i class="fas fa-file-import"></i> Import </a>

                    <form action="{{route('register.user.export')}}" method="post">
                      @csrf
                      <button class="btn btn-primary float-right btn-sm mr-2" type="submit"> <i class="fas fa-file-export"></i> Export</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($users) == 0)
                <h3 class="text-center">NO User FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Credit</th>
                        <th scope="col">Booking</th>
                        <th scope="col">Transactions</th>
                        <th scope="col">Chat History</th>
                        <th scope="col">Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">View</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $key => $user)
                        <tr>

                          <td><img src="{{!empty($user->photo) ? asset('assets/front/img/user/'.$user->photo) : ''}}" alt="" width="60"></td>
                          <td>{{convertUtf8($user->username)}}</td>
                          <td>{{convertUtf8($user->email)}}</td>
                          <td>
                              <span class="" data-toggle="tooltip" title="{{trans('admin/user.credit_info')}}" data-original-title="Click to edit user credit"><a class="credit_{{$user->id}} credit-txt editable editable-click" data-userid="{{$user->id}}" data-original-title="" title="">{{$user->credit}}</a></span>
                          </td>
                          <td><a href="{{route('users.booking.index',$user->id)}}" class="btn btn-primary" id="20" title="" data-toggle="tooltip" data-original-title="View Bookings">{{$user->booking_count}}</a></td>

                          <td>
                            <a href="{{route('users.transaction.index',$user->id)}}" class="btn btn-primary" id="20" title="" data-toggle="tooltip" data-original-title="View Transactions">{{$user->transaction_count}}</a>
                          </td>
                          
                          <td>
                            <a href="{{route('admin.chatboard.history',$user->id)}}" class="btn btn-primary" title="" data-toggle="tooltip" data-original-title="View Chat"><i class="fa fa-eye"></i></a>
                          </td>
                          <td></td>
                          <td>
                             {{$user->number}}
                          </td>

                          <td>
                             {{$user->address}}
                          </td>
                          <td>
                             <form id="userFrom{{$user->id}}" class="d-inline-block" action="{{route('register.user.ban')}}" method="post">
                              @csrf
                              <select class="form-control {{$user->status == 1 ? 'bg-success' : 'bg-danger'}}" name="status" onchange="document.getElementById('userFrom{{$user->id}}').submit();">
                                  <option value="1" {{$user->status == 1 ? 'selected' : ''}}>Active</option>
                                  <option value="0" {{$user->status == 0 ? 'selected' : ''}}>Deactive</option>
                              </select>
                              <input type="hidden" name="user_id" value="{{$user->id}}">
                              </form>
                          </td>
                          <td>
                            <a href="{{route('register.user.view',$user->id)}}" class="btn btn-primary btn-sm editbtn"><i class="fas fa-eye"></i> View </a>
                          </td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.register.user.edit', $user->id)}}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              Edit
                            </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

              @endif
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{$users->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


   <!-- Create Feature Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Import Customers</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form" action="{{route('register.user.import')}}" method="post">
            @csrf

            <div class="form-group">
                <label for="">Import File</label>
                <input type="file" name="import_file" class="form-control" id="import_file" required>
                <a href="{{asset('assets/front/sample/customer_import_sample.xlsx')}}"><i class="fa fa-download" aria-hidden="true"></i> Download Sample file</a>
                <br>
                  <span>
                    <strong>Note:-</strong> 1) Already existing username and email record will be skipp.
                    2) In Sample file field with value filled is required.
                  </span>
                <p id="errimport_file" class="mb-0 text-danger em"></p>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')

@include('admin.booking_common._booking_common_js')

<script src="{{asset('assets/booking/admin/plugins/bootstrap3-editable/js/bootstrap-editable.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
  $.fn.editableform.buttons =
            '<button type="submit" class="btn btn-success editable-submit btn-mini"><i class="fa fa-check"></i></button>' +
            '<button type="button" class="btn editable-cancel btn-mini"><i class="fa fa-times"></i></button>';

  $('.credit-txt').editable({
      type: 'text',
      pk: '1',
      url: '{{route("register.user.updateCredit")}}',
      params: function(params) {
          // add additional params from data-attributes of trigger element
          params._token = "{!! csrf_token() !!}";
          params.userId = $(this).editable().data('userid');
          return params;
      },
      name: 'credit',
      title: "{!! trans('admin/user.credit_title') !!}",
      success: function () {
      }
  });

</script>
@endsection



