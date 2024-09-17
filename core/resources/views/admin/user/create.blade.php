<!-- Create Gallery Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Create User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ajaxForm" class="" action="{{route('admin.user.store')}}" method="POST">
          @csrf
          <input type="hidden" id="image" name="" value="">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Full Name **</label>
                <input type="text" class="form-control" name="full_name" placeholder="Enter your full name" value="">
                <p id="errusername" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Email **</label>
                <input type="text" class="form-control" name="email" placeholder="Enter email" value="">
                <p id="erremail" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Password **</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password" value="">
                <p id="errpassword" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Re-type Password **</labelc:\laragon\www\01-app-landing-page-defoult\sign-up.html>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Enter your password again" value="">
                <p id="errpassword_confirmation" class="mb-0 text-danger em"></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Role **</label>
                <select class="form-control" name="role">
                  <option value="" selected disabled>Select a Role</option>
                  @foreach ($roles as $key => $role)
                  <option value="{{$role->id}}">{{$role->name}}</option>
                  @endforeach
                </select>
                <p id="errrole" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <label for="">Specialization **</label>
                  <input type="text" class="form-control" name="specialization" placeholder="Enter your specialization" value="">
                  <p id="errspecialization" class="mb-0 text-danger em"></p>
                </div>
              </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="">Experience years **</label>
                <input type="text" class="form-control" name="experience_years" placeholder="Enter years of experience" value="">
                <p id="errexperience_years" class="mb-0 text-danger em"></p>
              </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="">Availability Status **</label>
                    <select class="form-control" name="role">
                        <option value="" selected disabled>Select a status</option>
                        <option value="1">Yes</option>
                        <option value="2">No</option>
                      </select>
                    <p id="errexperience_years" class="mb-0 text-danger em"></p>
                </div>
            </div>

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
