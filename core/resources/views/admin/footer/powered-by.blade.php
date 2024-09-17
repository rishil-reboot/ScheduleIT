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
    <h4 class="page-title">Powered By</h4>
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
        <a href="#">Footer</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Powered By</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title">Update Powered By</div>
                </div>
                <div class="col-lg-2">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.powered-by.poweredByUpload', $lang_id)}}" method="POST">
                <div class="form-row">
                  <div class="col-12 mb-2">
                    <label for=""><strong>Powered By **</strong></label>
                  </div>
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                        @if (!empty($abs->powered_by_logo))
                            <img src="{{asset('assets/front/img/'.$abs->powered_by_logo)}}" alt="..." class="img-thumbnail">
                        @else
                            <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="..." class="img-thumbnail">
                        @endif
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
                        <input type="file" title='Click to add Files' name="powered_by_logo" />
                      </div>
                      <small class="status text-muted">Select a file or drag it over this area..</small>
                      <p class="text-warning mb-0 mt-2">Upload 140X55 image for best quality.</p>
                      <p class="text-warning mb-0">Only jpg, jpeg, png image is allowed.</p>
                      <p class="text-danger mb-0 em" id="errpowered_by_logo"></p>
                    </div>
                  </div>
                </div>
              </form>


              <form id="ajaxForm" action="{{route('admin.powered-by.poweredByUpdate', $lang_id)}}" method="post">
                @csrf
                
                <div class="form-group">
                  <label>Powered By Section **</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="powered_by_section" value="1" class="selectgroup-input" {{$abs->powered_by_section == 1 ? 'checked' : ''}}>
                      <span class="selectgroup-button">Active</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="radio" name="powered_by_section" value="0" class="selectgroup-input" {{$abs->powered_by_section == 0 ? 'checked' : ''}}>
                      <span class="selectgroup-button">Deactive</span>
                    </label>
                  </div>
                </div>

                <div class="form-group">
                  <label for="">Powered By Text **</label>
                  <textarea id="powered_by_text" name="powered_by_text" class="summernote form-control" data-editor="powered_by_text" data-height="150">{{replaceBaseUrl($abs->powered_by_text)}}</textarea>
                  <p id="errpowered_by_text" class="em text-danger mb-0"></p>
                </div>

                <div class="form-group">
                  <label for="">URL</label>
                  <input id="powered_by_url" name="powered_by_url" class="form-control" value="{{$abs->powered_by_url}}" />
                  <p id="errpowered_by_url" class="em text-danger mb-0"></p>
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
