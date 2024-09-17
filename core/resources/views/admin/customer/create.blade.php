<!-- Create Gallery Modal -->
{{-- @php
$roles = Role::all();
foreach ($variable as $key => $value) {
    # code...
}
@endphp --}}
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
          <form id="ajaxForm" class="" action="{{route('admin.customers.store')}}" method="POST">
            @csrf
            <input type="hidden" id="role_id" name="role_id" value="">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="">First Name **</label>
                  <input type="text" class="form-control" name="first_name" placeholder="Enter First name" value="">
                  <p id="errfirst_name" class="mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="">Last Name **</label>
                  <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" value="">
                  <p id="errlast_name" class="mb-0 text-danger em"></p>
                </div>
              </div>

            </div>
            <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">Email **</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter email" value="">
                    <p id="erremail" class="mb-0 text-danger em"></p>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Contact number **</label>
                        <input type="tel" class="form-control" name="phone_number" placeholder="Enter Phone number" value="" >
                        <p id="errphone_number" class="mb-0 text-danger em"></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Address **</label>
                        <textarea name="address" id=""  rows="3" class="form-control"></textarea>
                        <p id="erraddress" class="mb-0 text-danger em"></p>
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
                  <label for="">Re-type Password **</label>
                  <input type="password" class="form-control" name="password_confirmation" placeholder="Enter your password again" value="">
                  <p id="errpassword_confirmation" class="mb-0 text-danger em"></p>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">Industry Type **</label>
                    <input type="text" class="form-control" name="industry_type" placeholder="Enter your Industry type" value="">
                    <p id="errindustry_type" class="mb-0 text-danger em"></p>
                  </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                      <label for=""> Type **</label>
                      <select class="form-control" name="status">
                        <option value="" selected disabled>Select type</option>
                        <option value="Individual">Individual</option>
                        <option value="Company">Company</option>
                      </select>
                      <p id="errindustry_type" class="mb-0 text-danger em"></p>
                    </div>
                  </div>

            </div>

            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="">Established year**</label>
                  <input type="text" class="form-control" name="establised_year" placeholder="Enter years of established year" value="">
                  <p id="errestablised_year" class="mb-0 text-danger em"></p>
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
