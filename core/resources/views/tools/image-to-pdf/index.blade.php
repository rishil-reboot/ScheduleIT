@extends("front.$version.layout")

@section('pagename')
    - {{ convertUtf8($page->name) }}
@endsection

@section('meta-keywords', "$page->meta_keywords")
@section('meta-description', "$page->meta_description")

@section('content')
    <!--   breadcrumb area start   -->
    @if ($bs->breadcum_type == 1)
        <div class="breadcrumb-area"
            style="background-image: url('{{ asset('assets/front/img/' . $bs->breadcrumb) }}');background-size:cover;">
        @else
            <div class="breadcrumb-area blogs video-container">
                <video autoplay muted loop>
                    <source src="{{ asset('assets/front/img/breadcrumb/') }}/{{ $bs->breadcum_video }}" type="video/mp4" />
                </video>
    @endif

    <div class="container">
        <div class="breadcrumb-txt" style="padding:{{ $breadcumPadding }}">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-sm-10">
                    <span
                        style="font-size: {{ $page->title_font_size }}px;font-family:{{ $page->title_font_style }}">{{ convertUtf8($page->title) }}</span>
                    <h1 style="font-size: {{ $page->subtitle_font_size }}px;font-family:{{ $page->subtitle_font_style }}">
                        {{ convertUtf8($page->subtitle) }}</h1>
                    <ul class="breadcumb">
                        <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                        <li>{{ convertUtf8($page->name) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-area-overlay"
        style="background-color: #{{ $be->breadcrumb_overlay_color }};opacity: {{ $be->breadcrumb_overlay_opacity }};">
    </div>
    </div>
    <!--   breadcrumb area end    -->


    <!--   about company section start   -->
    <div class="about-company-section pt-115 pb-80">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-9">
                    {!! replaceBaseUrl(convertUtf8($page->body)) !!}
                </div>
            </div>

            <div class="row d-flex justify-content-center">

                <div class="col-lg-9">

                    <form id="ajaxFormData" class="" action="{{ route('front.convertImageToPdf') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="">File **</label>
                            <input type="file" class="form-control" name="file">
                            Note:- only .tiff, gif, jpeg, png files are allowed.
                            <p id="errfile" class="mb-0 text-danger em"></p>

                        </div>

                       @if ($bs->is_recaptcha == 1)
                        <div class="d-block mb-4">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                            <p id="errg-recaptcha-response" class="mb-0 text-danger em">
                                @if ($errors->has('g-recaptcha-response'))
                                    {{ $errors->first('g-recaptcha-response') }}
                                @endif
                            </p>
                        </div>
                    @endif

                        <button type="submit" class="btn btn-secondary">Convert To PDF</button>

                    </form>

                </div>
            </div>
            @if (isset($faqs) && !$faqs->isEmpty())
                <div class="row">
                    <div class="col-lg-12">
                        <div class="faq-section">
                            <div class="col-lg-6 offset-lg-3" style="margin-bottom:30px;text-align: center;">
                                <h2>FAQ</h2>
                            </div>
                            <div class="container">
                                <div class="row">
                                    @foreach ($faqs as $i => $v)
                                        <div class="col-lg-12" style="margin-bottom:12px;color: #25D06F;">
                                            <h4>{{ $v->name }}</h4>
                                        </div>
                                        @foreach ($v->customerFaq as $ii => $vv)
                                            <div class="col-lg-6">
                                                <div class="accordion" id="accordionExample1">
                                                    <div class="card">
                                                        <div class="card-header" id="heading{{ $vv->id }}">
                                                            <h2 class="mb-0">
                                                                <button class="btn btn-link collapsed btn-block text-left"
                                                                    type="button" data-toggle="collapse"
                                                                    data-target="#collapse{{ $vv->id }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapse{{ $vv->id }}">
                                                                    {{ convertUtf8($vv->question) }}
                                                                </button>
                                                            </h2>
                                                        </div>
                                                        <div id="collapse{{ $vv->id }}" class="collapse"
                                                            aria-labelledby="heading{{ $vv->id }}"
                                                            data-parent="#accordionExample1">
                                                            <div class="card-body">
                                                                {{ convertUtf8($vv->answer) }}
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
    
@endsection
@section('scripts')

    <script src="https://www.google.com/recaptcha/api.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $("#ajaxFormData").submit(function(e) {

            e.preventDefault();

            var formId = $(this).attr('id');
            var buttonText = $('#' + formId + ' button[type="submit"]').text();
            var $btn = $('#' + formId + ' button[type="submit"]').attr('disabled', 'disabled').html(
            "Processing...");

            var form_Data = new FormData(this);
            $.ajax({
                url: "{{ route('front.convertImageToPdf') }}",
                type: 'POST',
                data: form_Data,
                success: function(response) {

                    var filename = response.filename;

                    $.ajax({
                            url: "{{ route('front.get-download-file') }}",
                            type: 'POST',
                            data: {'filename':filename },
                            xhrFields: {
                                responseType: 'blob'
                            },
                            success: function(res) {

                                var blob = new Blob([res]);
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = 'download.pdf';
                                link.click();

                                $.ajax({
                                        url: "{{ route('front.removeFileFromServer') }}",
                                        type: 'POST',
                                        success: function(res) {

                                    },
                                    error: function(jqXhr) {

                                    }
                                });

                                $('#' + formId + ' button[type="submit"]').text(buttonText);
                                $('#' + formId + ' button[type="submit"]').removeAttr('disabled', 'disabled');


                        },
                        error: function(jqXhr) {

                        }
                        
                    });

               },
                error: function(jqXhr) {
                    
                    var errors = $.parseJSON(jqXhr.responseText);
                    showErrorMessages(formId, errors);
                    $('#' + formId + ' button[type="submit"]').text(buttonText);
                    $('#' + formId + ' button[type="submit"]').removeAttr('disabled', 'disabled');

                    @if ($bs->is_recaptcha == 1)
                        grecaptcha.reset();
                    @endif

                },
                cache: false,
                contentType: false,
                processData: false
            });
        });


        function showErrorMessages(formId, errorResponse) {

            var msgs = "";
            $.each(errorResponse.errors, function(key, value) {
               
               $("#err"+key).html(value);

            });

            // showMessageData(msgs);
        }

        function showMessageData(msgs) {

            $(".validation-message").html(msgs);
        }
    </script>

    <script type="text/javascript">
        $(function() {
            function rescaleCaptcha() {
                var width = $('.g-recaptcha').parent().width();
                var scale;
                if (width < 302) {
                    scale = width / 302;
                } else {
                    scale = 1.0;
                }

                $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
                $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
                $('.g-recaptcha').css('transform-origin', '0 0');
                $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
            }

            rescaleCaptcha();
            $(window).resize(function() {
                rescaleCaptcha();
            });

        });
    </script>

@endsection
