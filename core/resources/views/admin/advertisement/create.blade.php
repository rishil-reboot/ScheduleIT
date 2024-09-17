@extends('admin.layout')

@section('styles')
@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Add Advertisement</h4>
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
        <a href="#">Add Advertisement</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Add Advertisement</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.advertisement.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">

              <form class="mb-3 dm-uploader drag-and-drop-zone modal-form" enctype="multipart/form-data" action="{{route('admin.advertisement.upload')}}" method="POST">
                <div class="form-row px-2">
                  <div class="col-12 mb-2">
                    <label for=""><strong>Image **</strong></label>
                  </div>
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                    <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="..." class="img-thumbnail">
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
                        <input type="file" title='Click to add Files' name="logo" />
                      </div>
                      <small class="status text-muted">Select a file or drag it over this area..</small>
                      <p class="em text-danger mb-0" id="erradvertisement_image"></p>
                    </div>
                  </div>
                </div>
                <p class="text-warning mb-0 mt-2">Upload 70X70 image or squre size image for best quality.</p>
            </form>
            
            <form id="ajaxForm" class="modal-form" action="{{route('admin.advertisement.store')}}" method="POST">
              @csrf
              <input type="hidden" id="image" name="" value="">
              <div class="form-group">
                <label for="">Name **</label>
                <input type="text" class="form-control" name="name" value="" placeholder="Enter name">
                <p id="errname" class="mb-0 text-danger em"></p>
              </div>

              <div class="form-group">
                <label for="">Ads Type</label>
                <br>
                <input type="radio" checked class="add_type" name="add_type" value="1"> Text
                <input type="radio" style="margin-left:20px" class="add_type" name="add_type" value="2"> Iframe
                <p id="erradd_type" class="mb-0 text-danger em"></p>
              </div>

              <div class="form-group text-div">
                <label for="">Text</label>
                <textarea class="form-control" name="description" placeholder="Enter description"></textarea>
                <p id="errdescription" class="mb-0 text-danger em"></p>
              </div>

              <div class="form-group text-div">
                <label for="">Link </label>
                <input type="text" class="form-control" name="link" placeholder="Enter link">
                <p id="errlink" class="mb-0 text-danger em"></p>
              </div>


              <div class="form-group iframe-div" style="display:none">
                <label for="">Iframe</label>
                <textarea class="form-control" name="iframe_data" placeholder="Enter Iframe"></textarea>
                <p id="erriframe_data" class="mb-0 text-danger em"></p>
              </div>

              <div class="form-group">
                <label for="">Serial Number **</label>
                <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
                <p id="errserial_number" class="mb-0 text-danger em"></p>
                <p class="text-warning"><small>The higher the serial number is, the later the testimonial will be shown.</small></p>
              </div>
            </form>

            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success">Save</button>
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

        var addType = $(".add_type:checked").val();

        if (addType == 1) {

            $(".text-div").show();
            $(".iframe-div").hide();

        }else{

            $(".text-div").hide();
            $(".iframe-div").show();
        }

      });

  });  
</script>
@endsection
