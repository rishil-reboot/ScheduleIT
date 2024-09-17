@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit User</h4>
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
        <a href="#">User Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit User</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit User</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.technician.index')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">

              <form id="ajaxForm" class="" action="{{route('admin.technician.update')}}" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{$technician->user->id}}">
                <input type="hidden" id="role_id" name="role_id" value="">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">First Name **</label>
                      <input type="text" class="form-control" name="first_name" placeholder="Enter First name" value="{{$technician->user->first_name}}">
                      <p id="errfirst_name" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Last Name **</label>
                      <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" value="{{$technician->user->last_name}}">
                      <p id="errlast_name" class="mb-0 text-danger em"></p>
                    </div>
                  </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Email **</label>
                        <input type="text" class="form-control" name="email" placeholder="Enter email" value="{{$technician->user->email}}" disabled>
                        <p id="erremail" class="mb-0 text-danger em"></p>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Contact number **</label>
                            <input type="tel" class="form-control" name="phone_number" placeholder="Enter Phone number" value="{{$technician->user->phone_number}}" >
                            <p id="errphone_number" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                          <label for="">Specialization **</label>
                          <input type="text" class="form-control" name="specialization" placeholder="Enter your specialization" value="{{$technician->specialization}}">
                          <p id="errspecialization" class="mb-0 text-danger em"></p>
                        </div>
                      </div>
                      <div class="col-lg-6">
                          <div class="form-group">
                            <label for="">Experience years **</label>
                            <input type="text" class="form-control" name="experience_years" placeholder="Enter years of experience" value="{{$technician->experience_years}}">
                            <p id="errexperience_years" class="mb-0 text-danger em"></p>
                          </div>
                        </div>
                  </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Address **</label>
                            <textarea name="address" id=""  rows="3" class="form-control">{{$technician->user->address}}</textarea>
                            <p id="erraddress" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Status **</label>
                    <select class="form-control" name="availability_status">
                      <option value="" selected disabled>Select a status</option>
                      <option value="1" {{$technician->availability_status == 1 ? 'selected' : ''}}>Active</option>
                      <option value="0" {{$technician->availability_status == 0 ? 'selected' : ''}}>Deactive</option>
                    </select>
                    <p id="errstatus" class="mb-0 text-danger em"></p>
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

@section('scripts')
<script>

  $(document).on("change","#is_change_password",function(){

      var isChecked = $(this).is(":checked");

      if (isChecked == true) {

        $(".password_section").show(1000);

      }else{

        $(".password_section").hide(1000);

      }

  });

</script>
@endsection

