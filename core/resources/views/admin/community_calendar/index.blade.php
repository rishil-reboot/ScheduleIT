@extends('admin.layout')

@php
$selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/daterangepicker.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@if(!empty($selLang) && $selLang->rtl == 1)
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
@endif
@endsection


@section('content')
  <div class="page-header">
    <h4 class="page-title">Calendar</h4>
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
        <a href="#">Calendar</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Calendar</div>
                </div>
                <div class="col-lg-4 offset-lg-4 mt-2 mt-lg-0">
                    <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Calendar</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.communityCalendar.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($communityCalendar) == 0)
                <h3 class="text-center">NO CALENDAR FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Calendar</th>
                        <th scope="col">View Mode</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($communityCalendar as $key => $calendar)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$calendar->id}}">
                          </td>
                          <td>{{convertUtf8(strlen($calendar->name)) > 30 ? convertUtf8(substr($calendar->name, 0, 30)) . '...' : convertUtf8($calendar->name)}}</td>
                          <td>
                            <a href="{{route('admin.communityCalendar.show',$calendar->id)}}" class="btn btn-primary btn-sm editbtn"><i class="fas fa-eye"></i> View </a>
                          </td>
                          <td>

                            @if($calendar->view == 1)
                              <a href="{{route('front.getSingleCalendar',$calendar->slug)}}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Public View </a>
                            @else
                              <a href="javascript:void(0)" class="btn btn-primary btn-sm"><i class="fas fa-lock"></i> Private </a>
                            @endif
                            
                          </td>
                          <td>
                            <a class="btn btn-secondary btn-sm editbtn" href="{{route('admin.communityCalendar.edit',$calendar->id)}}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              Edit
                            </a>

                            <a class="btn btn-secondary btn-sm" href="{{route('admin.communityCalendar.exportCommunityCalendar',$calendar->id)}}">
                              <span class="btn-label">
                                <i class="fas fa-file-export"></i>
                              </span>
                              Export
                            </a>

                            <form class="deleteform d-inline-block" action="{{route('admin.communityCalendar.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="calendar_id" value="{{$calendar->id}}">
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
      </div>
    </div>
  </div>


  <!-- Create Event Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Calendar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form create" action="{{route('admin.communityCalendar.store')}}" method="POST">
            @csrf
            <div class="form-group">
              <label for="">Name **</label>
              <input name="name" class="form-control" onkeyup="makeslug(this.value)" placeholder="Enter Name" type="text" value="">
              <p id="errname" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">URL Slug **</label>
              <input type="text" class="form-control set-slug" name="slug" placeholder="Enter SEO Friendly URL Slug" value="">
              <p id="errslug" class="em text-danger mb-0"></p>
            </div>
            
            <div class="form-group">
              <label for="">Event</label>
              <select name="event_id[]" class="form-control" id="event_id" multiple="multiple">
                @if(!$calendarEvents->isEmpty())
                  @foreach($calendarEvents as $key=>$v)
                    <option value="{{$v->id}}">{{$v->title}}</option>
                  @endforeach
                @endif
              </select>
              <p id="errevent_id" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
              <label for="mode">View Mode **</label>
              <select name="view" class="form-control" id="view">
                  <option value="1">Public</option>
                  <option value="2">Private</option>
              </select>
              <p id="errview" class="em text-danger mb-0"></p>
            </div>

            <div class="form-group">
              <label>Meta Title</label>
              <input class="form-control" name="meta_title" value="" placeholder="Enter meta title">
            </div>
            <div class="form-group">
              <label>Meta Keywords</label>
              <input class="form-control" name="meta_keywords" value="" placeholder="Enter meta keywords" data-role="tagsinput">
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
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
      
  $("#event_id").select2({

    placeholder:"Select Calendar Event",
    width:"100%"

  });  

</script>

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
                    $("form.create input").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.create select").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.create textarea").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.create .nicEdit-main").each(function() {
                        $(this).addClass('rtl text-right');
                    });

                } else {
                    $("form.create input, form.create select, form.create textarea").removeClass('rtl');
                    $("form.create .nicEdit-main").removeClass('rtl text-right');
                }
            })
        });

    });
</script>
@endsection
