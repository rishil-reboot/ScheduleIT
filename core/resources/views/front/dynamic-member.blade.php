@extends("front.$version.layout")

@section('pagename')
 - {{convertUtf8($page->name)}}
@endsection

@section('meta-keywords', "$page->meta_keywords")
@section('meta-description', "$page->meta_description") 

@section('styles')
   <style>
      .pro-detail-box {
         background: #dc3546;
         padding: 30px;
         -webkit-border-radius: 10px;
         border-radius: 10px;
         display: -webkit-box;
         display: -webkit-flex;
         display: -ms-flexbox;
         display: flex;
         -webkit-box-align: center;
         -webkit-align-items: center;
         -ms-flex-align: center;
         align-items: center;
      }

      .pro-detail-img {
         border-radius: 10px;
         box-shadow: 0px 0 25px 0 rgba(0, 0, 0, 0.25);
         overflow: hidden;
         max-width: 375px;
      }
      .pro-detail-img img {
         width: 100%;
      }
      .pro-detail-info {
         padding: 30px;
      }

      .pro-detail-info h2 {
         color: #fff;
         font-size: 50px;
         font-weight: 700;
         text-transform: capitalize;
         line-height: 70px;
      }

      .pro-detail-info h4 {
         color: #fff;
         font-size: 30px;
         font-weight: 700;
         text-transform: capitalize;
         line-height: 40px;
         margin-top: 30px;
         margin-bottom: 10px;
      }

      .pro-detail-info p {
         color: #fff;
         font-size: 20px;
      }

      .fo-preview{
         background: white;
         text-align: center;
         display: flex
      }
      .fo-preview a{

         font-size: 50px;
         black: white;
         padding: 20px;
      }

      @media only screen and (max-width: 600px) {
         .pro-detail-info {
            padding: 0px;
         }

      }

   </style>
@endsection

@section('content')
  <!--   breadcrumb area start   -->
  <div class="breadcrumb-area" style="background-image: url({{$page->getHeaderPageImageUrl(asset('assets/front/img/' . $bs->breadcrumb))}});background-size:cover;">
     <div class="container">
        <div class="breadcrumb-txt">
           <div class="row">
              <div class="col-xl-7 col-lg-8 col-sm-10">
                 <span style="font-size: {{$page->title_font_size}}px;font-family:{{$page->title_font_style}}">{{convertUtf8($page->title)}}</span>
                 <h1 style="font-size: {{$page->subtitle_font_size}}px;font-family:{{$page->subtitle_font_style}}">{{convertUtf8($page->subtitle)}}</h1>
                 <ul class="breadcumb">
                    <li><a href="{{route('front.index')}}">{{__('Home')}}</a></li>
                    <li><a href="{{route('front.team')}}">{{__('Team')}}</a></li>
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
        <div class="row d-flex justify-content-center">
           <div class="col-lg-10">
                  <div class="pro-detail-box">
                     <div class="row">
                        <div class="col-md-4">
                           
                           <div class="pro-detail-img">
                              <img src="{{asset('assets/front/img/members')}}/{{$page->image}}" alt="">
                           </div>

                        </div>

                        <div class="col-md-6">

                           <div class="pro-detail-info">
                              <h2>{{$page->name}}</h2>
                              <p>{{$page->rank}}</p>
                              
                                 @if($page->display_facebook == 1 ||
                                    $page->display_instagram == 1 ||
                                    $page->display_linkedin == 1 || 
                                    $page->display_twitter == 1
                                 )

                                    <ul class="social-links fo-preview">
                                       @if($page->display_facebook == 1)

                                          @if($page->facebook !=null)
                                             <li><a target="_blank" href="{{ $page->facebook }}/abc"><i class="fab fa-facebook-square"></i></a></li>
                                          @else
                                             <li><a href="javascript:void(0)"><i class="fab fa-facebook-square iconpicker-component"></i></a></li>
                                          @endif

                                       @endif

                                       @if($page->display_twitter == 1)

                                          @if($page->twitter !=null)
                                             <li><a target="_blank" href="{{ $page->twitter }}"><i class="fab fa-twitter iconpicker-component"></i></a></li>
                                          @else
                                             <li><a href="javascript:void(0)"><i class="fab fa-twitter iconpicker-component"></i></a></li>
                                          @endif

                                       @endif

                                       @if($page->display_instagram == 1)

                                          @if($page->instagram !=null)
                                             <li><a target="_blank" href="{{ $page->instagram }}"><i class="fab fa-instagram iconpicker-component"></i></a></li>
                                          @else
                                             <li><a href="javascript:void(0)"><i class="fab fa-instagram iconpicker-component"></i></a></li>
                                          @endif

                                       @endif

                                       @if($page->display_linkedin == 1)

                                          @if($page->linkedin !=null)
                                             <li><a target="_blank" href="{{ $page->linkedin }}"><i class="fab fa-linkedin-in iconpicker-component"></i></a></li>
                                          @else
                                             <li><a href="javascript:void(0)"><i class="fab fa-linkedin-in iconpicker-component"></i></a></li>
                                          @endif

                                       @endif
                                       
                                    </ul>
                                 
                                 @endif
      
                              
                           </div>

                        </div>

                     </div>
                     
               </div>

             {!! replaceBaseUrl(convertUtf8($page->body)) !!}
           </div>
        </div>
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

    var siteKey = "{{$bs->google_recaptcha_site_key}}";

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
                    return false;
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
