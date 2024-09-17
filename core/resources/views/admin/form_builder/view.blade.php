@extends('admin.layout')
@section('content')
  <style type="text/css">
  .form-wrap.form-builder .frmb li,.form-wrap.form-builder .frmb-control li,.form-wrap.form-builder .frmb .form-elements{background-color: #212529;}
  .form-wrap.form-builder .frmb .form-elements [contenteditable].form-control, .form-wrap.form-builder .frmb .form-elements input[type='text'], .form-wrap.form-builder .frmb .form-elements input[type='number'], .form-wrap.form-builder .frmb .form-elements input[type='date'], .form-wrap.form-builder .frmb .form-elements input[type='color'], .form-wrap.form-builder .frmb .form-elements textarea, .form-wrap.form-builder .frmb .form-elements select{background-color: #212529;}
  body[data-background-color="dark"] .form-control, body[data-background-color="dark"] .form-group-default, body[data-background-color="dark"] .select2-container--bootstrap .select2-selection{color: #000;}
  #language,#name{color: #fff;}
</style>
@php
  $default = \App\Language::where('is_default', 1)->first();
@endphp
  <div class="page-header">
    <h4 class="page-title">Forms</h4>
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
        <a href="#">View</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Forms</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">View Form</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.form_builder.index') . '/'.$form_id.'/formdata/?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-10 offset-lg-1">
              <div class="row">
                <div class="col-lg-12">
                  <table class="table table-bordered">
                    @foreach($theads as $thead)
                      @if(isset($thead['name']) && isset($thead['type']) && $thead['type'] =='file' && isset($thead['label'])  && isset($json_data[$thead['name']]))
                        <tr>
                          <th>{{$thead['label']}}</th>
                          <td><img src="{{isset($json_data[$thead['name']])?$json_data[$thead['name']]:''}}" class="img-thumbnail"></td>
                        </tr>
                      @else
                        @if(isset($thead['name']) && isset($thead['label']) && isset($json_data[$thead['name']]))
                          <tr>
                            <th>{{$thead['label']}}</th>
                            <td>{{isset($json_data[$thead['name']])?$json_data[$thead['name']]:''}}</td>
                          </tr>
                        @endif

                      @endif
                    @endforeach
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


