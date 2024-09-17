@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Features</h4>
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
        <a href="#">Features</a>
      </li>
    </ul>
  </div>

  <div class="card-body">
    <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.statistics.upload', $lang_id)}}" method="POST">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="form-row">
                    <div class="col-12 mb-2">
                        <label for=""><strong>Background Image **</strong></label>
                    </div>
                    <div class="col-md-6 d-md-block mb-3">
                        {{-- @if (!empty($abe->statistics_bg)) --}}
                            {{-- <img src="{{asset('assets/front/img/'.$abe->statistics_bg)}}" alt="..." class="img-thumbnail"> --}}
                        {{-- @else --}}
                            <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="..." class="img-thumbnail">
                        {{-- @endif --}}
                    </div>
                    <div class="col-md-12">
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
                            <p class="text-warning mb-0">Only jpg, jpeg, png image is allowed.</p>
                            <p class="text-danger mb-0 em" id="errstatistics_bg"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>








  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Features</div>
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
                    <a href="#" class="btn btn-primary float-lg-right float-left" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Feature</a>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($features) == 0)
                <h3 class="text-center">NO FEATURE FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Title</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($features as $key => $feature)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td><i class="{{ $feature->icon }}"></i></td>
                          <td>{{convertUtf8($feature->title)}}</td>
                          <td>{{$feature->serial_number}}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm" href="{{route('admin.feature.edit', $feature->id) . '?language=' . request()->input('language')}}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              Edit
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.feature.delete')}}" method="post">
                              @csrf
                              <input type="hidden" name="feature_id" value="{{$feature->id}}">
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


  <!-- Create Feature Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Feature</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form" action="{{route('admin.feature.store')}}" method="post">
            @csrf
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
                <label for="">Page</label>
                <select name="page_id" class="form-control">
                    <option value="" selected disabled>Select a page</option>
                    @if(isset($pages) && !$pages->isEmpty())
                      @foreach ($pages as $page)
                          <option value="{{$page->id}}">{{$page->title}}</option>
                      @endforeach
                    @endif
                </select>
                <p id="errlanguage_id" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Icon **</label>
              <div class="btn-group d-block">
                  <button type="button" class="btn btn-primary iconpicker-component"><i
                          class="fa fa-fw fa-heart"></i></button>
                  <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                          data-selected="fa-car" data-toggle="dropdown">
                  </button>
                  <div class="dropdown-menu"></div>
              </div>
              <input id="inputIcon" type="hidden" name="icon" value="fas fa-heart">
              @if ($errors->has('icon'))
                <p class="mb-0 text-danger">{{$errors->first('icon')}}</p>
              @endif
              <div class="mt-2">
                <small>NB: click on the dropdown sign to select a icon.</small>
              </div>
              <p id="erricon" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Title **</label>
              <input class="form-control" name="title" placeholder="Enter title">
              <p id="errtitle" class="mb-0 text-danger em"></p>
            </div>
            @if (getVersion($be->theme_version) != 'car')
                <div class="form-group">
                    <label>Color **</label>
                    <input class="jscolor form-control ltr" name="color" value="">
                    <p id="errcolor" class="mb-0 text-danger em"></p>
                </div>
            @endif
            <div class="form-group">
              <label for="">Serial Number **</label>
              <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small>The higher the serial number is, the later the feature will be shown.</small></p>
            </div>

           <div class="form-group">
              <label>External Link</label>
              <input class="form-control" type="text" name="external_link" value="" placeholder="Enter external link">
              <p id="errexternal_link" class="mb-0 text-danger em"></p>
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
  <script>
    $(document).ready(function() {
        $('.icp').on('iconpickerSelected', function(event){
            $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
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
                    $("form .nicEdit-main").each(function() {
                        $(this).addClass('rtl text-right');
                    });

                } else {
                    $("form input, form select, form textarea").removeClass('rtl');
                    $("form .nicEdit-main").removeClass('rtl text-right');
                }
            })
        });

    });
  </script>
@endsection
