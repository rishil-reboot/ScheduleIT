@extends('admin.layout')

@if(!empty($abs->language) && $abs->language->rtl == 1)
@section('styles')
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
@endsection
@endif

@section('content')
<div class="page-header">
    <h4 class="page-title">Steps</h4>
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
        <a href="#">Steps</a>
      </li>
    </ul>
  </div>


<div class="card">
    <div class="card-header">
      <div class="card-title d-inline-block">Steps</div>
      <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Step</a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12">
          @if (count($steps) == 0)
            <h3 class="text-center">NO STEP FOUND</h3>
          @else
            <div class="table-responsive">
              <table class="table table-striped mt-3">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Images </th>
                    <th scope="col">Step number </th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Serial Number</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($steps as $key => $step)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td><img src="{{asset('assets/front/img/steps/'.$step->image)}}" alt="" width="40"></td>
                      <td>{{convertUtf8($step->step_number)}}</td>
                      <td>{{convertUtf8($step->title)}}</td>
                      <td>{{convertUtf8($step->description)}}</td>
                      <td>{{convertUtf8($step->serial_number)}}</td>
                      <td>
                        <a class="btn btn-secondary btn-sm" href="{{route('admin.stepsection.edit', $step->id) . '?language=' . request()->input('language')}}">
                        <span class="btn-label">
                          <i class="fas fa-edit"></i>
                        </span>
                        Edit
                        </a>
                        <form class="deleteform d-inline-block" action="{{route('admin.stepsection.destroy')}}" method="post">
                          @csrf
                          <input type="hidden" name="step_id" value="{{$step->id}}">
                          <button type="submit" class="btn btn-danger btn-sm deletebtn">
                            <span class="btn-label">
                              <i class="fas fa-trash"></i>
                            </span>
                            Delete
                          </button>
                        </form>
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
  </div>


  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Steps</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="mb-3 dm-uploader drag-and-drop-zone modal-form" enctype="multipart/form-data" action="{{route('admin.stepsection.upload')}}" method="POST">
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
            </div>
            <p class="text-warning mb-0 mt-2">Upload 70X70 image or squre size image for best quality.</p>
          </form>

          <form id="ajaxForm" class="modal-form" action="{{route('admin.stepsection.store')}}" method="POST">
            @csrf
            <input type="hidden" id="image" name="" value="">
            <div class="form-group">
                <label for="">Language **</label>
                <select name="language_id" class="form-control">
                    <option value="" selected disabled>Select a language</option>
                    @foreach ($langs as $lang)
                        <option value="{{$lang->id}}">{{$lang->name}}</option>
                    @endforeach
                </select>
                <p id="errlanguage_id" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
                <label for="">Step number **</label>
                <input type="text" class="form-control" name="step_number" value="" placeholder="Enter step number">
                <p id="errstep_number" class="mb-0 text-danger em"></p>
              </div>


              <div class="form-group">
                <label for="">Title **</label>
                <input type="text" class="form-control" name="title" value="" placeholder="Enter title">
                <p id="errtitle" class="mb-0 text-danger em"></p>
              </div>

            <div class="form-group">
              <label for="">Description **</label>
              <textarea class="form-control" name="description" rows="3" cols="80" placeholder="Enter description"></textarea>
              <p id="errdescription" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
              <label for="">Serial Number **</label>
              <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small>The higher the serial number is, the later the testimonial will be shown.</small></p>
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

