@extends('admin.layout')

@section('styles')
 
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/inbox/admin/css/bootstrap-toggle.min.css')}}">

@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Inbox Account Add</h4>
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
        <a href="#">Inbox</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Inbox Account Add</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Inbox Account Add</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.inboxwebmails')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="tile">
                    <form id="ajaxForm" action="{{route('admin.inboxwebmail.post')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">

                            <?php 

                                $serverName = (new \App\EmailServer)->getEmailServerDropdown();
                            ?>

                            <div class="col-lg-12">
                                
                                <div class="form-group">
                                    <h5> <label class="col-form-label" for="Title">*Email Server</label> </h5>
                                    <select name="email_server_id" id="email_server_id" class="form-control" required="required">
                                        <option>Select email server</option>
                                        @foreach($serverName as $key=>$v)
                                            <option value="{{ $v->id }}">{{$v->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                
                                <div class="form-group">
                                    <h5> <label class="col-form-label" for="Title">*{{__('Name')}}</label> </h5>
                                    <input class="form-control" type="text" placeholder="Enter sender name"  name="name" required>
                                    <p id="errname" class="mb-0 text-danger em"></p>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                
                                <div class="form-group">
                                    <h5> <label class="col-form-label" for="Title">*{{__('Email')}}</label> </h5>
                                    <input class="form-control" type="email" placeholder="Enter email"  name="email" required>
                                    <p id="erremail" class="mb-0 text-danger em"></p>
                                </div>

                            </div>

                        </div>
                        
                        <div class="form-group">
                            <h5> <label class="col-form-label" for="Title">*{{__('Password')}}</label> </h5>
                            <input class="form-control" type="password" placeholder="Enter password"  name="password" required>
                        </div>

                        <div class="form-group" style="display:none;" id="secondary_password">
                            <h5> <label class="col-form-label" for="Title">*Generated App {{__('Password')}}</label> </h5>
                            <input class="form-control" type="password" placeholder="Enter password"  name="secondary_password">
                        </div>

                        <div class="form-group">
                            <h5>  <label for="exampleInputEmail1">{{__('Email Signature')}}</label></h5>
                            <textarea id="e_sign" class="form-control" placeholder="Enter email signature" type="text" rows="5" name="e_sign" ></textarea>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <h5> <label class="col-form-label" for="active">{{__('Active')}}</label> </h5>
                                    <input  type="checkbox" name="active" data-toggle="toggle"  data-on="yes" data-off="no" data-onstyle="success"  data-offstyle="danger" data-width="100%" checked>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <h5> <label class="col-form-label" for="d_from_server">{{__('Delete From Server')}}</label> </h5>
                                    <input  type="checkbox" name="d_from_server" data-toggle="toggle"  data-on="yes" data-off="no" data-onstyle="success"  data-offstyle="danger" data-width="100%">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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

<script type="text/javascript" src="{{asset('assets/admin/inbox/admin/js/bootstrap-toggle.min.js')}}"></script>

<script>

    
    $(document).on("change","#email_server_id",function(){

        showHideSecondaryPassword();
    });

    function showHideSecondaryPassword(){

        var id = $("#email_server_id").val();

        if (id == {{\App\EmailServer::YAHOO_COSNT}}) {

            $("#secondary_password").show(); 

        }else{

            $("#secondary_password").hide(); 

        } 
    }    

</script>
@endsection


