@extends('admin.layout')

@section('content')
<div class="page-header">
   <h4 class="page-title">Fill App Details</h4>
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
         <a href="#"> App Details Page</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">App Details</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="card-title d-inline-block"> App Details</div>
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
                     <form action="{{route('admin.appsection.sliderstore')}}" id="my-dropzone" enctype="multipart/formdata" class="dropzone create">
                        @csrf
                        <div class="fallback">
                           <input name="file" type="file" multiple  />
                        </div>
                     </form>
                     <p class="em text-danger mb-0" id="errslider_images"></p>
                  </div>
                  {{-- Featured image upload end --}}
                  <form id="ajaxForm" class="" action="" method="post">
                     {{-- @csrf --}}
                     <input type="hidden" id="image" name="" value="">
                     <div id="sliders"></div>
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Language **</label>
                              <select id="language" name="language_id" class="form-control">
                                 <option value="" selected disabled>Select a language</option>
                                 @foreach ($langs as $lang)
                                 <option value="{{$lang->id}}">{{$lang->name}}</option>
                                 @endforeach
                              </select>
                              <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">Title **</label>
                              <input type="text" class="form-control" name="title" value="" placeholder="Enter title" required>
                              <p id="errtitle" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label for="">Subtitle **</label>
                              <input type="text" class="form-control" name="subtitle" value="" placeholder="Enter title" required>
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
                     <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Include the media selection modal -->
@include('admin.partials.media-selection-modal')
@endsection
@section('scripts')


<script>
   $(document).ready(function() {
       // services load according to language selection


       $("select[name='language_id']").on('change', function() {
           $(".request-loader").addClass("show");
           let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
           console.log(url);
           $.get(url, function(data) {
               $(".request-loader").removeClass("show");
               if (data == 1) {
                   $("form input").each(function() {
                       if (!$(this).hasClass('ltr')) {
                           $(this).addClass('rtl');
                       }
                   });
                   $("form select").each(function() {
                       if (!$(this).hasClass('ltr')) {
                           $(this).addClass('rtl');
                       }
                   });
                   $("form textarea").each(function() {
                       if (!$(this).hasClass('ltr')) {
                           $(this).addClass('rtl');
                       }
                   });
                   $("form .summernote").each(function() {
                       $(this).siblings('.note-editor').find('.note-editable').addClass('rtl text-right');
                   });
               } else {
                   $("form input, form select, form textarea").removeClass('rtl');
                   $("form .summernote").siblings('.note-editor').find('.note-editable').removeClass('rtl text-right');
               }
           })
       });

       // translatable portfolios will be available if the selected language is not 'Default'
       $("#language").on('change', function() {
           let language = $(this).val();
           // console.log(language);
           if (language == 0) {
               $("#translatable").attr('disabled', true);
           } else {
               $("#translatable").removeAttr('disabled');
           }
       });
   });


   // myDropzone is the configuration for the element that has an id attribute
   // with the value my-dropzone (or myDropzone)
   Dropzone.options.myDropzone = {
  acceptedFiles: '.png, .jpg, .jpeg',
  url: "{{ route('admin.appsection.sliderstore') }}",
  autoProcessQueue: false,
  init: function() {
    var myDropzone = this;

    $('#submitBtn').on('click', function(e) {
      e.preventDefault();

      // Ajax call to store function
      $.ajax({
        url: "{{ route('admin.appsection.store') }}",
        type: "POST",
        data: $('#ajaxForm').serialize(),
        success: function(response) {
          if (response.status === 'success') {
            var freeAppSectionId = response.free_app_section_id;

            myDropzone.on("sending", function(file, xhr, formData) {
              formData.append("app_id", freeAppSectionId);
            });

            myDropzone.processQueue();

            // Success notification for form submission
            var content = {};
            content.message = 'Free app section added successfully!';
            content.title = 'Success';
            content.icon = 'fa fa-bell';

            $.notify(content, {
              type: 'success',
              placement: {
                from: 'top',
                align: 'right'
              },
              time: 1000,
              delay: 0,
            });
          } else {
            console.log(response);
          }
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    });

    myDropzone.on("success", function(file, response) {
      if (response.status === 'success') {
        $("#sliders").append(
          `<input type="hidden" name="slider_images[]" id="slider${response.file_id}" value="${response.file_id}">`
        );

        var removeButton = Dropzone.createElement("<button class='rmv-btn'><i class='fa fa-times'></i></button>");
        var _this = this;


        removeButton.addEventListener("click", function(e) {
          e.preventDefault();
          e.stopPropagation();

          _this.removeFile(file);
          rmvimg(response.file_id);
        });

        file.previewElement.appendChild(removeButton);
      } else {
        console.log(response);
      }
    });


    myDropzone.on("queuecomplete", function() {
      var content = {};
      content.message = 'Slider images added successfully!';
      content.title = 'Success';
      content.icon = 'fa fa-bell';

      $.notify(content, {
        type: 'success',
        placement: {
          from: 'top',
          align: 'right'
        },
        time: 1000,
        delay: 0,
      });


      setTimeout(function() {
        location.reload();
      }, 2000);
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
             $("#slider"+fileid).remove();
           }
         });

   }



</script>
@endsection
