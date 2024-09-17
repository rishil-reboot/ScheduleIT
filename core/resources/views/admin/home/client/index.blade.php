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
  <div class="page-header">
    <h4 class="page-title">Clients</h4>
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
        <a href="#">Clients</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
          <div class="card-title">Title & Subtitle</div>
        </div>

        <form class="" action="{{route('admin.client.updateSection')}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Title **</label>
                  <input class="form-control" name="client_section_title" value="{{$abs->client_section_title}}" placeholder="Enter Title">
                  @if ($errors->has('client_section_title'))
                    <p class="mb-0 text-danger">{{$errors->first('client_section_title')}}</p>
                  @endif
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Subtitle **</label>
                  <input class="form-control" name="client_section_subtitle" value="{{$abs->client_section_subtitle}}" placeholder="Enter Subtitle">
                  @if ($errors->has('client_section_subtitle'))
                    <p class="mb-0 text-danger">{{$errors->first('client_section_subtitle')}}</p>
                  @endif
                </div>
              </div>
               <div class="col-lg-12">
                <div class="form-group">
                  <label>Content </label>
                  <textarea class="form-control summernote" name="client_section_description" data-editor="client_section_description"> {!! $abs->client_section_description !!} </textarea>
                  @if ($errors->has('client_section_description'))
                    <p class="mb-0 text-danger">{{$errors->first('client_section_description')}}</p>
                  @endif
                </div>
              </div>

              <div class="col-lg-6">
                
                <div class="form-group">
                  <label>Meta Keywords</label>
                  <input class="form-control" name="client_meta_keyword" value="{{$bs->client_meta_keyword}}" placeholder="Enter meta keywords" data-role="tagsinput">
                </div>

              </div>

              <div class="col-lg-6">
                
                <div class="form-group">
                  <label>Meta Description</label>
                  <textarea class="form-control" name="client_meta_description" rows="5" placeholder="Enter meta description">{!! $bs->client_meta_description !!}</textarea>
                </div>

              </div>
              
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Clients</div>
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
                    <a href="#" class="btn btn-primary float-lg-right float-left" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Client</a>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              @if (count($partners) == 0)
                <h3 class="text-center">NO CLIENT FOUND</h3>
              @else
                <div class="row">
                  @foreach ($partners as $key => $partner)
                    <div class="col-md-3">
                      <div class="card">
        								<div class="card-body">
                          <img src="{{asset('assets/front/img/client/'.$partner->image)}}" alt="" style="width:100%;">
        								</div>
        								<div class="card-footer text-center">
                          <a class="btn btn-secondary btn-sm mr-2" href="{{route('admin.client.edit', $partner->id) . '?language=' . request()->input('language')}}">
                          <span class="btn-label">
                            <i class="fas fa-edit"></i>
                          </span>
                          Edit
                          </a>
                          <form class="deleteform d-inline-block" action="{{route('admin.client.delete')}}" method="post">
                            @csrf
                            <input type="hidden" name="partner_id" value="{{$partner->id}}">
                            <button type="submit" class="btn btn-danger btn-sm deletebtn">
                              <span class="btn-label">
                                <i class="fas fa-trash"></i>
                              </span>
                              Delete
                            </button>
                          </form>
        								</div>
        							</div>
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Create Partner Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Client</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="mb-3 dm-uploader drag-and-drop-zone modal-form" enctype="multipart/form-data" action="{{route('admin.client.upload')}}" method="POST">
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
                  <p class="em text-danger mb-0" id="errclient_image"></p>
                </div>
              </div>
            </div>
          </form>
          <form id="ajaxForm" class="modal-form" action="{{route('admin.client.store')}}" method="post">
            @csrf
            <input type="hidden" id="image" name="client_image" value="">
            <div class="form-group">
                <label for="">Language **</label>
                <select name="language_id" class="form-control">
                    <option value="" selected disabled>Select a language</option>
                    @foreach ($langs as $lang)
                        <option value="{{$lang->id}}">{{$lang->name}}</option>
                    @endforeach
                </select>
                <p id="errlanguage_id" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
                <label for="">Name **</label>
                <input type="text" name="name" onkeyup="makeslug(this.value)" class="form-control" placeholder="Enter Name">
                <p id="errname" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
              <label for="">URL Slug **</label>
              <input type="text" class="form-control set-slug" name="slug" placeholder="Enter SEO Friendly URL Slug" value="">
              <p id="errslug" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
              <label for="">URL</label>
              <input type="text" class="form-control" name="url" placeholder="Enter URL">
              <p id="errurl" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
              <label for="">Address</label>
              <textarea class="form-control" name="address" placeholder="Enter address"></textarea>
              <p id="erraddress" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
              <label for="">State</label>
              <input type="text" class="form-control" name="state" placeholder="Enter state name">
              <p id="errstate" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
              <label for="">City</label>
              <input type="text" class="form-control" name="city" placeholder="Enter city name">
              <p id="errcity" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
              <label for="">Zipcode</label>
              <input type="text" class="form-control" name="zip" placeholder="Enter zipcode">
              <p id="errzip" class="em text-danger mb-0"></p>
            </div>
            
            <div class="form-group">
                <label for="">Description </label>
                <textarea name="description" class="form-control" placeholder="Enter Description"></textarea>
                <p id="errdescription" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
                <label for="">Long Description </label>
                <textarea name="long_description" class="form-control summernote"  data-editor="long_description" placeholder="Enter Description"></textarea>
                <p id="errlong_description" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
              <label for="">Serial Number **</label>
              <input type="number" class="form-control" name="serial_number" placeholder="Enter Serial Number">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small>The higher the serial number is, the later the client will be shown.</small></p>
            </div>

            <div class="form-group">
              <label>Meta Keywords</label>
              <input class="form-control" name="meta_keyword" value="" placeholder="Enter meta keywords" data-role="tagsinput">
            </div>
            <div class="form-group">
              <label>Meta Description</label>
              <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description"></textarea>
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
@include('admin.partials.media-selection-modal', ['mediaData' => $mediaData])
@endsection

@section('scripts')
<script>
    
    function makeslug(slug) {

      var a = slug;

      var b = a.toLowerCase().replace(/ /g, '-')
          .replace(/[^\w-]+/g, '');

      $(".set-slug").val(b);    
    }

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
