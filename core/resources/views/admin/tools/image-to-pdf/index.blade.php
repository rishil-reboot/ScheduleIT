@extends('admin.layout')

@section('pagename')
 - Image To PDF
@endsection
@section('styles')
@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Image To PDF</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="#">
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
        <a href="#">Image To PDF</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Image To PDF</div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">

               <form id="ajaxFormData" action="{{route('admin.imagetopdf.update')}}" method="post" enctype="multipart/form-data">
                
                 {{csrf_field()}}
                  
                  <div class="row d-flex justify-content-center">

                      <div class="col-lg-6">
                        
                        <div class="form-group">
                            <label for="">File **</label>
                            <input type="file" class="form-control" name="file">
                            Note:- only .tiff, gif, jpeg, png files are allowed.
                            <p id="errfile" class="mb-0 text-danger em">
                                @if ($errors->has('file'))
                                    {{ $errors->first('file') }}
                                @endif
                            </p>

                          </div>

                      </div>

                     

                  </div>    
                  
                  <div class="row">
                     <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                     </div>
                  </div>

               </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

@endsection

@section('scripts')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#ajaxFormData").submit(function(e) {

        e.preventDefault();

        var formId = $(this).attr('id');
        var buttonText = $('#' + formId + ' button[type="submit"]').text();
        var $btn = $('#' + formId + ' button[type="submit"]').attr('disabled', 'disabled').html(
        "Processing...");

        var form_Data = new FormData(this);
        $.ajax({
            url: "{{ route('admin.imagetopdf.update') }}",
            type: 'POST',
            data: form_Data,
            success: function(response) {

                var filename = response.filename;

                $.ajax({
                        url: "{{ route('admin.imagetopdf.get-download-file') }}",
                        type: 'POST',
                        data: {'filename':filename },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(res) {

                            var blob = new Blob([res]);
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'download.pdf';
                            link.click();

                            $.ajax({
                                    url: "{{ route('admin.imagetopdf.remove-file-from-server') }}",
                                    type: 'POST',
                                    success: function(res) {

                                },
                                error: function(jqXhr) {

                                }
                            });

                            $('#' + formId + ' button[type="submit"]').text(buttonText);
                            $('#' + formId + ' button[type="submit"]').removeAttr('disabled', 'disabled');


                    },
                    error: function(jqXhr) {

                    }
                    
                });

           },
            error: function(jqXhr) {
                
                var errors = $.parseJSON(jqXhr.responseText);
                showErrorMessages(formId, errors);
                $('#' + formId + ' button[type="submit"]').text(buttonText);
                $('#' + formId + ' button[type="submit"]').removeAttr('disabled', 'disabled');

            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    function showErrorMessages(formId, errorResponse) {

        var msgs = "";
        $.each(errorResponse.errors, function(key, value) {
           
           $("#err"+key).html(value);

        });

    }

    function showMessageData(msgs) {

        $(".validation-message").html(msgs);
    }
</script>

@endsection
