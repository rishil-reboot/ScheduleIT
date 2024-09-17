@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Booking Email Setting</h4>
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
        <a href="#">Booking Email Management</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="" action="{{route('admin.booking.updateEmailSettings')}}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-title">Booking Email Setting</div>
                </div>
            </div>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                @csrf
                 <div class="form-group">
                    <label for="">Content **</label>
                    <textarea class="form-control summernote" name="booking_spot_description" data-editor="booking_spot_description" rows="8" cols="80" placeholder="Enter content">{!! $abs->booking_spot_description !!}</textarea>
                    <p id="errcontent" class="mb-0 text-danger em"></p>
                    <p><strong>Note:</strong>This Content is used to send mail when booking spot time will over.</p>
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
<!-- Include the media selection modal -->
@include('admin.partials.media-selection-modal')
@endsection
