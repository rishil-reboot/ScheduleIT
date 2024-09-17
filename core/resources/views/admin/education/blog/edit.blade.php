@extends('admin.layout')

@if(!empty($blog->language) && $blog->language->rtl == 1)
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
<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/select2.min.css')}}">
  <div class="page-header">
    <h4 class="page-title">Edit Article</h4>
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
        <a href="#">Education Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Article</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Article</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.educationBlog.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.educationBlog.uploadUpdate', $blog->id)}}" method="POST">
                @csrf
                <div class="form-row px-2">
                  <div class="col-12 mb-2">
                    <label for=""><strong>Image **</strong></label>
                  </div>
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                    <img src="{{asset('assets/front/img/educationblogs/'.$blog->main_image)}}" alt="..." class="img-thumbnail">
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

              <form id="ajaxForm" class="" action="{{route('admin.educationBlog.update')}}" method="post">
                @csrf
                <input type="hidden" name="blog_id" value="{{$blog->id}}">
                <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group">
                        <label for="">Title **</label>
                        <input type="text" class="form-control" name="title" value="{{$blog->title}}" placeholder="Enter title">
                        <p id="errtitle" class="mb-0 text-danger em"></p>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                        <label for="">Title Font Size </label>
                        <input type="number" class="form-control ltr" name="title_font_size" value="{{$blog->title_font_size}}">
                        <p id="errhero_section_title_font_size" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                           <label for=""> Title Font Style </label>
                           <select class="form-control ltr" name="title_font_style">
                                 <option value="Arial" {{$blog->title_font_style == "Arial" ? 'selected' : ''}}>Arial </option>
                                 <option value="Arial Black" {{$blog->title_font_style == "Arial Black" ? 'selected' : ''}}>Arial Black</option>
                                 <option value="Comic Sans MS" {{$blog->title_font_style == "Comic Sans MS" ? 'selected' : ''}}>Comic Sans MS</option>
                                 <option value="Courier New" {{$blog->title_font_style == "Courier New" ? 'selected' : ''}}>Courier New</option>
                                 <option value="Helvetica" {{$blog->title_font_style == "Helvetica" ? 'selected' : ''}}>Helvetica</option>
                                 <option value="Impact" {{$blog->title_font_style == "Impact" ? 'selected' : ''}}>Impact</option>
                                 <option value="Verdana" {{$blog->title_font_style == "Verdana" ? 'selected' : ''}}>Tahoma</option>
                                 <option value="Times New Roman" {{$blog->title_font_style == "Times New Roman" ? 'selected' : ''}}>Times New Roman</option>
                                 <option value="Verdana" {{$blog->title_font_style == "Verdana" ? 'selected' : ''}}>Verdana</option>
                                 <option value="Lato" {{$blog->title_font_style == "Lato" ? 'selected' : ''}}>Lato </option>
                           </select>
                        </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Category **</label>
                  <select class="form-control" name="category">
                    <option value="" selected disabled>Select a category</option>
                    @foreach ($bcats as $key => $bcat)
                      <option value="{{$bcat->id}}" {{$bcat->id == $blog->educationCategory->id ? 'selected' : ''}}>{{$bcat->name}}</option>
                    @endforeach
                  </select>
                  <p id="errcategory" class="mb-0 text-danger em"></p>
                </div>
                
                <div class="tag_div_section"></div>

                <div class="form-group">
                  <label for="">Content **</label>
                  <textarea class="form-control summernote" name="content" data-height="300" placeholder="Enter content">{{replaceBaseUrl($blog->content)}}</textarea>
                  <p id="errcontent" class="mb-0 text-danger em"></p>
                </div>

               <div class="form-group">
                  <label for="">Publish Date</label>
                  <input type="date" class="form-control" name="publish_at" value="{{ $blog->publish_at }}" placeholder="Select date">
                  <p id="errpublish_at" class="mb-0 text-danger em"></p>
               </div>
               
                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$blog->serial_number}}" placeholder="Enter Serial Number">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning"><small>The higher the serial number is, the later the article will be shown.</small></p>
                </div>

                <div class="form-group">
                   <label for=""> Comment Section </label>
                   <select class="form-control ltr" name="comment_visibility">
                         <option value="1" {{$blog->comment_visibility == "1" ? 'selected' : ''}}>Enable </option>
                         <option value="2" {{$blog->comment_visibility == "2" ? 'selected' : ''}}>Disable</option>
                   </select>
                </div>
                
                <div class="form-group">
                  <label for="">Meta Keywords</label>
                  <input type="text" class="form-control" name="meta_keywords" value="{{$blog->meta_keywords}}" data-role="tagsinput">
                  <p id="errmeta_keywords" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for="">Meta Description</label>
                  <textarea type="text" class="form-control" name="meta_description" rows="5">{{$blog->meta_description}}</textarea>
                  <p id="errmeta_description" class="mb-0 text-danger em"></p>
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
<!-- Include the media selection modal -->
@include('admin.partials.media-selection-modal')
@endsection
@section('scripts')

<script type="text/javascript" src="{{asset('assets/front/js/select2.min.js')}}"></script>
<script>
  
  $(document).ready(function(){

    var blog_id = "{{$blog->id}}";
    $.ajax({
        type:'post',
        url:"{{route('admin.educationBlog.getTagsDropdown')}}",
        data:{"_token": "{{ csrf_token() }}",blog_id:blog_id},
        success:function(data)
        {
         $('.tag_div_section').html(data);
        }
    });
    
  });

</script>
@endsection



