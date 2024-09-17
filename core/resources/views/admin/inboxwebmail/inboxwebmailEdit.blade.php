@extends('admin.layout')

@section('styles')
    
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/inbox/admin/css/bootstrap-toggle.min.css')}}">

@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Inbox Account Edit</h4>
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
        <a href="#">Inbox Account Edit</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Inbox Account Edit</div>
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
                    <form id="ajaxForm" action="{{route('admin.inboxwebmail.update', $property->id)}}" method="post" enctype="multipart/form-data">
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
                                            <option value="{{ $v->id }}" @if($property->email_server_id == $v->id) selected @endif>{{$v->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                
                                <div class="form-group">
                                    <h5> <label class="col-form-label" for="Title">*{{__('Name')}}</label> </h5>
                                    <input class="form-control" type="text"  name="name" value="{{strip_tags($property->name)}}" required>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                
                                <div class="form-group">
                                    <h5> <label class="col-form-label" for="Title">*{{__('Email')}}</label> </h5>
                                    <input class="form-control" type="email"  name="email" value="{{strip_tags($property->email)}}" required>
                                </div>

                            </div>

                        </div>



                        <div class="form-group">
                            <h5> <label class="col-form-label" for="Title">*{{__('Password')}}</label> </h5>
                            <input class="form-control" type="password"  name="password" required>
                            <p id="errpassword" class="mb-0 text-danger em"></p>
                        </div>

                        <div class="form-group" style="display:none;" id="secondary_password">
                            <h5> <label class="col-form-label" for="Title">*Generated App {{__('Password')}}</label> </h5>
                            <input class="form-control" type="password" placeholder="Enter password"  name="secondary_password">
                        </div>

                        <div class="form-group">
                            <h5>  <label for="exampleInputEmail1">{{__('Email Signature')}}</label></h5>
                            <textarea id="e_sign" class="form-control" type="text" rows="5" name="e_sign" >{{strip_tags($property->e_sign)}}</textarea>
                        </div>


                        <div class="row">
                            
                            <div class="col-lg-6">
                                
                                <div class="form-group">
                                    <h5> <label class="col-form-label" for="active">{{__('Active')}}</label> </h5>
                                    <input  type="checkbox" name="active" @if($property->active == 1) checked @endif data-toggle="toggle"  data-on="yes" data-off="no" data-onstyle="success"  data-offstyle="danger" data-width="100%">
                                </div>

                            </div>

                            <div class="col-lg-6">
                                
                                <div class="form-group">
                                    <h5> <label class="col-form-label" for="d_from_server">{{__('Delete From Server')}}</label> </h5>
                                    <input  type="checkbox" name="d_from_server" @if($property->d_from_server == 1) checked @endif data-toggle="toggle"  data-on="yes" data-off="no" data-onstyle="success"  data-offstyle="danger" data-width="100%">
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

       <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Create Labels</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.inboxwebmails')}}">
                <span class="btn-label">
                  <i class="fas fa-backward" style="font-size: 12px;"></i>
                </span>
                Back
            </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-12 offset-lg-3">
                <div class="tile">
                    <form action="{{route('admin.inboxwebmail.labels', $property->id)}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                            @csrf
                        <div class="row">
                            <input type="hidden" name="inlbl_del_url" id="inlbl_del_url"
                                   value="{{route('admin.inboxwebmail.label.delete')}}">
                            <div class="form-group col-md-6">
                                <table id="inboxWebmail_table_lbl" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>{{__('Label Name')}}</th>
                                        <th>{{__('Color Code')}}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($allLabelSelect as $label)
                                    <tr class="add_row">
                                        <td><input type="text" class="form-control"
                                                   name="lbl_name[][{{$label->id}}]"
                                                   value="{{strip_tags($label->lb_name)}}" required="required"/></td>
                                        <td><input type="text" class="form-control jscolor "
                                                   name="lbl_code[][{{$label->id}}]"
                                                   value="{{strip_tags($label->lb_code)}}" required="required"/></td>
                                        <td class="text-center">
                                            <button type="button" class="badge badge-danger delc" id="delete_lbl"
                                                    title="Delete label"
                                                    onclick="inboxWebmail_deleteLabel({{$label->id}});">
                                                X
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4" align="right">
                                            <button class="btn btn-success btn-sm addc" type="button" id="add_lbl" title='Add more label'> {{__('Add more label')}}</button>
                                        </td>
                                    </tr>

                                    </tfoot>
                                </table>
                            </div>

                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit">{{__('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
        
      </div>

    </div>
  </div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{asset('assets/admin/inbox/admin/js/inboxWebmail_admin.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin/inbox/admin/js/bootstrap-toggle.min.js')}}"></script>

<script>
  function inboxWebmail_deleteLabel(id) {
      "use strict";
      $.ajax({
          url: '{{route('admin.inboxwebmail.label.delete')}}',
          type: 'post',
          data: {
              '_token': '{{csrf_token()}}',
              'label_id' : id
          },
          success:function (res) {
             // nothing do
          }
      });
  }
</script>

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

    showHideSecondaryPassword();
    
</script>

@endsection
