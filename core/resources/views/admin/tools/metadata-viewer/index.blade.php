@extends('admin.layout')

@section('pagename')
    - Meta Data viewer
@endsection
@section('styles')

<style>
  .payment-information .col-lg-6 {
      margin-bottom: 14px;
  }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h4 class="page-title">Meta Data viewer</h4>
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
                <a href="#">Tools</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Meta Data viewer</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Meta Data viewer</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <form id="ajaxFormData" action="{{ route('admin.metadata-viewer.get-preview') }}" method="post"
                                enctype="multipart/form-data">

                                {{ csrf_field() }}

                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="">File **</label>
                                            <input type="file" class="form-control" name="file">
                                            Note:- only jpeg,jpg,jpe,jif,jfif,jfi,tif,tiff files are allowed.
                                            <p id="errfile" class="mb-0 text-danger em">
                                                @if ($errors->has('file'))
                                                    {{ $errors->first('file') }}
                                                @endif
                                            </p>
                                        </div>

                                      <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                          </div>
                                      </div>

                                    </div>

                                    <div class="col-lg-6 get-preview">

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
                url: "{{ route('admin.metadata-viewer.get-preview') }}",
                type: 'POST',
                data: form_Data,
                success: function(response) {

                    $(".get-preview").html(response);

                    $('#' + formId + ' button[type="submit"]').text(buttonText);
                    $('#' + formId + ' button[type="submit"]').removeAttr('disabled', 'disabled');

                    $('#ajaxFormData')[0].reset();
                    
                    $.ajax({
                        url: "{{ route('admin.metadata-viewer.remove-meta-file-from-server') }}",
                        type: 'POST',
                        data: form_Data,
                        success: function(response) {

                        },
                        error: function(jqXhr) {

                        },
                        cache: false,
                        contentType: false,
                        processData: false
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

                $("#err" + key).html(value);

            });

        }

        function showMessageData(msgs) {

            $(".validation-message").html(msgs);
        }
    </script>
@endsection
