@extends("front.$version.layout")

@section('pagename')
 - {{__('Contact Us')}}
@endsection

@section('meta-keywords', "$be->contact_meta_keywords")
@section('meta-description', "$be->contact_meta_description")


@section('content')

  <script src="https://www.google.com/recaptcha/api.js?" async defer></script>

  <!--   breadcrumb area start   -->
  @if($bs->breadcum_type == 1)

      <div class="breadcrumb-area" style="background-image: url('{{asset('assets/front/img/' . $bs->breadcrumb)}}');background-size:cover;">
  @else

      <div class="breadcrumb-area blogs video-container">
         <video autoplay muted loop>
            <source src="{{asset('assets/front/img/breadcrumb/')}}/{{$bs->breadcum_video}}" type="video/mp4" />
         </video>
  @endif

      <div class="container">
        <div class="breadcrumb-txt" style="padding:{{$breadcumPadding}}">
           <div class="row">
              <div class="col-xl-7 col-lg-8 col-sm-10">
                 <span>{{convertUtf8($bs->contact_title)}}</span>
                 <h1>{{convertUtf8($bs->contact_subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{__('Contact Us')}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


  <!--    contact form and map start   -->
  <div class="contact-form-section">
     <div class="container">
        <div class="row">
           <div class="col-lg-6">
              <span class="section-title">{{convertUtf8($bs->contact_form_title)}}</span>
              <h2 class="section-summary">{{convertUtf8($bs->contact_form_subtitle)}}</h2>

               {!! replaceBaseUrl(convertUtf8($bodyForm)) !!}

               <div class="input-box mb-4 validation-message" style="color:red"></div>

           </div>
           <div class="col-lg-6">
              <div class="map-wrapper">
                 <div id="map"></div>
                 <div class="contact-infos">
                    <div class="single-contact-info">
                       <div class="icon-wrapper">
                          <i class="fa fa-home"></i>
                       </div>
                       <p>{{convertUtf8($bs->contact_address)}}</p>
                    </div>
                    <div class="single-contact-info">
                       <div class="icon-wrapper">
                          <i class="fa fa-phone"></i>
                       </div>
                       <p>{{convertUtf8($bs->contact_number)}}</p>
                    </div>
                    <div class="single-contact-info">
                       <div class="icon-wrapper">
                          <i class="fa fa-envelope"></i>
                       </div>
                       <p>{{convertUtf8($be->to_mail)}}</p>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  <!--    contact form and map end   -->

@endsection

@section('scripts')
<script type="text/javascript" src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://formbuilder.online/assets/js/form-render.min.js"></script>

<script src="https://www.google.com/recaptcha/api.js"></script>

<script type="text/javascript">

  $(document).ready(function(){
    var form_id = $("#form_builder_rebootcs").attr('data-id');

      var siteKey = "{{\Crypt::decryptString($bs->google_recaptcha_site_key)}}";

      @if ($bs->is_recaptcha == 1)


         var recaptcha = "<div class='formbuilder-textarea form-group field-message'><div data-sitekey="+siteKey+" class='g-recaptcha' id='RecaptchaField1'></div></div>";

      @else

         var recaptcha = '';

      @endif


    if(typeof form_id =='string') {

      $(document).ready(function(){

         $.get("{{url('form-builder')}}/"+form_id, function(data, status){
           $('#form_builder_rebootcs').formRender({
             formData: data,
             dataType: 'json'
           });
           var formhtml = $( "#form_builder_rebootcs" ).html();
           var formhtml = '<form method="post" id="form_builder_data" enctype="multipart/form-data"><input type="hidden" name="form_id" value="'+form_id+'">'+formhtml+' </form>';
           $( "#form_builder_rebootcs" ).html(formhtml);
           $( "#form_builder_rebootcs .rendered-form" ).after(recaptcha+'<div class="form-element no-margin"><input type="submit" id="formbuilder_button" value="Submit"></div>' );

            @if ($bs->is_recaptcha == 1)

               grecaptcha.render('RecaptchaField1', {'sitekey': siteKey});

            @endif

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });


           $("#form_builder_data").submit(function(e) {

               var formId = $(this).attr('id');
               var buttonText = $('#'+formId+' button[type="submit"]').text();
               var $btn = $('#'+formId+' button[type="submit"]').attr('disabled','disabled').html("Loading...");

               e.preventDefault();
               var form_Data = new FormData(this);
               $.ajax({
                   url: "{{url('sendmail')}}",
                   type: 'POST',
                   data: form_Data,
                   success: function (data) {
                       // return false;
                       window.location.href=window.location;
                   },
                   error: function (jqXhr) {
                    var errors = $.parseJSON(jqXhr.responseText);
                    showErrorMessages(formId, errors);
                    $('#'+formId+' button[type="submit"]').text(buttonText);
                    $('#'+formId+' button[type="submit"]').removeAttr('disabled','disabled');

                    @if($bs->is_recaptcha == 1)
                        grecaptcha.reset();
                    @endif

                   },
                   cache: false,
                   contentType: false,
                   processData: false
               });
           });
         });

      });

    }
    var form_data = {};

  });

   function showErrorMessages(formId, errorResponse) {

        var msgs = "";
        $.each(errorResponse.errors, function(key, value) {
              msgs += value + " <br>";
        });

        showMessageData(msgs);
   }

   function showMessageData(msgs) {

        $(".validation-message").html(msgs);
   }

</script>

@endsection
