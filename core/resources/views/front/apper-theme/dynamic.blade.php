@extends("front.$version.layout")

@section('pagename')
 - {{convertUtf8($page->name)}}
@endsection

@section('content')
@section('meta-keywords', "$page->meta_keywords")
@section('meta-description', "$page->meta_description")

@section('content')
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
          <h1>{{convertUtf8($page->title)}}</h1>
          <ul>
            <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
            <li><span>»</span></li>
            <li><a href="\#">{{convertUtf8($page->name)}}</a></li>
          </ul>
        </div>
      </div>
    </div>


    <!-- App-Solution-Section-Start -->
    <section class="row_am app_solution_section">
      <!-- container start -->
      <div class="container">
        <!-- row start -->
        <div class="row">
          <div class="col-lg-12">
            <!-- UI content -->
            <div class="app_text">
              <div class="section_title" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
                <h2><span>{!! replaceBaseUrl(convertUtf8($page->subtitle)) !!}</span> </h2>
              </div>
              <p data-aos="fade-up" data-aos-duration="1500">
                {!! replaceBaseUrl(convertUtf8($page->body)) !!}
              </p>
            </div>
          </div>

            <div class="col-lg-12">
                <div class="faq-section">
                   <div class="col-lg-6 offset-lg-3" style="margin-bottom:30px;text-align: center;">
                        <h2 style="color:#3625d0;" >FAQ</h2>
                    </div>
                   <div class="container">
                      <div class="row">
                            @foreach ($faqs as $i=>$v)
                                <div class="col-lg-12" style="margin-bottom:12px;color: #3625d0;">
                                    <h4>{{ $v->name }}</h4>
                                </div>
                                @foreach($v->customerFaq as $ii=>$vv)
                                    <div class="col-lg-6">
                                        <div class="accordion" id="accordionExample1">
                                           <div class="card">
                                              <div class="card-header" id="heading{{$vv->id}}">
                                                 <h2 class="mb-0">
                                                    <button class="btn btn-link collapsed btn-block text-left " type="button" data-toggle="collapse" data-target="#collapse{{$vv->id}}" aria-expanded="false" aria-controls="collapse{{$vv->id}}">
                                                    {{convertUtf8($vv->question)}}
                                                    </button>
                                                 </h2>
                                              </div>
                                              <div id="collapse{{$vv->id}}" class="collapse" aria-labelledby="heading{{$vv->id}}" data-parent="#accordionExample1">
                                                 <div class="card-body">
                                                    {{convertUtf8($vv->answer)}}
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                    </div>
                                @endforeach
                           @endforeach
                        </div>
                   </div>
                </div>
            </div>

        </div>
        <!-- row end -->
      </div>
      <!-- container end -->
    </section>
    <!-- App-Solution-Section-end -->

    <!-- VIDEO MODAL -->
    <div class="modal fade youtube-video" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <button id="close-video" type="button" class="button btn btn-default text-right" data-dismiss="modal">
            <i class="icofont-close-line-circled"></i>
          </button>
          <div class="modal-body">
            <div id="video-container" class="video-container">
              <iframe id="youtubevideo" src="" width="640" height="360" frameborder="0" allowfullscreen></iframe>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
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

    var validationFormMessage = '<div class="input-box mb-4 validation-message" style="color:red"></div>';

    if(typeof form_id =='string') {
      $.get("{{url('form-builder')}}/"+form_id, function(data, status){
        $('#form_builder_rebootcs').formRender({
          formData: data,
          dataType: 'json'
        });
        var formhtml = $( "#form_builder_rebootcs" ).html();
        var formhtml = '<form method="post" id="form_builder_data" enctype="multipart/form-data"><input type="hidden" name="form_id" value="'+form_id+'">'+formhtml+'</form>';
        $( "#form_builder_rebootcs" ).html(formhtml);
        $( "#form_builder_rebootcs .rendered-form" ).after(recaptcha+'<div class="form-element no-margin"><input type="submit" id="formbuilder_button" value="Submit"></div>'+validationFormMessage );

        @if ($bs->is_recaptcha == 1)

           grecaptcha.render('RecaptchaField1', {'sitekey': siteKey});

        @endif

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $("#form_builder_data").submit(function(e) {

            e.preventDefault();

            var formId = $(this).attr('id');
            var buttonText = $('#'+formId+' button[type="submit"]').text();
            var $btn = $('#'+formId+' button[type="submit"]').attr('disabled','disabled').html("Loading...");

            var form_Data = new FormData(this);
            $.ajax({
                url: "{{url('form-builder-submit')}}",
                type: 'POST',
                data: form_Data,
                success: function (data) {

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
