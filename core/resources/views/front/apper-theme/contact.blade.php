@extends("front.$version.layout")
@section('content')

<script src="{{asset('assets/front/js/main.js')}}"></script>

<script src="https://www.google.com/recaptcha/api.js?" async defer></script>

    <!-- Preloader -->
    <div id="preloader">
      <div id="loader"></div>
    </div>

    <!-- Header Start -->

    <!-- BredCrumb-Section -->
    <div class="bred_crumb">
      <div class="container">
        <!-- shape animation  -->
        <span class="banner_shape1"> <img src="{{ asset('assets/front/theme-images/banner-shape1.png')}}" alt="image" > </span>
        <span class="banner_shape2"> <img src="{{ asset('assets/front/theme-images/banner-shape2.png')}}" alt="image" > </span>
        <span class="banner_shape3"> <img src="{{ asset('assets/front/theme-images/banner-shape3.png')}}" alt="image" > </span>

        <div class="bred_text">
          <h1>{{convertUtf8($bs->contact_title)}}</h1>
          <p>{{convertUtf8($bs->contact_form_subtitle)}}</p>
          <ul>
            <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
            <li><span>»</span></li>
            <li><a href="#">{{__('Contact Us')}}</a></li>
          </ul>
        </div>
      </div>
    </div>


    <!-- Contact Us Section Start -->
    <section class="contact_page_section">
        <div class="container">
           <div class="contact_inner">
              <div class="contact_form">
                <div class="section_title">
                    <h2><span>{{convertUtf8($bs->contact_form_title)}} </span></h2>
                    <p>{{convertUtf8($bs->contact_form_subtitle)}}</p>
                </div>
                {{-- <form action=""> --}}
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    {!! replaceBaseUrl(convertUtf8($bodyForm)) !!}
                {{-- </form> --}}
           </div>

          <!-- Contact info -->
          <div class="contact_info">
            <div class="icon"><img src="{{ asset('assets/front/theme-images/contact_message_icon.png')}}" alt="image"></div>
            <div class="section_title">
              <h2>Have any <span>question?</span></h2>
              <p>If you have any question about our product, service, payment or company, Visit our <a href="{{route('front.faq')}}">FAQs page.</a></p>
            </div>
            <a href="{{route('front.faq')}}" class="btn puprple_btn">READ FAQ</a>
            <ul class="contact_info_list">
              <li>
                <div class="img">
                  <img src="{{ asset('assets/front/theme-images/mail_icon.png')}}" alt="image">
                </div>
                <div class="text">
                  <span>Email Us</span>
                  <a href="">{{$be->to_mail}}</a>
                </div>
              </li>
              <li>
                <div class="img">
                  <img src="{{ asset('assets/front/theme-images/call_icon.png')}}" alt="image">
                </div>
                <div class="text">
                  <span>Call Us</span>
                  <a href="tel:+1(888)553-46-11">{{convertUtf8($bs->contact_number)}}</a>
                </div>
              </li>
              <li>
                <div class="img">
                  <img src="{{ asset('assets/front/theme-images/location_icon.png')}}" alt="image">
                </div>
                <div class="text">
                  <span>Visit Us</span>
                  <p>{{convertUtf8($bs->contact_address)}}</p>
                </div>
              </li>
            </ul>
        </div>
    <!-- Contact info  End -->
        </div>
     </div>
    </section>
    <!-- Contact Us Section End -->


    <!-- Map Section Start -->
    <section class="row_am map_section">
      <div class="container">
          <div class="map_inner">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387190.2799160891!2d-74.25987584510595!3d40.69767006338158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sin!4v1664399300741!5m2!1sen!2sin" width="100%" height="510" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
      </div>
    </section>
    <!-- Map Section End -->


    <!-- News-Letter-Section-Start -->

    <!-- News-Letter-Section-end -->


    <!-- Footer-Section start -->

    <!-- Footer-Section end -->
@endsection

@section('scripts')

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
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
        console.log(form_id);

         $.get("{{url('form-builder')}}/"+form_id, function(data, status){
           $('#form_builder_rebootcs').formRender({
             formData: data,
             dataType: 'json'
           });
           var formhtml = $( "#form_builder_rebootcs" ).html();
           var formhtml = '<form method="post" id="form_builder_data" enctype="multipart/form-data"><input type="hidden" name="form_id" value="'+form_id+'">'+formhtml+' </form>';
           $( "#form_builder_rebootcs" ).html(formhtml);
           $( "#form_builder_rebootcs .rendered-form" ).after(recaptcha+'<div class="form-element no-margin"><input type="submit" id="formbuilder_button" value="Submit" class="btn btn-primary"></div>' );

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
