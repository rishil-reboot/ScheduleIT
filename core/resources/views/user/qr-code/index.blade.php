@extends('user.layout')

@section('pagename')
 - QR Code Generator
@endsection

@section('styleSection')

<link rel="stylesheet" href="{{asset('assets/front/color-picker/jquery.minicolors.css')}}">
<style type="text/css">
    .downloadbtn {
      font-size: 20px;
      color: black;
      padding: 9px;
      background-image: linear-gradient(60deg, #ffa229, #FFD700);
      margin-top: 36px;
      text-decoration: none;
  }

  .downloadbtn:hover{

      text-decoration: none;
  }

  label{
    margin-bottom: 8px;
  }

  .minicolors-theme-default .minicolors-input{
    height: 42px !important;
  }
</style>
@endsection

@section('content')

<!--   hero area start   -->
  @if($bs->breadcum_type == 1)

      <div class="breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
  @else

      <div class="breadcrumb-area blogs video-container">
         <video autoplay muted loop>
            <source src="{{asset('assets/front/img/breadcrumb/')}}/{{$bs->breadcum_video}}" type="video/mp4" />
         </video>
  @endif
      
      <div class="container">
        <div class="breadcrumb-txt" style="padding:{{$breadcumPaddingDashboard}}">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <h1>QR Code Generator</h1>
                    <ul class="breadcumb">
                        <li><a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a></li>
                        <li>QR Code Generator</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area-overlay"></div>
</div>
<!--   hero area end    -->
     <!--====== CHECKOUT PART START ======-->
     <section class="user-dashbord">
        <div class="container">
            <div class="row">
                @include('user.inc.site_bar')
                <div class="col-lg-9">
                    <div class="row mb-5">
                        <div class="col-lg-12">
                            <div class="user-profile-details">
                                <div class="account-info">
                                    <div class="title">
                                        <h4>Generate QR Code</h4>
                                    </div>
                                    <div class="edit-info-area">
                                            
                                        <form action="{{route('save-qr-code-generator')}}" id="fromSubmit" method="post" class="fromSubmit" role="form">
                                         {{csrf_field()}}
                                          
                                          <div class="row">

                                              <div class="col-lg-10 offset-1">
                                                
                                                <div class="form-group">
                                                    <label for="qrdata_type">QR Data Type</label>
                                                    <select name="qrdata_type" id="qrdata_type" class="form-control">
                                                      <option value="text">Bulk Text</option>
                                                      <option value="link">Link</option>
                                                      <option value="sms">SMS</option>
                                                      <option value="email">Email</option>
                                                      <option value="phone">Phone Number</option>
                                                      <option value="vcard">Contact VCard</option>
                                                      <option value="mecard">Contact meCard</option>
                                                    </select>
                                                    <p id="errqrdata_type" class="em text-danger mb-0"></p>
                                                </div>

                                              </div>

                                              <div class="col-lg-10 offset-1 class_text" style="display: none;">
                                                
                                                <div class="form-group">
                                                  
                                                    <label class="qr_label" for="qr_bulk_text">QR Bulk Text</label>
                                                    <textarea name="qr_bulk_text" id="qr_bulk_text" class="qr_bulk_text form-control" ></textarea>
                                                    <p id="errqr_bulk_text" class="em text-danger mb-0"></p>

                                                </div>

                                              </div>    

                                              <div class="col-lg-10 offset-1 class_link" style="display:none">
                                                
                                                   <div class="form-group">
                                                      <label class="qr_label" for="qr_link">QR Link</label>
                                                      <input name="qr_link" id="qr_link" class="qr_link form-control" value="" />
                                                      <p id="errqr_link" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>

                                              <div class="col-lg-10 offset-1 class_sms" style="display:none">
                                                
                                                  <div class="form-group">
                                                    <label class="qr_label" for="qr_sms_phone">QR SMS Phone</label>
                                                    <input name="qr_sms_phone" id="qr_sms_phone" class="qr_sms_phone form-control" value="" />
                                                    <p id="errqr_sms_phone" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>  

                                              <div class="col-lg-10 offset-1 class_sms" style="display:none"> 
                                                  
                                                  <div class="form-group">
                                                      <label class="qr_label" for="qr_sms_msg">QR SMS Message</label>
                                                      <textarea name="qr_sms_msg" id="qr_sms_msg" class="qr_sms_msg form-control" ></textarea>
                                                      <p id="errqr_sms_msg" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                            
                                              
                                              <div class="col-lg-10 offset-1 class_email" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_email_add">QR Email</label>
                                                      <input name="qr_email_add" id="qr_email_add" class="qr_email_add form-control" />
                                                      <p id="errqr_email_add" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_email" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_email_sub">Subject</label>
                                                      <input name="qr_email_sub" id="qr_email_sub" class="qr_email_sub form-control"  />
                                                      <p id="errqr_email_sub" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                                
                                              <div class="col-lg-10 offset-1 class_email" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_email_msg">Message</label>
                                                      <textarea name="qr_email_msg" id="qr_email_msg" class="qr_email_msg form-control" ></textarea>
                                                      <p id="errqr_email_msg" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>

                                              <div class="col-lg-10 offset-1 class_phone" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_phone_phone">Phone Number</label>
                                                      <input name="qr_phone_phone" id="qr_phone_phone" class="qr_phone_phone form-control" value="" />
                                                      <p id="errqr_phone_phone" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_name">Name</label>
                                                      <input name="qr_vc_name" id="qr_vc_name" class="qr_vc_name form-control" />
                                                      <p id="errqr_vc_name" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_company">Company</label>
                                                      <input name="qr_vc_company" id="qr_vc_company" class="qr_vc_company form-control" />
                                                      <p id="errqr_vc_company" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                                
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_job">Job</label>
                                                      <input name="qr_vc_job" id="qr_vc_job" class="qr_vc_job form-control" />
                                                      <p id="errqr_vc_job" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>  
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_work_phone">Work Phone</label>
                                                      <input name="qr_vc_work_phone" id="qr_vc_work_phone" class="qr_vc_work_phone form-control"  />
                                                      <p id="errqr_vc_work_phone" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_home_phone">Home Phone</label>
                                                      <input name="qr_vc_home_phone" id="qr_vc_home_phone" class="qr_vc_home_phone form-control" />
                                                      <p id="errqr_vc_home_phone" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_home_address">Home Address</label>
                                                      <input name="qr_vc_home_address" id="qr_vc_home_address" class="qr_vc_home_address form-control"  />
                                                      <p id="errqr_vc_home_address" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_home_city">Home City</label>
                                                      <input name="qr_vc_home_city" id="qr_vc_home_city" class="qr_vc_home_city form-control"  />
                                                      <p id="errqr_vc_home_city" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_home_postcode">Home Postcode</label>
                                                      <input name="qr_vc_home_postcode" id="qr_vc_home_postcode" class="qr_vc_home_postcode form-control"  />
                                                      <p id="errqr_vc_home_postcode" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_home_country">Home Country</label>
                                                      <input name="qr_vc_home_country" id="qr_vc_home_country" class="qr_vc_home_country form-control"  />
                                                      <p id="errqr_vc_home_country" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_email">Email</label>
                                                      <input name="qr_vc_email" id="qr_vc_email" class="qr_vc_email form-control"  />
                                                      <p id="errqr_vc_email" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_vcard" style="display:none">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_vc_url">Url</label>
                                                      <input name="qr_vc_url" id="qr_vc_url" class="qr_vc_url form-control"  />
                                                      <p id="errqr_vc_url" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                            
                                              <div class="col-lg-10 offset-1 class_mecard" style="display:none;">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_mec_name">Name</label>
                                                      <input name="qr_mec_name" id="qr_mec_name" class="qr_mec_name form-control"  />
                                                      <p id="errqr_mec_name" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_mecard" style="display:none;">
                                                
                                                  <div class="form-group ">
                                                    
                                                      <label class="qr_label" for="qr_mec_phone">Phone</label>
                                                      <input name="qr_mec_phone" id="qr_mec_phone" class="qr_mec_phone form-control"  />
                                                      <p id="errqr_mec_phone" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_mecard" style="display:none;">
                                                  
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_mec_email">Email</label>
                                                      <input name="qr_mec_email" id="qr_mec_email" class="qr_mec_email form-control"  />
                                                      <p id="errqr_mec_email" class="em text-danger mb-0"></p>
                                                  </div>
                                                
                                              </div>
                                              
                                              <div class="col-lg-10 offset-1 class_mecard" style="display:none;">
                                                
                                                  <div class="form-group">
                                                    
                                                      <label class="qr_label" for="qr_mec_url">Url</label>
                                                      <input name="qr_mec_url" id="qr_mec_url" class="qr_mec_url form-control"  />
                                                      <p id="errqr_mec_url" class="em text-danger mb-0"></p>
                                                  </div>

                                              </div>

                                          </div>    
                                          
                                          <fieldset>
                                              
                                              <div class="row">

                                                <div class="col-lg-5 offset-1">
                                                
                                                  <div class="form-group">
                                                
                                                      <label for="height">Barcode Height</label>
                                                      <input name="height" value="150" id="height" class="height form-control" /> <small class="height">For QRCode with and height, set here a value</small>
                                                      <p id="errheight" class="em text-danger mb-0"></p>
                                                  </div>

                                                </div>
                                                
                                                <div class="col-lg-5">
                                                  
                                                    <div class="form-group">
                                                      
                                                        <label for="scale">Scale</label>
                                                        <input name="scale" value="2" id="scale" class="scale form-control" /> <small class="scale">and set a multiplier here. (50 * 2 = 100x100px).</small>
                                                        <p id="errscale" class="em text-danger mb-0"></p>
                                                    </div>

                                                </div>
                                                

                                                <div class="col-lg-5 offset-1">
                                                  
                                                    <div class="form-group">
                                                    
                                                        <label for="bgcolor">Background Color</label>
                                                        <input type="text" name="bgcolor" id="bgcolor" value="#ffffff" class="bgcolor form-control" /> <small class="bgcolormessad">Set a background color here.</small>
                                                        <p id="errbgcolor" class="em text-danger mb-0"></p>
                                                    </div>

                                                </div>

                                                <div class="col-lg-5">
                                                    
                                                    <div class="form-group">
                                                      
                                                        <label for="color">Bars Color</label>
                                                        <input type="text" name="color" id="color" class="color form-control" value="#000000" /> <small class="color-class">Set the foreground color here.</small>

                                                    </div>

                                                </div>

                                                  
                                                <div class="col-lg-5 offset-1">
                                                  
                                                    <div class="form-group">
                                                      
                                                        <label for="file">File Name</label>
                                                        <input name="file" id="file" class="file form-control" />
                                                        <small class="file">Filename will trigger a download.</small>
                                                        <p id="errfile" class="em text-danger mb-0"></p>
                                                    </div>

                                                </div>
                                                
                                                <div class="col-lg-5">
                                                  
                                                  <div class="form-group">
                                                    
                                                      <label for="folder">Type</label>
                                                      <select name="type" id="type" class="type form-control">
                                                          <option value="png">PNG</option>
                                                      </select> 
                                                      <p id="errtype" class="em text-danger mb-0"></p>
                                                  </div>

                                                </div>

                                              </div>

                                          </fieldset>
                                          
                                          <br>

                                          <div class="response-data" style="text-align: center;padding: 20px;"></div>
                                          <div class="row">
                                             <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                             </div>
                                          </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
  

<script src="{{asset('assets/front/color-picker/jquery.minicolors.js')}}"></script>

 <script>
    $(document).ready( function() {

        
        $('.bgcolor').minicolors();
        $('.color').minicolors();

    });
  </script>

<script type="text/javascript">
    
  changeQrCode();

  $(document).on("change","#qrdata_type",function(){

      changeQrCode();

  });

  function changeQrCode(){

      var qrType = $("#qrdata_type").val();

      if (qrType == 'text') {

        $('.class_text').show();
        $('.class_link').hide();
        $('.class_sms').hide();
        $('.class_email').hide();
        $('.class_phone').hide();
        $('.class_vcard').hide();
        $('.class_mecard').hide();

      }else if(qrType == 'link'){

        $('.class_text').hide();
        $('.class_link').show();
        $('.class_sms').hide();
        $('.class_email').hide();
        $('.class_phone').hide();
        $('.class_vcard').hide();
        $('.class_mecard').hide();


      }else if(qrType == 'sms'){
        
        $('.class_text').hide();
        $('.class_link').hide();
        $('.class_sms').show();
        $('.class_email').hide();
        $('.class_phone').hide();
        $('.class_vcard').hide();
        $('.class_mecard').hide();

      }else if(qrType == 'email'){
        
        $('.class_text').hide();
        $('.class_link').hide();
        $('.class_sms').hide();
        $('.class_email').show();
        $('.class_phone').hide();
        $('.class_vcard').hide();
        $('.class_mecard').hide();

      }else if(qrType == 'phone'){
        
        $('.class_text').hide();
        $('.class_link').hide();
        $('.class_sms').hide();
        $('.class_email').hide();
        $('.class_phone').show();
        $('.class_vcard').hide();
        $('.class_mecard').hide();

      }else if(qrType == 'vcard'){
        
        $('.class_text').hide();
        $('.class_link').hide();
        $('.class_sms').hide();
        $('.class_email').hide();
        $('.class_phone').hide();
        $('.class_vcard').show();
        $('.class_mecard').hide();

      }else if(qrType == 'mecard'){
        
        $('.class_text').hide();
        $('.class_link').hide();
        $('.class_sms').hide();
        $('.class_email').hide();
        $('.class_phone').hide();
        $('.class_vcard').hide();
        $('.class_mecard').show();

      }
  }


  $.ajaxSetup({

    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $('form.fromSubmit').submit(function (event) {

      event.preventDefault();
      var formId = $(this).attr('id');
      
      var isLocal = "{{env('IS_LOCAL_OR_LIVE')}}";

      var formAction = $(this).attr('action');

      var buttonText = $('#'+formId+' button[type="submit"]').text();
      var $btn = $('#'+formId+' button[type="submit"]').attr('disabled','disabled').html("Loading...");

      $.ajax({
          type: "POST",
          url: formAction,
          data: new FormData(this),
          contentType: false,
          processData: false,
          enctype: 'multipart/form-data',
          success: function (response) {
            $('.text-danger').empty();

            if (isLocal == 'local') {

                $('.response-data').html(response);
                    
            }else{

              $('.response-data').html('<img src="data:image/png;base64, '+response+' "><br><br><a class="downloadbtn" href="data:image/png;base64, '+response+' " download="'+$('#file').val()+'"> <i class="fa fa-download" aria-hidden="true"></i> Download</a>');
            }

            $('#'+formId+' button[type="submit"]').text(buttonText);
            $('#'+formId+' button[type="submit"]').removeAttr('disabled','disabled');

          },
          error: function (jqXhr) {
              
              $('.text-danger').empty();  
              $('.response-data').empty();  
              var errorResponse = $.parseJSON(jqXhr.responseText);
                  console.log(errorResponse);
              $.each(errorResponse, function(key, value) {

                  $('#err'+key).html(value);

              });


              $('#'+formId+' button[type="submit"]').text(buttonText);
              $('#'+formId+' button[type="submit"]').removeAttr('disabled','disabled');
              
          }
      });
      return false;
      
  });

</script>  

@endsection
