@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Payment Setting</h4>
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
        <form class="" action="{{route('admin.booking.updateSettings')}}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-title">Payment Setting</div>
                </div>
            </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                @csrf
                <div class="form-group">
                  <label>Payment Setting **</label>
                  <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="booking_payment" value="1" class="selectgroup-input" {{$abs->booking_payment == 1 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Active</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="booking_payment" value="2" class="selectgroup-input" {{$abs->booking_payment == 2 ? 'checked' : ''}}>
                            <span class="selectgroup-button">Deactive</span>
                        </label>
                    </div>
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
    </div>
  </div>

@endsection
