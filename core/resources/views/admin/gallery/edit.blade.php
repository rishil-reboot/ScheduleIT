@extends('admin.layout')

@if(!empty($gallery->language) && $gallery->language->rtl == 1)
@section('styles')
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    .nicEdit-main {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit Media</h4>
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
        <a href="#">Media</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Media</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Media</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.gallery.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              
              <form id="ajaxForm" class="" action="{{route('admin.gallery.update')}}" method="post">
                @csrf
                <input type="hidden" name="gallery_id" value="{{$gallery->id}}">

                <div class="form-group">
                    <label class="radio-inline"><input type="radio" name="media_type" value="1" class="media_type_class" {{ ($gallery->media_type == 1) ? "checked" : "" }}  > Image </label>&nbsp;&nbsp;
                    <label class="radio-inline"><input type="radio" name="media_type" value="2" class="media_type_class" {{ ($gallery->media_type == 2) ? "checked" : "" }} > Doc </label>
                    <label class="radio-inline"><input type="radio" name="media_type" value="3" class="media_type_class" {{ ($gallery->media_type == 3) ? "checked" : "" }} > Video </label>
                    <label class="radio-inline"><input class="media_type_class" type="radio" name="media_type"  value="4" {{ ($gallery->media_type == 4) ? "checked" : "" }}> Audio </label>
                </div>

                <div class="media_type_img" style="display:none">

                    <div class="form-row px-2">
                        <div class="col-md-12 d-md-block d-sm-none mb-3">
                            @if($gallery->image != null)
                                <img src="{{asset('assets/front/img/gallery/'.$gallery->image)}}" alt="..." class="img-thumbnail">
                            @endif
                        </div>
                        <div class="col-sm-12">
                            <div class="from-group mb-2 ">
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
                                <div id="is_img_button">
                                    <div role="button" class="btn btn-primary mr-2 " >
                                        <i class="fa fa-folder-o fa-fw"></i>
                                        <input type="file" name="image" title='Click to add Image' />
                                    </div><br>
                                    <p id="errimage" class="mb-0 text-danger em"></p>
                                    <p class="text-warning"><small>Note. Only Jpg,Png and JPEG files types are allowed.</small></p>
                                </div>
                            </div>                       
                        </div>

                    </div>
                </div>
                    
                <div class="media_type_doc" style="display:none">
                    <div class="form-group"> 
                        <div role="button" class="btn btn-primary mr-2 " >
                            <i class="fa fa-folder-o fa-fw"></i> 
                            <input type="file" name="document_file" title='Click to add Document File'  />
                        </div>
                        @if(!empty($gallery->document_file))
                          <div class="edit_doc_section">
                            <a target="_blank" href="{{asset('assets/front/doc/'.$gallery->document_file)}}">View</a> | <a href="javascript:void(0)" link="{{route('admin.gallery.deleteDocFile',$gallery->id)}}" class="delete_doc">Delete</a>
                          </div>
                        @endif
                        <p id="errdocument_file" class="mb-0 text-danger em"></p>
                        <p class="text-warning"><small>Note. Only .doc , .docx , .odt , .pdf , .tex , .txt , .rtf , .wps , .wks , .wpd files types are allowed.</small></p>
                    </div>      
                   
                </div>

                    <div class="media_type_video" style="display:none">
                        <div class="form-group">
                           <label class="radio-inline"><input  type="radio" name="is_video" value="0" {{ ($gallery->is_video=="0")? "checked" : "" }}> Video Upload</label>&nbsp;&nbsp;
                            <label class="radio-inline"><input  type="radio" name="is_video"  value="1" {{ ($gallery->is_video=="1")? "checked" : "" }}> Video url</label>
                        </div>
                        @if($gallery->is_video == 1)
                            <style type="text/css">
                                #is_video_button{
                                    display: none;
                                }
                            </style>
                            
                        @else
                            <style type="text/css">
                                #is_video_url{
                                    display: none;
                                }
                            </style>
                            
                        @endif
                        
                        <div class="form-group" id="is_video_url"> 
                            <input type="text" class="form-control" name="videoUrl" placeholder="Enter Video Url" value="{{ $gallery->videoUrl}}"> 
                        </div>
                        <div class="form-group"  id="is_video_button">
                            <div class="file btn btn-md btn-primary">
                               <input type="file" name="video_upload"  value="{{$gallery->videoUrl}}" />
                               <input type="hidden" name="previous_video" value="{{$gallery->videoUrl}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input  type="radio" value="0" name="is_thum" {{ ($gallery->is_thum=="0")? "checked" : "" }} > Thumb Upload
                            </label>&nbsp;&nbsp;
                            <label class="radio-inline">
                                <input  type="radio" value="1" name="is_thum" {{ ($gallery->is_thum=="1")? "checked" : "" }} > Thumb url
                            </label>
                        </div>
                        <div class="form-row px-2">
                            <div class="col-12 mb-2">
                                <label for=""><strong>Thumb Image **</strong></label>
                            </div>
                            <div class="col-md-12 d-md-block d-sm-none mb-3">
                                @if($gallery->is_thum == 0)
                                        <style type="text/css">
                                            #is_img_url{display: none;}
                                        </style>
                                    <img src="{{asset('assets/front/img/videos/'.$gallery->main_image)}}" alt="..." class="img-thumbnail">
                                @else
                                    <img src="{{ $gallery->main_image }}" alt="..." class="img-thumbnail">
                                    <style type="text/css">
                                            #is_img_button{display: none;}
                                    </style>
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <div class="from-group mb-2 ">
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
                                    <input name="img_url" type="text" id="is_img_url" class="form-control" value="{{ $gallery->main_image }}">
                                    <div id="is_img_button">
                                        <div role="button" class="btn btn-primary mr-2 " >
                                            <i class="fa fa-folder-o fa-fw"></i>
                                            <input type="file" name="img_upload" title='Click to add Files'  />
                                        </div><br>
                                        <p id="errimg_upload" class="mb-0 text-danger em"></p>
                                        <small class="status text-muted">Select a file or drag it over this area..</small>
                                    </div>
                                </div>                       
                            </div>
                        </div>
                    </div>

                    <div class="media_type_audio" style="display:none">
                        <div class="form-group"> 
                            <div role="button" class="btn btn-primary mr-2 " >
                                Audio File
                                <i class="fa fa-folder-o fa-fw"></i> 
                                <input type="file" name="audio_file" title='Click to add audio file'  />
                            </div>
                            @if(!empty($gallery->audio_file))
                              <div class="edit_audio_section">
                                <a target="_blank" href="{{asset('assets/front/img/audio/'.$gallery->audio_file)}}">View</a> | <a href="javascript:void(0)" link="{{route('admin.gallery.deleteAudioFile',$gallery->id)}}" class="delete_audio">Delete</a>
                              </div>
                            @endif
                            <p id="erraudio_file" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>Note. Only .M4A , .FLAC , .MP3 , .MP4 , .WAV , .WMA , .AAC .</small></p>
                        </div>
                        <div class="form-group"> 
                            <div role="button" class="btn btn-primary mr-2">
                                Thumb Image
                                <i class="fa fa-folder-o fa-fw"></i> 
                                <input type="file" name="audio_thumb" title='Click to add thumb Image'  />
                            </div>
                            <p id="erraudio_image" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>Note. Only Png ,Jpg and JPEG files types are allowed.</small></p>
                        </div>
                    </div>

                    <div class="form-group">
                      <label for="">Title **</label>
                      <input type="text" class="form-control" name="title" value="{{$gallery->title}}" placeholder="Enter title">
                      <p id="errtitle" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                      <label for="">Serial Number **</label>
                      <input type="number" class="form-control ltr" name="serial_number" value="{{$gallery->serial_number}}" placeholder="Enter Serial Number">
                      <p id="errserial_number" class="mb-0 text-danger em"></p>
                      <p class="text-warning"><small>The higher the serial number is, the later the image will be shown.</small></p>
                    </div>

                    <div class="form-group">
                        <label>Meta Keywords</label>
                        <input class="form-control" name="keyword" value="{{$gallery->keyword}}" placeholder="Enter meta keywords" data-role="tagsinput">
                      </div>
                      <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="description" rows="5" placeholder="Enter meta description">{{$gallery->description}}</textarea>
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
<script>
    
$(document).ready(function() {
    
    $(document).on("click",".delete_doc",function(){

        var result = confirm("Are you sure want to delete ?");
        if (result) {
          
              var urlV = $(this).attr('link');

              $.ajax({
               type:'post', 
               url:urlV,
               data:{"_token": "{{ csrf_token() }}"},
               success:function(data)
               {

                  if (data.success == true) {

                    $('.edit_doc_section').html(data.msg);
                  }
               }
            });
        }

    });

    $(document).on("click",".delete_audio",function(){

        var result = confirm("Are you sure want to delete ?");
        if (result) {
          
              var urlV = $(this).attr('link');

              $.ajax({
               type:'post', 
               url:urlV,
               data:{"_token": "{{ csrf_token() }}"},
               success:function(data)
               {

                  if (data.success == true) {

                    $('.edit_audio_section').html(data.msg);
                  }
               }
            });
        }

    });


    $(document).on("change",".media_type_class",function(){

        changeMediaType();
    });

    function changeMediaType(){

        var id = $('.media_type_class:checked').val();

        if(id == 1){

            $(".media_type_img").show();
            $(".media_type_doc").hide();
            $(".media_type_video").hide();
            $(".media_type_audio").hide();

        }else if(id == 2) {

            $(".media_type_img").hide();
            $(".media_type_doc").show();
            $(".media_type_video").hide();
            $(".media_type_audio").hide();

        }else if(id == 3){

            $(".media_type_img").hide();
            $(".media_type_doc").hide();
            $(".media_type_video").show();
            $(".media_type_audio").hide();

        }else if(id == 4){

            $(".media_type_img").hide();
            $(".media_type_doc").hide();
            $(".media_type_video").hide();
            $(".media_type_audio").show();
        }
    }

    changeMediaType();

    $("input[name='is_thum']").change(function(){
        var id = this.value;
        
        if(id==1){
            $("#is_img_button").hide();
            $("#is_img_url").show();
        }else{
            $("#is_img_button").show();
            $("#is_img_url").hide();
        }
    });

    $("input[name='is_video']").change(function(){
        var id = this.value;
        if(id==1){
            $("#is_video_button").hide();
            $("#is_video_url").show();
        }else{
            $("#is_video_url").hide();
            $("#is_video_button").show();
           
        }
    });

});
</script>
@endsection