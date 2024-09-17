@extends('admin.layout')

@php
$selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp
@if(!empty($selLang) && $selLang->rtl == 1)
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
<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/select2.min.css')}}">
<div class="page-header">
   <h4 class="page-title">Articles</h4>
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
         <a href="#">Articles</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-lg-4">
                  <div class="card-title d-inline-block">Articles</div>
               </div>
               <div class="col-lg-3">
                  @if (!empty($langs))
                  <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                     <option value="" selected disabled>Select a Language</option>
                     @foreach ($langs as $lang)
                     <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                     @endforeach
                  </select>
                  @endif
               </div>
               <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                  <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Article</a>
                  <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.educationBlog.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-lg-12">
                  @if (count($blogs) == 0)
                  <h3 class="text-center">NO ARTICLE FOUND</h3>
                  @else
                  <div class="table-responsive">
                     <table class="table table-striped mt-3">
                        <thead>
                           <tr>
                              <th scope="col">
                                 <input type="checkbox" class="bulk-check" data-val="all">
                              </th>
                              <th scope="col">Image</th>
                              <th scope="col">Category</th>
                              <th scope="col">Title</th>
                              <th scope="col">Publish Date</th>
                              <th scope="col">Serial Number</th>
                              <th scope="col">Actions</th>
                           </tr>
                        </thead>
                        <tbody>

                           @foreach ($blogs as $key => $blog)
                           <tr>
                              <td>
                                 <input type="checkbox" class="bulk-check" data-val="{{$blog->id}}">
                              </td>
                              <td><img src="{{asset('assets/front/img/educationblogs/'.$blog->main_image)}}" alt="" width="80"></td>
                              <td>{{convertUtf8($blog->educationCategory->name)}}</td>
                              <td>{{convertUtf8(strlen($blog->title)) > 30 ? convertUtf8(substr($blog->title, 0, 30)) . '...' : convertUtf8($blog->title)}}</td>
                              <td>
                                 @php
                                    if($blog->publish_at !=null){

                                       $date = \Carbon\Carbon::parse($blog->publish_at);
                                       $dateTime = $date->translatedFormat('jS F, Y');    
                                    }else{

                                       $dateTime = "";
                                    }  
                                 @endphp
                                 {{$dateTime}}
                              </td>
                              <td>{{$blog->serial_number}}</td>
                              <td>
                                 <a class="btn btn-secondary btn-sm" href="{{route('admin.educationBlog.edit', $blog->id) . '?language=' . request()->input('language')}}">
                                 <span class="btn-label">
                                 <i class="fas fa-edit"></i>
                                 </span>
                                 Edit
                                 </a>
                                 <form class="deleteform d-inline-block" action="{{route('admin.educationBlog.delete')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{$blog->id}}">
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
         <div class="card-footer">
            <div class="row">
               <div class="d-inline-block mx-auto">
                  {{$blogs->appends(['language' => request()->input('language')])->links()}}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Create Article Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add Article</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="mb-3 dm-uploader drag-and-drop-zone modal-form" enctype="multipart/form-data" action="{{route('admin.educationBlog.upload')}}" method="POST">
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
                           <input type="file" title='Click to add Files' />
                        </div>
                        <small class="status text-muted">Select a file or drag it over this area..</small>
                        <p class="em text-danger mb-0" id="errblog"></p>
                     </div>
                  </div>
               </div>
            </form>
            <form id="ajaxForm" class="modal-form" action="{{route('admin.educationBlog.store')}}" method="POST">
               @csrf
               <input type="hidden" id="image" name="" value="">
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
               <div class="row">
                  <div class="col-lg-4">
                     <div class="form-group">
                        <label for="">Title **</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter title" value="">
                        <p id="errtitle" class="mb-0 text-danger em"></p>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="form-group">
                        <label for="">Title Font Size </label>
                        <input type="number" class="form-control ltr" name="title_font_size">
                        <p id="errhero_section_title_font_size" class="em text-danger mb-0"></p>
                     </div>
                  </div>
                  <div class="col-lg-4">
                        <div class="form-group">
                           <label for=""> Font Style </label>
                           <select class="form-control ltr" name="title_font_style">
                                 <option value="Arial ">Arial </option>
                                 <option value="Arial Black">Arial Black</option>
                                 <option value="Comic Sans MS">Comic Sans MS</option>
                                 <option value="Courier New">Courier New</option>
                                 <option value="Helvetica">Helvetica</option>
                                 <option value="Impact">Impact</option>
                                 <option value="Verdana">Tahoma</option>
                                 <option value="Times New Roman">Times New Roman</option>
                                 <option value="Verdana">Verdana</option>
                                 <option value="Lato">Lato </option>
                           </select>
                        </div>
                  </div>
               </div>
               <div class="form-group">
                  <label for="">Category **</label>
                  <select id="bcategory" class="form-control" name="category" disabled>
                     <option value="" selected disabled>Select a category</option>
                  </select>
                  <p id="errcategory" class="mb-0 text-danger em"></p>
               </div>

               <div class="tag_div_section"></div>   

               <div class="form-group">
                  <label for="">Content **</label>
                  <textarea class="form-control summernote" name="content" rows="8" cols="80" placeholder="Enter content"></textarea>
                  <p id="errcontent" class="mb-0 text-danger em"></p>
               </div>

               <div class="form-group">
                  <label for="">Publish Date</label>
                  <input type="date" class="form-control" name="publish_at" value="" placeholder="Select date">
                  <p id="errpublish_at" class="mb-0 text-danger em"></p>
               </div>

               <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning mb-0"><small>The higher the serial number is, the later the article will be shown.</small></p>
               </div>

               <div class="form-group">
                  <label for=""> Comment Section </label>
                  <select class="form-control ltr" name="comment_visibility">
                        <option value="1">Enable </option>
                        <option value="2" selected="selected">Disable</option>
                  </select>
               </div>

               <div class="form-group">
                  <label for="">Meta Keywords</label>
                  <input type="text" class="form-control" name="meta_keywords" value="" data-role="tagsinput">
               </div>
               <div class="form-group">
                  <label for="">Meta Description</label>
                  <textarea type="text" class="form-control" name="meta_description" rows="5"></textarea>
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
<!-- Include the media selection modal -->
@include('admin.partials.media-selection-modal')
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('assets/front/js/select2.min.js')}}"></script>
<script>

   $(document).ready(function() {
       $("select[name='language_id']").on('change', function() {

           $("#bcategory").removeAttr('disabled');

           let langid = $(this).val();
           let url = "{{url('/')}}/admin/education-blog/" + langid + "/getcats";
           // console.log(url);
           $.get(url, function(data) {
               console.log(data);
               let options = `<option value="" disabled selected>Select a category</option>`;
               for (let i = 0; i < data.length; i++) {
                   options += `<option value="${data[i].id}">${data[i].name}</option>`;
               }
               $("#bcategory").html(options);

           });

            $.ajax({
                type:'post',
                url:"{{route('admin.educationBlog.getTagsDropdown')}}",
                data:{"_token": "{{ csrf_token() }}",langid:langid},
                success:function(data)
                {
                 $('.tag_div_section').html(data);
                }
            });
            
       });

       // make input fields RTL
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
                   $("form.modal-form .summernote").siblings('.note-editor').find('.note-editable').removeClass('rtl text-right');
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
   // console.log('loaded');
</script>
@endsection
