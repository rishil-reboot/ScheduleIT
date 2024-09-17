@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Customers</h4>
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
        <a href="#">Add Customer</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Customers</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Add Customer</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.register.user')}}">
						<span class="btn-label">
							<i class="fas fa-backward" style="font-size: 12px;"></i>
						</span>
						Back
					</a>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-10 offset-lg-1">
              
              <form id="ajaxForm" action="{{route('admin.register.user.store')}}" method="post">
                @csrf
                <fieldset>
                  <h2>Customer Details</h2>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">First Name</label>
                        <input type="text" name="fname" class="form-control" placeholder="Enter First Name" value="">
                        <p id="errfname" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" name="lname" class="form-control" placeholder="Enter Last Name" value="">
                        <p id="errlname" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Username **</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter User Name" value="">
                        <p id="errusername" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Email **</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email Address" value="">
                        <p id="erremail" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Password **</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password" value="">
                        <p id="errpassword" class="em text-danger mb-0"></p>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Confirm Password **</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Re-Enter Password" value="">
                        <p id="errpassword_confirmation" class="em text-danger mb-0"></p>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Number</label>
                        <input type="text" name="number" class="form-control" placeholder="Enter Number" value="">
                        <p id="errnumber" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Status **</label>
                        <select class="form-control ltr" name="status">
                          <option value="1">Active</option>
                          <option value="0">Deactive</option>
                        </select>
                        <p id="errstatus" class="em text-danger mb-0"></p>
                      </div>
                    </div>


                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Country</label>
                        <input type="text" name="country" class="form-control" placeholder="Enter Country Name" value="">
                        <p id="errcountry" class="em text-danger mb-0"></p>
                      </div>
                    </div>


                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">State</label>
                        <input type="text" name="state" class="form-control" placeholder="Enter State Name" value="">
                        <p id="errstate" class="em text-danger mb-0"></p>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">City</label>
                        <input type="text" name="city" class="form-control" placeholder="Enter City Name" value="">
                        <p id="errcity" class="em text-danger mb-0"></p>
                      </div>
                    </div>


                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Address</label>
                        <textarea class="form-control" name="address" placeholder="Enter Address"></textarea>
                        <p id="erraddress" class="em text-danger mb-0"></p>
                      </div>
                    </div>

                  </div>
                </fieldset>
                
                <fieldset>
                  <h2>Shipping Details</h2>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">First Name</label>
                        <input type="text" name="shpping_fname" class="form-control" placeholder="Enter First Name" value="">
                        <p id="errshpping_fname" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" name="shpping_lname" class="form-control" placeholder="Enter Last Name" value="">
                        <p id="errshpping_lname" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="shpping_email" class="form-control" placeholder="Enter Email" value="">
                        <p id="errshpping_email" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="shpping_number" class="form-control" placeholder="Enter Phone Number" value="">
                        <p id="errshpping_number" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Country</label>
                        <input type="text" name="shpping_country" class="form-control" placeholder="Enter Country Name" value="">
                        <p id="errshpping_country" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">State</label>
                        <input type="text" name="shpping_state" class="form-control" placeholder="Enter State Name" value="">
                        <p id="errshpping_state" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">City</label>
                        <input type="text" name="shpping_city" class="form-control" placeholder="Enter City Name" value="">
                        <p id="errshpping_city" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Address</label>
                        <textarea class="form-control" name="shpping_address" placeholder="Enter Shipping Address"></textarea>
                        <p id="errshpping_address" class="em text-danger mb-0"></p>
                      </div>
                    </div>

                  </div>
                </fieldset>

                <fieldset>
                  <h2>Billing Details</h2>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">First Name</label>
                        <input type="text" name="billing_fname" class="form-control" placeholder="Enter First Name" value="">
                        <p id="errbilling_fname" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" name="billing_lname" class="form-control" placeholder="Enter Last Name" value="">
                        <p id="errbilling_lname" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="billing_email" class="form-control" placeholder="Enter Email" value="">
                        <p id="errbilling_email" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Phone</label>
                        <input type="text" name="billing_number" class="form-control" placeholder="Enter Phone Number" value="">
                        <p id="errbilling_number" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Country</label>
                        <input type="text" name="billing_country" class="form-control" placeholder="Enter Country Name" value="">
                        <p id="errbilling_country" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">State</label>
                        <input type="text" name="billing_state" class="form-control" placeholder="Enter State Name" value="">
                        <p id="errbilling_state" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">City</label>
                        <input type="text" name="billing_city" class="form-control" placeholder="Enter City Name" value="">
                        <p id="errbilling_city" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Address</label>
                        <textarea class="form-control" name="billing_address" placeholder="Enter Shipping Address"></textarea>
                        <p id="errbilling_address" class="em text-danger mb-0"></p>
                      </div>
                    </div>
                    
                  </div>
                </fieldset>

              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success">Create</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

