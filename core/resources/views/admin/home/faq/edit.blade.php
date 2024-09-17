@extends('admin.layout')

@if(!empty($faq->language) && $faq->language->rtl == 1)
@section('styles')
<style>
   form input,
   form textarea,
   form select {
   direction: rtl;
   }
   form .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
<div class="page-header">
   <h4 class="page-title">Edit Faqs</h4>
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
         <a href="#">Faqs</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">Edit Faqs</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="card-title d-inline-block">Edit Faqs</div>
            @if ($faq->language_id > 0)
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('admin.faq.index') . '?language=' . request()->input('language') }}">
            <span class="btn-label">
            <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
            </a>
            @else
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('admin.faq.index') }}">
            <span class="btn-label">
            <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
            </a>
            @endif
         </div>
         <div class="card-body pt-5 pb-5">
            <div class="row">
               <div class="col-lg-6 offset-lg-3">
                  <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.faq.uploadUpdate', $faq->id)}}" method="POST">
                     @csrf
                     <div class="form-row px-2">
                        <div class="col-12 mb-2">
                           <label for=""><strong>Image **</strong></label>
                        </div>
                        <div class="col-md-12 d-md-block d-sm-none mb-3">
                           <img src="{{asset('assets/front/img/faq/'.$faq->image)}}" alt="..." class="img-thumbnail">
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
                  <form id="ajaxForm" class="" action="{{route('admin.faq.update')}}" method="post">
                     @csrf
                     <input type="hidden" name="faq_id" value="{{$faq->id}}">
                      <div class="form-group">
                       <label for="">Question **</label>
                       <input id="inquestion" type="text" class="form-control" name="question" value="{{$faq->question}}" placeholder="Enter question">
                       <p id="eerrquestion" class="mb-0 text-danger em"></p>
                     </div>
                     <div class="form-group">
                       <label for="">Answer **</label>
                       <textarea id="inanswer" class="form-control" name="answer" rows="5" cols="80" placeholder="Enter answer">{{$faq->answer}}</textarea>
                       <p id="eerranswer" class="mb-0 text-danger em"></p>
                     </div>
                     <div class="form-group">
                       <label for="">Serial Number **</label>
                       <input id="inserial_number" type="number" class="form-control ltr" name="serial_number" value="{{$faq->serial_number}}" placeholder="Enter Serial Number">
                       <p id="eerrserial_number" class="mb-0 text-danger em"></p>
                       <p class="text-warning"><small>The higher the serial number is, the later the FAQ will be shown.</small></p>
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
    function toggleDetails() {
        let val = $("input[name='details_page_status']:checked").val();

        // if 'details page' is 'enable', then show 'content' & hide 'summary'
        if (val == 1) {
            $("#contentFg").show();
        }
        // if 'details page' is 'disable', then show 'summary' & hide 'content'
        else if (val == 0) {
            $("#contentFg").hide();
        }
    }

    $(document).ready(function() {
        toggleDetails();

        $("input[name='details_page_status']").on('change', function() {
            toggleDetails();
        });
    });
</script>
@endsection
