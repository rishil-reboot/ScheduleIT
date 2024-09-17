@extends('admin.layout')
@section('content')
  <style type="text/css">
  .form-wrap.form-builder .frmb li,.form-wrap.form-builder .frmb-control li,.form-wrap.form-builder .frmb .form-elements{background-color: #212529;}
  .form-wrap.form-builder .frmb .form-elements [contenteditable].form-control, .form-wrap.form-builder .frmb .form-elements input[type='text'], .form-wrap.form-builder .frmb .form-elements input[type='number'], .form-wrap.form-builder .frmb .form-elements input[type='date'], .form-wrap.form-builder .frmb .form-elements input[type='color'], .form-wrap.form-builder .frmb .form-elements textarea, .form-wrap.form-builder .frmb .form-elements select{background-color: #212529;}
  body[data-background-color="dark"] .form-control, body[data-background-color="dark"] .form-group-default, body[data-background-color="dark"] .select2-container--bootstrap .select2-selection{color: #000;}
  #language,#name{color: #fff;}
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@php
  $default = \App\Language::where('is_default', 1)->first();
@endphp
  <div class="page-header">
    <h4 class="page-title">Forms</h4>
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
        <a href="#">Edit Form</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Forms</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Form</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.form_builder.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-4">
          <div class="row">
            <div class="col-lg-10 offset-lg-1">
              <form id="ajaxForm" action="{{route('admin.form_builder.update')}}" method="post">
                @csrf
                <input type="hidden" id="id" name="id" value="{{$form_builder->id}}">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Language **</label>
                      <select id="language" name="lang_id" class="form-control">
                         <option value="" selected disabled>Select a language</option>
                         @foreach ($langs as $lang)
                         <option value="{{$lang->id}}" <?php echo ($form_builder->language_id==$lang->id)?'selected':'' ?> >{{$lang->name}}</option>
                         @endforeach
                      </select>
                      <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Name **</label>
                      <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" value="{{$form_builder->name}}">
                      <p id="errname" class="em text-danger mb-0"></p>
                    </div>
                  </div>

                  <?php 
                      $data = (new \App\Admin)->getEmailDropdown();
                      $arrayUserList = array();
                      if(isset($form_builder->formBuilderToEmail) && !$form_builder->formBuilderToEmail->isEmpty()) {
                          
                          $arrayUserList = $form_builder->formBuilderToEmail->pluck('user_id')->toArray();    
                      }

                  ?>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="">To Email Address **</label>
                      <select name="to_email[]" id="to_email_address" class="form-control">
                          @if(!empty($data))
                            <option value="">Select user To email</option>
                            @foreach($data as $key=>$v)
                                <option value="{{$key}}" @if(in_array($key,$arrayUserList)) selected @endif>{{$v}}</option>
                            @endforeach
                          @endif
                      </select>
                      <p id="errto_email" class="em text-danger mb-0"></p>
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class='form-group' id='form-group-formbuilder' style="">
                      <label class='control-label col-sm-2'>Body</label>
                      <div class="col-sm-12">
                        <div id="fb-editor"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="button_save" class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

  $(document).ready(function() {
    const formData = <?php echo ($form_builder->body) ?>;
    console.log(formData);
    var formBuilder = $('#fb-editor').formBuilder({formData});
    document.getElementById('button_save').addEventListener('click', function() {
      $('#errlanguage_id').html('');
      $('#errname').html('');
      var body = formBuilder.actions.getData('json');
      var language_id = $('#language').val();
      var name = $('#name').val();
      var id = $('#id').val();
      var to_email = $('#to_email_address').val();
      
      $.ajax({
        type: 'post',
        url: "{{route('admin.form_builder.update')}}",
        data: {'id':id,'language_id':language_id,'name':name,'body':body,'to_email':to_email},
        success: function (data) {
          if(data=='success') {
            window.location.href="{{route('admin.form_builder.index') . '?language=' . $default->code}}";
          } else if(data.error[0]) {
            if(typeof data.language_id!='undefined') {
              $('#errlanguage_id').html(data.language_id[0]);
            }
            if(typeof data.name!='undefined') {
              $('#errname').html(data.name[0]);
            }
            $(window).scrollTop(0);
          }
        }
      });
    });
  });
</script>
@endsection
