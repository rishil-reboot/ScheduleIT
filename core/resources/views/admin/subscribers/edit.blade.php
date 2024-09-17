@extends('admin.layout')

@if(!empty($page->language) && $page->language->rtl == 1)
@section('styles')
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    form .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Subscribers</h4>
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
        <a href="#">Edit Subscriber</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Subscribers</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Subscriber</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.subscriber.index')}}">
						<span class="btn-label">
							<i class="fas fa-backward" style="font-size: 12px;"></i>
						</span>
						Back
					</a>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-10 offset-lg-3">
              <form id="ajaxForm" action="{{route('admin.subscriber.update')}}" method="post">
                @csrf
                <input type="hidden" name="subscriberid" value="{{$subscriber->id}}">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Email **</label>
                      <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{$subscriber->email}}">
                      <p id="erremail" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 offset-lg-3">
                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

