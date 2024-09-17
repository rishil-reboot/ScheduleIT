@extends('admin.layout')

@section('styles')
<style>
    form input,
    form textarea,
    form select {
        direction: ltr;
    }
    .nicEdit-main {
        direction: ltr;
        text-align: right;
    }
</style>
@endsection


@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit Step</h4>
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
        <a href="#">Edit Step</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Step</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.stepsection.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.stepsection.uploadUpdate', $step->id)}}" method="POST">
                @csrf
                <div class="form-row px-2">
                  <div class="col-12 mb-2">
                    <label for=""><strong>Image **</strong></label>
                  </div>
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                    <img src="{{asset('assets/front/img/steps/'.$step->image)}}" alt="image" class="img-thumbnail">
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
                        <p class="em text-danger mb-0" id="errstep_image"></p>
                      </div>
                  </div>
                </div>
                <p class="text-warning mb-0 mt-2">Upload 70X70 image or squre size image for best quality.</p>
              </form>

              <form id="ajaxForm" class="" action="{{route('admin.stepsection.update')}}" method="post">
                @csrf
                <input type="hidden" name="step_id" value="{{$step->id}}">
                <input type="hidden" id="image" name="step_image" value="{{$step->step_image}}">
                <div class="form-group">
                    <label for="">Step number **</label>
                    <input type="text" class="form-control" name="step_number" value="{{$step->step_number}}" placeholder="Enter step number">
                    <p id="errstep_number" class="mb-0 text-danger em"></p>
                  </div>
                  <div class="form-group">
                    <label for="">Title **</label>
                    <input type="text" class="form-control" name="title" value="{{$step->title}}" placeholder="Enter title">
                    <p id="errtitle" class="mb-0 text-danger em"></p>
                  </div>
                  <div class="form-group">
                    <label for="">Description **</label>
                    <textarea class="form-control" name="description" rows="3" cols="80" placeholder="Enter description">{{$step->description}}</textarea>
                    <p id="errdescription" class="mb-0 text-danger em"></p>
                  </div>
                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$step->serial_number}}" placeholder="Enter Serial Number">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group from-show-notify row">
                    <div class="col-12 text-center">
                      <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">

          </div>
        </div>
      </div>

    </div>
  </div>

@endsection
