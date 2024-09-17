@extends('admin.layout')

@if(!empty($page->language) && $page->language->rtl == 1)
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
    <h4 class="page-title">Pages</h4>
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
        <a href="#">Edit Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Pages</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Page</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.page.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-10 offset-lg-1">

              <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.page.uploadUpdate', $page->id)}}" method="POST">
                @csrf
                <div class="form-row px-2">
                  <div class="col-12 mb-2">
                    <label for=""><strong>Image</strong></label>
                  </div>
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                    <img src="{{asset('assets/front/img/page/'.$page->image)}}" alt="..." class="img-thumbnail">
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

              <form id="ajaxForm" action="{{route('admin.page.update')}}" method="post">
                @csrf
                <input type="hidden" name="pageid" value="{{$page->id}}">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Name **</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{$page->name}}">
                      <p id="errname" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Status **</label>
                      <select class="form-control ltr" name="status">
                        <option value="1" {{$page->status == 1 ? 'selected' : ''}}>Active</option>
                        <option value="0" {{$page->status == 0 ? 'selected' : ''}}>Deactive</option>
                      </select>
                      <p id="errstatus" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Title **</label>
                      <input type="text" class="form-control" name="title" placeholder="Enter Title" value="{{$page->title}}">
                      <p id="errtitle" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                    <label for="">Title Font Size </label>
                    <input type="number" class="form-control ltr" name="title_font_size" value="{{$page->title_font_size}}">
                    <p id="errhero_section_title_font_size" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                        <div class="form-group">
                           <label for=""> Title Font Style </label>
                           <select class="form-control ltr" name="title_font_style">
                                 <option value="Arial" {{$page->title_font_style == "Arial" ? 'selected' : ''}}>Arial </option>
                                 <option value="Arial Black" {{$page->title_font_style == "Arial Black" ? 'selected' : ''}}>Arial Black</option>
                                 <option value="Comic Sans MS" {{$page->title_font_style == "Comic Sans MS" ? 'selected' : ''}}>Comic Sans MS</option>
                                 <option value="Courier New" {{$page->title_font_style == "Courier New" ? 'selected' : ''}}>Courier New</option>
                                 <option value="Helvetica" {{$page->title_font_style == "Helvetica" ? 'selected' : ''}}>Helvetica</option>
                                 <option value="Impact" {{$page->title_font_style == "Impact" ? 'selected' : ''}}>Impact</option>
                                 <option value="Verdana" {{$page->title_font_style == "Verdana" ? 'selected' : ''}}>Tahoma</option>
                                 <option value="Times New Roman" {{$page->title_font_style == "Times New Roman" ? 'selected' : ''}}>Times New Roman</option>
                                 <option value="Verdana" {{$page->title_font_style == "Verdana" ? 'selected' : ''}}>Verdana</option>
                                 <option value="Lato" {{$page->title_font_style == "Lato" ? 'selected' : ''}}>Lato </option>
                           </select>
                        </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Subtitle **</label>
                      <input type="text" class="form-control" name="subtitle" placeholder="Enter Subtitle" value="{{$page->subtitle}}">
                      <p id="errsubtitle" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                    <label for="">Subtitle Font Size </label>
                    <input type="number" class="form-control ltr" name="subtitle_font_size" value="{{$page->subtitle_font_size}}">
                    <p id="errhero_section_title_font_size" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                        <div class="form-group">
                           <label for=""> Subtitle Font Style </label>
                           <select class="form-control ltr" name="subtitle_font_style">
                                 <option value="Arial" {{$page->subtitle_font_style == "Arial" ? 'selected' : ''}}>Arial </option>
                                 <option value="Arial Black" {{$page->subtitle_font_style == "Arial Black" ? 'selected' : ''}}>Arial Black</option>
                                 <option value="Comic Sans MS" {{$page->subtitle_font_style == "Comic Sans MS" ? 'selected' : ''}}>Comic Sans MS</option>
                                 <option value="Courier New" {{$page->subtitle_font_style == "Courier New" ? 'selected' : ''}}>Courier New</option>
                                 <option value="Helvetica" {{$page->subtitle_font_style == "Helvetica" ? 'selected' : ''}}>Helvetica</option>
                                 <option value="Impact" {{$page->subtitle_font_style == "Impact" ? 'selected' : ''}}>Impact</option>
                                 <option value="Verdana" {{$page->subtitle_font_style == "Verdana" ? 'selected' : ''}}>Tahoma</option>
                                 <option value="Times New Roman" {{$page->subtitle_font_style == "Times New Roman" ? 'selected' : ''}}>Times New Roman</option>
                                 <option value="Verdana" {{$page->subtitle_font_style == "Verdana" ? 'selected' : ''}}>Verdana</option>
                                 <option value="Lato" {{$page->subtitle_font_style == "Lato" ? 'selected' : ''}}>Lato </option>
                           </select>
                        </div>



                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">URL Slug **</label>
                      <input type="text" class="form-control" name="slug" placeholder="Enter SEO Friendly URL Slug" value="{{$page->slug}}">
                      <p id="errslug" class="em text-danger mb-0"></p>
                    </div>
                  </div>
                  
                </div>
                <div class="form-group">
                  <label for="">Body **</label>
                  <textarea id="body" class="form-control summernote" name="body" data-height="500">{{replaceBaseUrl($page->body)}}</textarea>
                  <p id="errbody" class="em text-danger mb-0"></p>
                </div>

                 <?php  $mediaData = (new \App\Gallery)->getMedaiTypeDropDown(); ?>
               <div class="form-group">
                  <label for="">Media File</label>
                  <select name="gallery_id" id="gallery_id" class="form-control">
                     <option value="">Select media</option>
                     @foreach($mediaData as $key=>$v)
                        <option value="{{$key}}" @if($key == $page->gallery_id) selected @endif>{{$v}}</option>
                     @endforeach
                  </select>
                  <p id="errgallery_id" class="mb-0 text-danger em"></p>
               </div>
               
                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$page->serial_number}}" placeholder="Enter Serial Number">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning"><small>The higher the serial number is, the later the page will be shown in menu.</small></p>
                </div>
                <div class="form-group">
                   <label>Meta Keywords</label>
                   <input class="form-control" name="meta_keywords" value="{{$page->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                </div>
                <div class="form-group">
                   <label>Meta Description</label>
                   <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$page->meta_description}}</textarea>
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
@include('admin.partials.media-selection-modal', ['mediaData' => $mediaData])
@endsection



