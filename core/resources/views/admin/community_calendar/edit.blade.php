@extends('admin.layout')

@section('styles')
  @if(!empty($communityCalendar->language) && $communityCalendar->language->rtl == 1)
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
  @endif

<link rel="stylesheet" type="text/css" href="{{asset('assets/front/css/select2.min.css')}}">

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
       <form action="{{route('admin.communityCalendar.update')}}" method="post">
          <input type="hidden" name="calandar_id" value="{{$communityCalendar->id}}">
          <div class="card-header">
            <div class="card-title d-inline-block">Edit Calendar</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.communityCalendar.index')}}">
							<span class="btn-label">
								<i class="fas fa-backward" style="font-size: 12px;"></i>
							</span>
							Back
						</a>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              @csrf
              <input type="hidden" name="calendar_id" value="{{$communityCalendar->id}}">
              <div class="col-lg-6 offset-lg-3">
                  <div class="form-group">
                    <label for="">Name **</label>
                    <input class="form-control" name="name" placeholder="Enter name" value="{{$communityCalendar->name}}">
                    @if($errors->has('name'))
                      <p class="mb-0 text-danger">{{$errors->first('name')}}</p>
                    @endif
                  </div>
              </div>

              <div class="col-lg-6 offset-lg-3">
                  <div class="form-group">
                    <label for="slug">URL Slug **</label>
                    <input type="text" class="form-control set-slug" name="slug" placeholder="Enter SEO Friendly URL Slug" value="{{$communityCalendar->slug}}">
                    @if($errors->has('slug'))
                      <p class="mb-0 text-danger">{{$errors->first('slug')}}</p>
                    @endif
                  </div>
              </div>

              <div class="col-lg-6 offset-lg-3">
                <div class="form-group">
                  <label for="mode">View Mode **</label>
                  <select name="view" class="form-control" id="view">
                      <option value="1" @if($communityCalendar->view == 1) selected @endif>Public</option>
                      <option value="2" @if($communityCalendar->view == 2) selected @endif>Private</option>
                  </select>
                  <p id="errview" class="em text-danger mb-0"></p>
                </div>
              </div>

              <?php 
                
                $calendarEvent = $communityCalendar->addedEvents->pluck('calendar_event_id')->toArray(); 

              ?>
              <div class="col-lg-6 offset-lg-3">
                  <div class="form-group">
                    <label for="">Event</label>
                    <select name="event_id[]" class="form-control" id="event_id" multiple="multiple">
                      @if(!$calendarEvents->isEmpty())
                        @foreach($calendarEvents as $key=>$v)
                          <option @if(in_array($v->id,$calendarEvent)) selected @endif value="{{$v->id}}">{{$v->title}}</option>
                        @endforeach
                      @endif
                    </select>
                    <p id="errevent_id" class="em text-danger mb-0"></p>
                  </div>
              </div>

              <div class="col-lg-6 offset-lg-3">
                <div class="form-group">
                  <label>Meta Title</label>
                  <input class="form-control" name="meta_title" value="{{$communityCalendar->meta_title}}" placeholder="Enter meta title">
                </div>
                <div class="form-group">
                  <label>Meta Keywords</label>
                  <input class="form-control" name="meta_keywords" value="{{$communityCalendar->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                </div>
                <div class="form-group">
                  <label>Meta Description</label>
                  <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$communityCalendar->meta_description}}
                  </textarea>
                </div>
              </div>

            </div>
          </div>
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection


@section('scripts')

<script type="text/javascript" src="{{asset('assets/front/js/select2.min.js')}}"></script>

<script>
      
  $("#event_id").select2({

    placeholder:"Select Calendar Event"

  });  

</script>
@endsection
