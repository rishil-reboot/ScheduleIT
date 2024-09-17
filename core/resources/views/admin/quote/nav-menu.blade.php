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
    <h4 class="page-title">Quote Nav Menu</h4>
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
        <a href="#">Quote Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Quote Nav Menu</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title">Update Quote Nav Menu</div>
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
              
              <form id="ajaxForm" action="{{route('admin.quote.navMenu.update',$lang_id)}}" method="post">
                @csrf
                
                  <div class="form-group">
                      <label>Menu Text</label>
                      <input type="text" class="form-control" name="quote_menu_text" value="{{$abs->quote_menu_text}}" placeholder="Enter quote menu text">
                  </div>

                  <div class="form-group">
                      <label for="">Page</label>
                      <select name="quote_menu_page_id" class="form-control">
                          <option value="" selected disabled>Select a page</option>
                          @if(isset($pages) && !$pages->isEmpty())
                            @foreach ($pages as $page)
                                <option value="{{$page->id}}" @if($abs->quote_menu_page_id == $page->id) selected @endif >{{$page->title}}</option>
                            @endforeach
                          @endif
                      </select>
                      <p id="errlanguage_id" class="mb-0 text-danger em"></p>
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

