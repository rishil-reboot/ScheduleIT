@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit App</h4>
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
        <a href="#">App Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit App</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit App</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.appsection.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">

              {{-- Slider images upload start --}}
              <div class="px-2">
                <label for="" class="mb-2"><strong>Slider Images **</strong></label>
                <div class="row">
                  <div class="col-12">
                    <table class="table table-striped" id="imgtable">

                    </table>
                  </div>
                </div>
                <form action="{{route('admin.appsection.sliderupdate')}}" id="my-dropzone" enctype="multipart/formdata" class="dropzone">
                    @csrf
                    <input type="hidden" name="app_id" value="{{$freeAppSection->id}}">
                    <div class="fallback">
                      <input name="file" type="file" multiple  />
                    </div>
                </form>
                <p class="em text-danger mb-0" id="errslider_images"></p>
              </div>
              {{-- Slider images upload end --}}


              <form id="ajaxForm" class="" action="{{route('admin.appsection.update')}}" method="post">
                @csrf
                <input type="hidden" name="app_id" value="{{$freeAppSection->id}}">

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Title **</label>
                      <input type="text" class="form-control" name="title" value="{{$freeAppSection->title}}" placeholder="Enter title">
                      <p id="errtitle" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Subtitle**</label>
                      <input type="text" class="form-control" name="subtitle" value="{{$freeAppSection->subtitle}}" placeholder="Enter subtitle">
                      <p id="errsubtitle" class="mb-0 text-danger em"></p>
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

  {{-- dropzone --}}
  <script>
    // myDropzone is the configuration for the element that has an id attribute
    // with the value my-dropzone (or myDropzone)
    Dropzone.options.myDropzone = {
      acceptedFiles: '.png, .jpg, .jpeg',
      url: "{{route('admin.appsection.sliderstore')}}",
      success : function(file, response){
          console.log(response.file_id);

          // Create the remove button
          var removeButton = Dropzone.createElement("<button class='rmv-btn'><i class='fa fa-times'></i></button>");


          // Capture the Dropzone instance as closure.
          var _this = this;

          // Listen to the click event
          removeButton.addEventListener("click", function(e) {
            // Make sure the button click doesn't submit the form:
            e.preventDefault();
            e.stopPropagation();

            _this.removeFile(file);

            rmvimg(response.file_id);
          });

          // Add the button to the file preview element.
          file.previewElement.appendChild(removeButton);

          var content = {};

          content.message = 'Slider images added successfully!';
          content.title = 'Success';
          content.icon = 'fa fa-bell';

          $.notify(content,{
            type: 'success',
            placement: {
              from: 'top',
              align: 'right'
            },
            time: 1000,
            delay: 0,
          });
      }
    };

    function rmvimg(fileid) {
        // If you want to the delete the file on the server as well,
        // you can do the AJAX request here.

          $.ajax({
            url: "{{route('admin.appsection.sliderrmv')}}",
            type: 'POST',
            data: {
              _token: "{{csrf_token()}}",
              fileid: fileid
            },
            success: function(data) {
              var content = {};

              content.message = 'Slider image deleted successfully!';
              content.title = 'Success';
              content.icon = 'fa fa-bell';

              $.notify(content,{
                type: 'success',
                placement: {
                  from: 'top',
                  align: 'right'
                },
                time: 1000,
                delay: 0,
              });
            }
          });

    }
  </script>


  <script>
  var el = 0;

  $(document).ready(function(){
    $.get("{{route('admin.appsection.images', $freeAppSection->id)}}", function(data){
        for (var i = 0; i < data.length; i++) {
          $("#imgtable").append('<tr class="trdb" id="trdb'+data[i].id+'"><td><div class="thumbnail"><img style="width:150px;" src="{{asset('assets/front/img/free-app/sliders/')}}/'+data[i].image+'" alt="Ad Image"></div></td><td><button type="button" class="btn btn-danger pull-right rmvbtndb" onclick="rmvdbimg('+data[i].id+')"><i class="fa fa-times"></i></button></td></tr>');
        }
    });
  });

  function rmvdbimg(indb) {
    $(".request-loader").addClass("show");
    $.ajax({
      url: "{{route('admin.appsection.sliderrmv')}}",
      type: 'POST',
      data: {
        _token: "{{csrf_token()}}",
        fileid: indb
      },
      success: function(data) {
        $(".request-loader").removeClass("show");
        $("#trdb"+indb).remove();
        var content = {};

        content.message = 'Slider image deleted successfully!';
        content.title = 'Success';
        content.icon = 'fa fa-bell';

        $.notify(content,{
          type: 'success',
          placement: {
            from: 'top',
            align: 'right'
          },
          time: 1000,
          delay: 0,
        });
      }
    });

  }


  </script>

@endsection
