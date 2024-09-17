@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Breadcrumb</h4>
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
        <a href="#">Basic Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Breadcrumb</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card-title">Update Breadcrumb</div>
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

               <div class="col-lg-12">
               <form action="{{route('admin.breadcrumb.updateBreadcrumbSetting',$lang_id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="row">
                      
                      <div class="col-md-12">
                        <div class="form-group">
                            <label style="margin-right:20px">Breadcrumb Type</label>
                            <label class="radio-inline"><input type="radio" name="breadcum_type" value="1" class="breadcum_type_class" {{ ($abs->breadcum_type == 1) ? "checked" : "" }}  > Image </label>&nbsp;&nbsp;
                            <label class="radio-inline"><input type="radio" name="breadcum_type" value="2" class="media_type_class" {{ ($abs->breadcum_type == 2) ? "checked" : "" }} > Video </label>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Background Video</label>
                          <input type="file" name="breadcum_video" class="form-control">
                          @if ($errors->has('breadcum_video'))
                            <p class="mb-0 text-danger">{{$errors->first('breadcum_video')}}</p>
                          @endif

                          @if(isset($bs->breadcum_video)  && file_exists(getBreadcumVideoPath().'/'.$bs->breadcum_video))
                            
                            <div class="rmClass">
                              
                              <a class="download-btn" target="_blank" href="{{asset('assets/front/img/breadcrumb/')}}/{{$bs->breadcum_video}}">View</a> | 
                   
                              <a href="javascript:void(0)" data-id="{{ $bs->id }}" class="removeMedia"><i class="fa fa-remove" style="font-size:48px;color:red"></i> Remove</a>
                              
                            </div>
                          @endif

                        </div>
                      </div>
                      <?php 

                        $myTheme = \App\MyThemeVersion::where('status',1)->get();

                      ?>
                      
                      @if(isset($myTheme) && !$myTheme->isEmpty())

                          @foreach($myTheme as $key=>$v)

                            <div class="col-md-6">
                              <div class="form-group">
                                
                                <label>{{$v->name}} Theme Breadcrumb Padding</label>
                                <input type="text" name="padding[{{$v->id}}]" value="{{$v->padding}}" class="form-control" placeholder="Ex: 10px 0px 0px 10px">
                                @if($errors->has('padding'))
                                  <p class="mb-0 text-danger">{{$errors->first('padding')}}</p>
                                @endif
                                Postion:- Top Left Bottom Right 
                              </div> 
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                
                                <label>{{$v->name}} Breadcrumb Padding (Dashboard)</label>
                                <input type="text" name="dashboard_padding[{{$v->id}}]" value="{{$v->dashboard_padding}}" class="form-control" placeholder="Ex: 10px 0px 0px 10px">
                                @if($errors->has('dashboard_padding'))
                                  <p class="mb-0 text-danger">{{$errors->first('dashboard_padding')}}</p>
                                @endif
                                Postion:- Top Left Bottom Right 
                              </div> 
                            </div>

                          @endforeach

                      @endif

                  </div>
                </div>
                <div class="card-footer">
                  <div class="form">
                    <div class="form-group from-show-notify row">
                      <div class="col-lg-6 offset-lg-1 text-center">
                        <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>

             <div class="col-lg-12">
              <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.breadcrumb.update', $lang_id)}}" method="POST">
                <div class="form-row">
                  <div class="col-md-12 d-md-block d-sm-none mb-3">
                    @if (!empty($abs->breadcrumb))
                        <img src="{{asset('assets/front/img/'.$abs->breadcrumb)}}" alt="..." class="img-thumbnail">
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
                        <input type="file" title='Click to add Files' name="breadcrumb" />
                      </div>
                      <small class="status text-muted">Select a file or drag it over this area..</small>
                      <p class="text-warning mb-0">Only jpg, jpeg, png image is allowed.</p>
                      <p class="text-danger mb-0 em" id="errbreadcrumb"></p>
                    </div>
                  </div>
                </div>
              </form>

            </div>

           
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script>
    
    $(document).on("click",".removeMedia",function(){

      if (confirm('Are you sure you want to delete ?')) {
       
        var id  = $(this).attr('data-id');

        $.ajax({
           type:'POST', 
           url:"{{route('admin.breadcrumb.deletemedia')}}",
           data:{"_token": "{{ csrf_token() }}",'id':id},
           success:function(data)
           {
              $('.rmClass').empty();
           }
        });

      } 
    });

</script>
@endsection

