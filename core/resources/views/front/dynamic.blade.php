@extends("front.$version.layout")

@section('pagename')
 - {{convertUtf8($page->name)}}
@endsection

@section('content')

@section('meta-keywords', "$page->meta_keywords")
@section('meta-description', "$page->meta_description")

@section('content')
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
                 <span style="font-size: {{$page->title_font_size}}px;font-family:{{$page->title_font_style}}">{{convertUtf8($page->title)}}</span>
                 <h1 style="font-size: {{$page->subtitle_font_size}}px;font-family:{{$page->subtitle_font_style}}">{{convertUtf8($page->subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li>{{convertUtf8($page->name)}}</li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
     <div class="breadcrumb-area-overlay" style="background-color: #{{$be->breadcrumb_overlay_color}};opacity: {{$be->breadcrumb_overlay_opacity}};"></div>
  </div>
  <!--   breadcrumb area end    -->


  <!--   about company section start   -->
  <div class="about-company-section pt-115 pb-80">
     <div class="container">
        <div class="row">
           <div class="col-lg-12">
             {!! replaceBaseUrl(convertUtf8($page->body)) !!}
           </div>
        </div>
        @if(isset($faqs) && !$faqs->isEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="faq-section">
                   <div class="col-lg-6 offset-lg-3" style="margin-bottom:30px;text-align: center;">
                        <h2>FAQ</h2>
                    </div>
                   <div class="container">
                      <div class="row">
                            @foreach ($faqs as $i=>$v)
                                <div class="col-lg-12" style="margin-bottom:12px;color: #25D06F;">
                                    <h4>{{ $v->name }}</h4>
                                </div>
                                @foreach($v->customerFaq as $ii=>$vv)
                                    <div class="col-lg-6">
                                        <div class="accordion" id="accordionExample1">
                                           <div class="card">
                                              <div class="card-header" id="heading{{$vv->id}}">
                                                 <h2 class="mb-0">
                                                    <button class="btn btn-link collapsed btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$vv->id}}" aria-expanded="false" aria-controls="collapse{{$vv->id}}">
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
        @endif
    </div>
  </div>
  <!--   about company section end   -->
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
