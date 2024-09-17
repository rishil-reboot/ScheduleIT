@extends('admin.layout')

@section('styles')

@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Advertisement</h4>
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
        <a href="#">Basic Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Advertisement</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Advertisement</div>
          <a href="{{route('admin.advertisement.create')}}" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Advertisement</a>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($testimonials) == 0)
                <h3 class="text-center">NO ADVERTISEMENT FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col"># Unique Number</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Is Feature</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($testimonials as $key => $testimonial)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>
                            <img src="{{asset('assets/front/img/advertisement/'.$testimonial->image)}}" alt="" width="40">
                          </td>
                          <td>{{convertUtf8($testimonial->name)}}</td>
                          <td>{{$testimonial->serial_number}}</td>
                          <td>
                            <form id="featureForm{{$testimonial->id}}" class="d-inline-block" action="{{route('admin.advertisement.feature')}}" method="post">
                            @csrf
                            <input type="hidden" name="adverticement_id" value="{{$testimonial->id}}">
                            <select class="form-control {{$testimonial->status == 1 ? 'bg-success' : 'bg-danger'}}" name="status" onchange="document.getElementById('featureForm{{$testimonial->id}}').submit();">
                                <option value="1" {{ $testimonial->status == 1 ? 'selected' : ''}}>Yes</option>
                                <option value="0" {{$testimonial->status == 0 ? 'selected' : ''}}>No</option>
                            </select>
                            </form>
                          </td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.advertisement.edit', $testimonial->id) . '?language=' . request()->input('language')}}">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                            Edit
                            </a>
                            
                            <?php /*<form class="deleteform d-inline-block" action="{{route('admin.advertisement.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="testimonial_id" value="{{$testimonial->id}}">
                              <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                Delete
                              </button>
                            </form> */ ?>

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
    </div>
  </div>


  <!-- Create Testimonial Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Advertisement</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
              <label for="">Link **</label>
              <input type="text" class="form-control" name="link" value="" placeholder="Enter link">
              <p id="errlink" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
              <label for="">Description</label>
              <textarea class="form-control" name="description" value="" placeholder="Enter description">
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


@section('scripts')
<script>
$(document).ready(function() {

    // make input fields RTL
    $("select[name='language_id']").on('change', function() {

        $(".request-loader").addClass("show");

        let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
        console.log(url);
        $.get(url, function(data) {
            $(".request-loader").removeClass("show");
            if (data == 1) {
                $("form.modal-form input").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form.modal-form select").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form.modal-form textarea").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form.modal-form .nicEdit-main").each(function() {
                    $(this).addClass('rtl text-right');
                });

            } else {
                $("form.modal-form input, form.modal-form select, form.modal-form textarea").removeClass('rtl');
                $("form.modal-form .nicEdit-main").removeClass('rtl text-right');
            }
        })
    });
});
</script>
@endsection
