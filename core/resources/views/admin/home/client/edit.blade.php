@extends('admin.layout')


@if(!empty($partner->language) && $partner->language->rtl == 1)
@section('styles')
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    .nicEdit-main {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif


@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit Client</h4>
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
        <a href="#">Home Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Client</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Client</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.client.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.client.uploadUpdate', $partner->id)}}" method="POST">
                @csrf
                <div class="form-row px-2">
                  <div class="col-12 mb-2">
                    <label for=""><strong>Image **</strong></label>
                  </div>
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                    <img src="{{asset('assets/front/img/client/'.$partner->image)}}" alt="..." class="img-thumbnail">
                  </div>
                  <div class="col-sm-12">
                    <div class="from-group mb-2">
                      <input type="text" class="form-control progressbar" aria-describedby="fileHelp" placeholder="No image uploaded..." readonly="readonly" />

                      <div class="progress mb-2 d-none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                          role="progressbar"
                          style="width: 0%;"
                          aria-valuenow="0" aria-valuemin="0" aria-valuemax="0">
                          0%
                        </div>
                      </div>

                    </div>

                    <div class="mt-4">
                      <div role="button" class="btn btn-primary mr-2">
                        <i class="fa fa-folder-o fa-fw"></i> Browse Files
                        <input type="file" title='Click to add Files'  />
                      </div>
                      <small class="status text-muted">Select a file or drag it over this area..</small>
                    </div>
                  </div>
                </div>
              </form>

              <form id="ajaxForm" class="" action="{{route('admin.client.update')}}" method="post">
                @csrf
                <input type="hidden" name="partner_id" value="{{$partner->id}}">
                
                <div class="form-group">
                    <label for="">Name **</label>
                    <input type="text" name="name" value="{{$partner->name}}" class="form-control" placeholder="Enter Name">
                    <p id="errname" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                  <label for="">URL Slug **</label>
                  <input type="text" class="form-control" name="slug" placeholder="Enter SEO Friendly URL Slug" value="{{ $partner->slug }}">
                  <p id="errslug" class="em text-danger mb-0"></p>
                </div>


                <div class="form-group">
                  <label for="">URL</label>
                  <input type="text" class="form-control" name="url" placeholder="Enter URL" value="{{ $partner->url }}">
                  <p id="errurl" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                  <label for="">Address</label>
                  <textarea class="form-control" name="address" placeholder="Enter address">{!! $partner->address !!}</textarea>
                  <p id="erraddress" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                  <label for="">State</label>
                  <input type="text" class="form-control" value="{{$partner->state}}" name="state" placeholder="Enter state name">
                  <p id="errstate" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                  <label for="">City</label>
                  <input type="text" class="form-control" value="{{$partner->city}}" name="city" placeholder="Enter city name">
                  <p id="errcity" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                  <label for="">Zipcode</label>
                  <input type="text" class="form-control" value="{{ $partner->zip }}" name="zip" placeholder="Enter zipcode">
                  <p id="errzip" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                    <label for="">Description </label>
                    <textarea name="description" class="form-control" placeholder="Enter Description">{!! $partner->description !!}</textarea>
                    <p id="errdescription" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                    <label for="">Long Description </label>
                    <textarea name="long_description" class="form-control summernote" data-editor="long_description" placeholder="Enter Description">{!! $partner->long_description !!}</textarea>
                    <p id="errlong_description" class="em text-danger mb-0"></p>
                </div>


                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$partner->serial_number}}" placeholder="Enter Serial Number">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning"><small>The higher the serial number is, the later the client will be shown.</small></p>
                </div>

                <div class="form-group">
                  <label>Meta Keywords</label>
                  <input class="form-control" name="meta_keyword" value="{{$partner->meta_keyword}}" placeholder="Enter meta keywords" data-role="tagsinput">
                </div>

                <div class="form-group">
                  <label>Meta Description</label>
                  <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{!! $partner->meta_description !!}</textarea>
                </div>

              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
<!-- Include the media selection modal -->
@include('admin.partials.media-selection-modal', ['mediaData' => $mediaData])
@endsection
