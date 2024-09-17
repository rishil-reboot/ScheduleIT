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
    <h4 class="page-title">Free Apps Details</h4>
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
        <a href="#">Free Apps </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Free Apps</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Free App </div>
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
                    <a href="{{route('admin.appsection.create') . '?language=' . request()->input('language')}}" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Portfolio</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.appsection.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">

              @if (count($apps) == 0)
                <h3 class="text-center">NO RECORD FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        {{-- <th scope="col">Featured Image</th> --}}
                        <th scope="col">Title</th>
                        <th scope="col">Subtitle</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($apps as $app)
                        <tr>
                            <td>
                                <input type="checkbox" class="bulk-check" data-val="{{$app->id}}">
                            </td>
                          <td>
                            {{$app->title}}
                          </td>

                          <td>
                            {{$app->subtitle}}

                          </td>

                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.appsection.edit',$app->id). '?language=' . request()->input('language')}}">
                            <span class="btn-label">
                              <i class="fas fa-edit"></i>
                            </span>
                            Edit
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.appsection.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="app_id" value="{{$app->id}}">
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
              {{$apps->appends(['language' => request()->input('language')])->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
