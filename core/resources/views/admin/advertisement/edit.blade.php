@extends('admin.layout')

@if(!empty($testimonial->language) && $testimonial->language->rtl == 1)
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
    <h4 class="page-title">Edit Advertisement</h4>
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
        <a href="#">Edit Advertisement</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Advertisement</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.advertisement.index')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.advertisement.uploadUpdate', $testimonial->id)}}" method="POST">
                @csrf
                <div class="form-row px-2">
                  <div class="col-12 mb-2">
                    <label for=""><strong>Image **</strong></label>
                  </div>
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                    <img src="{{asset('assets/front/img/advertisement/'.$testimonial->image)}}" alt="..." class="img-thumbnail">
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
                <p class="text-warning mb-0 mt-2">Upload 70X70 image or squre size image for best quality.</p>
              </form>

              <form id="ajaxForm" class="" action="{{route('admin.advertisement.update')}}" method="post">
                @csrf
                <input type="hidden" name="adverticement_id" value="{{$testimonial->id}}">
                <div class="form-group">
                  <label for="">Name **</label>
                  <input type="text" class="form-control" name="name" value="{{$testimonial->name}}" placeholder="Enter name">
                  <p id="errname" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label for="">Ads Type</label>
                  <br>
                  <input type="radio" @if($testimonial->add_type == 1) checked @endif class="add_type" name="add_type" value="1"> Text
                  <input type="radio" @if($testimonial->add_type == 2) checked @endif style="margin-left:20px" class="add_type" name="add_type" value="2"> Iframe
                  <p id="erradd_type" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group text-div">
                  <label for="">Text</label>
                  <textarea class="form-control" name="description" placeholder="Enter description">{{ $testimonial->description }}</textarea>
                  <p id="errdescription" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group text-div">
                  <label for="">Link </label>
                  <input type="text" class="form-control" name="link" value="{!! $testimonial->link !!}" placeholder="Enter link">
                  <p id="errlink" class="mb-0 text-danger em"></p>
                </div>


                <div class="form-group iframe-div" style="display:none">
                  <label for="">Iframe</label>
                  <textarea class="form-control" name="iframe_data" placeholder="Enter Iframe">{!! $testimonial->iframe_data !!}</textarea>
                  <p id="erriframe_data" class="mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$testimonial->serial_number}}" placeholder="Enter Serial Number">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning"><small>The higher the serial number is, the later the advertisement will be shown.</small></p>
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

@endsection

@section('scripts')
<script>
  
  $(document).ready(function(){

      $(document).on("change",".add_type",function(){

          callAddType();

      });

      function callAddType(){

          var addType = $(".add_type:checked").val();

          if (addType == 1) {

              $(".text-div").show();
              $(".iframe-div").hide();

          }else{

              $(".text-div").hide();
              $(".iframe-div").show();
          }
      }

      callAddType();
  });  
</script>
@endsection

