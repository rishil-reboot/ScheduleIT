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
    <h4 class="page-title">Contact Page</h4>
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
        <a href="#">Contact Page</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data" action="{{route('admin.contact.update', $lang_id)}}" method="POST">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card-title">Contact Page</div>
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
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                @csrf
                <div class="form-group">
                  <label>Form Title **</label>
                  <input class="form-control" name="contact_form_title" value="{{$abs->contact_form_title}}" placeholder="Enter Titlte">
                  @if ($errors->has('contact_form_title'))
                    <p class="mb-0 text-danger">{{$errors->first('contact_form_title')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Form Subtitle **</label>
                  <input class="form-control" name="contact_form_subtitle" value="{{$abs->contact_form_subtitle}}" placeholder="Enter Subtitlte">
                  @if ($errors->has('contact_form_subtitle'))
                    <p class="mb-0 text-danger">{{$errors->first('contact_form_subtitle')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Address **</label>
                  <input class="form-control" name="contact_address" value="{{$abs->contact_address}}" placeholder="Enter Address">
                  @if ($errors->has('contact_address'))
                    <p class="mb-0 text-danger">{{$errors->first('contact_address')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Phone **</label>
                  <input class="form-control" name="contact_number" value="{{$abs->contact_number}}" placeholder="Enter Phone Number">
                  @if ($errors->has('contact_number'))
                    <p class="mb-0 text-danger">{{$errors->first('contact_number')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Email **</label>
                  <input class="form-control ltr" name="contact_mail" value="{{$abe->to_mail}}" readonly>
                  <div class="text-warning">You cannot upadate Email Address from here, you can update it from <a class="text-" href="{{route('admin.mailToAdmin')}}"><u>Basic Settings > Email Settings > Mail To Admin</u></a></p></div>
                </div>
                <div class="form-group">
                  <label>Latitude **</label>
                  <input class="form-control ltr" name="latitude" value="{{$abs->latitude}}" placeholder="Enter Latitude">
                  @if ($errors->has('latitude'))
                    <p class="mb-0 text-danger">{{$errors->first('latitude')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label>Longitude **</label>
                  <input class="form-control ltr" name="longitude" value="{{$abs->longitude}}" placeholder="Enter Longitude">
                  @if ($errors->has('longitude'))
                    <p class="mb-0 text-danger">{{$errors->first('longitude')}}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Why Choose Us</div>
                </div>
                <div class="col-lg-3">
                   
                </div>
                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                    <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Why Choose Us</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.contact.whybulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($whychooseus) == 0)
                <h3 class="text-center">NO DATA FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Serial Number</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($whychooseus as $key => $bcategory)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$bcategory->id}}">
                          </td>
                          <td>{{convertUtf8($bcategory->name)}}</td>
                          <td>
                            @if ($bcategory->status == 1)
                              <h2 class="d-inline-block"><span class="badge badge-success">Active</span></h2>
                            @else
                              <h2 class="d-inline-block"><span class="badge badge-danger">Deactive</span></h2>
                            @endif
                          </td>
                          <td>{{$bcategory->serial_number}}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm editbtn" href="#editModal" data-toggle="modal" data-bcategory_id="{{$bcategory->id}}" data-name="{{$bcategory->name}}" data-status="{{$bcategory->status}}" data-description="{!! $bcategory->description !!}" data-serial_number="{{$bcategory->serial_number}}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              Edit
                            </a>
                            <form class="deleteform d-inline-block" action="{{route('admin.contact.whydelete')}}" method="post">
                              @csrf
                              <input type="hidden" name="why_choose_id" value="{{$bcategory->id}}">
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
              {{$whychooseus->appends(['language' => request()->input('language')])->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <!-- Create Tag Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Why Choose Us</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form create" action="{{route('admin.contact.whystore')}}" method="POST">
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
              <label for="">Name **</label>
              <input type="text" class="form-control" name="name" value="" placeholder="Enter name">
              <p id="errname" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
              <label for="">Description</label>
              <textarea class="form-control" name="description" value="" placeholder="Enter short description"></textarea>
              <p id="errdescription" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
              <label for="">Status **</label>
              <select class="form-control ltr" name="status">
                <option value="" selected disabled>Select a status</option>
                <option value="1">Active</option>
                <option value="0">Deactive</option>
              </select>
              <p id="errstatus" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Serial Number **</label>
              <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
              <p id="errserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small>The higher the serial number is, the later the tag will be shown.</small></p>
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

  <!-- Edit Tag Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Why Choose Us</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxEditForm" class="" action="{{route('admin.contact.whyupdate')}}" method="POST">
            @csrf
            <input id="inbcategory_id" type="hidden" name="why_choose_id" value="">
            <div class="form-group">
              <label for="">Name **</label>
              <input id="inname" type="name" class="form-control" name="name" value="" placeholder="Enter name">
              <p id="eerrname" class="mb-0 text-danger em"></p>
            </div>
            
            <div class="form-group">
              <label for="">Description</label>
              <textarea id="indescription" class="form-control" name="description" value="" placeholder="Enter short description"></textarea>
              <p id="eerrdescription" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
              <label for="">Status **</label>
              <select id="instatus" class="form-control" name="status">
                <option value="" selected disabled>Select a status</option>
                <option value="1">Active</option>
                <option value="0">Deactive</option>
              </select>
              <p id="eerrstatus" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Serial Number **</label>
              <input id="inserial_number" type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
              <p id="eerrserial_number" class="mb-0 text-danger em"></p>
              <p class="text-warning"><small>The higher the serial number is, the later the tag will be shown.</small></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="updateBtn" type="button" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

@endsection
