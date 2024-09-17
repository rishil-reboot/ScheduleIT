@extends('admin.layout')
@section('content')
    <div class="page-header">
        <h4 class="page-title">Pages</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Create Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Pages</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Create Page</div>
                </div>
                <div class="card-body pt-5 pb-4">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <form id="ajaxForm" action="{{ route('admin.page.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Language **</label>
                                            <select id="language" name="language_id" class="form-control">
                                                <option value="" selected disabled>Select a language</option>
                                                @foreach ($langs as $lang)
                                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                                @endforeach
                                            </select>
                                            <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Name **</label>
                                            <input type="text" name="name" onkeyup="makeslug(this.value)"
                                                class="form-control" placeholder="Enter Name">
                                            <p id="errname" class="em text-danger mb-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Status **</label>
                                            <select class="form-control ltr" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">Deactive</option>
                                            </select>
                                            <p id="errstatus" class="em text-danger mb-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Title **</label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Enter Title" value="">
                                            <p id="errtitle" class="em text-danger mb-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Title Font Size </label>
                                            <input type="number" class="form-control ltr" name="title_font_size"
                                                value="">
                                            <p id="errhero_section_title_font_size" class="em text-danger mb-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for=""> Font Style </label>
                                            <select class="form-control ltr" name="title_font_style">
                                                <option value="Arial ">Arial </option>
                                                <option value="Arial Black">Arial Black</option>
                                                <option value="Comic Sans MS">Comic Sans MS</option>
                                                <option value="Courier New">Courier New</option>
                                                <option value="Helvetica">Helvetica</option>
                                                <option value="Impact">Impact</option>
                                                <option value="Verdana">Tahoma</option>
                                                <option value="Times New Roman">Times New Roman</option>
                                                <option value="Verdana">Verdana</option>
                                                <option value="Lato">Lato </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Subtitle **</label>
                                            <input type="text" class="form-control" name="subtitle"
                                                placeholder="Enter Subtitle" value="">
                                            <p id="errsubtitle" class="em text-danger mb-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="">Subtitle Font Size</label>
                                            <input type="number" class="form-control ltr" name="subtitle_font_size">
                                            <p id="errhero_section_text_font_size" class="em text-danger mb-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for=""> Font Style </label>
                                            <select class="form-control ltr" name="subtitle_font_style">
                                                <option value="Arial ">Arial </option>
                                                <option value="Arial Black">Arial Black</option>
                                                <option value="Comic Sans MS">Comic Sans MS</option>
                                                <option value="Courier New">Courier New</option>
                                                <option value="Helvetica">Helvetica</option>
                                                <option value="Impact">Impact</option>
                                                <option value="Verdana">Tahoma</option>
                                                <option value="Times New Roman">Times New Roman</option>
                                                <option value="Verdana">Verdana</option>
                                                <option value="Lato">Lato </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">URL Slug **</label>
                                            <input type="text" class="form-control set-slug" name="slug"
                                                placeholder="Enter SEO Friendly URL Slug" value="">
                                            <p id="errslug" class="em text-danger mb-0"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Body **</label>
                                    <textarea id="body" class="form-control summernote" name="body" data-height="500"></textarea>
                                    <p id="errbody" class="em text-danger mb-0"></p>
                                </div>

                                <?php $mediaData = (new \App\Gallery())->getMedaiTypeDropDown(); ?>
                                <div class="form-group">
                                    <label for="">Media File</label>
                                    <select name="gallery_id" id="gallery_id" class="form-control">
                                        <option value="">Select media</option>
                                        @foreach ($mediaData as $key => $v)
                                            <option value="{{ $key }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                    <p id="errgallery_id" class="mb-0 text-danger em"></p>
                                </div>

                                <div class="form-group">
                                    <label for="">Serial Number **</label>
                                    <input type="number" class="form-control ltr" name="serial_number" value=""
                                        placeholder="Enter Serial Number">
                                    <p id="errserial_number" class="mb-0 text-danger em"></p>
                                    <p class="text-warning"><small>The higher the serial number is, the later the page will
                                            be shown in menu.</small></p>
                                </div>
                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <input class="form-control" name="meta_keywords" value=""
                                        placeholder="Enter meta keywords" data-role="tagsinput">
                                </div>
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description"></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the media selection modal -->
@include('admin.partials.media-selection-modal', ['mediaData' => $mediaData])

@endsection

@section('scripts')
    <script>
        // Assuming you have a Summernote or other editor instance
        var editor = $('#your-editor-element').summernote(); // Replace '#your-editor-element' with your editor's selector

        // Listen for the click event on the "Insert Media" buttons
        $('.insert-media-button').click(function() {
            var mediaId = $(this).data('media-id');
            var mediaPath = $(this).data('media-path');

            // Depending on the media type, you can insert it into the editor
            // Here's an example for inserting an image
            var imageHtml = '<img src="' + mediaPath + '" alt="Image">';
            editor.summernote('pasteHTML', imageHtml);

            // If you have different media types, you can add conditions and insert accordingly
            // For videos, audio, or documents, you can use similar logic to insert the respective HTML content.
        });
    </script>

    <script>
        function makeslug(slug) {

            var a = slug;

            var b = a.toLowerCase().replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');

            $(".set-slug").val(b);
        }

        $(document).ready(function() {

            // make input fields RTL
            $("select[name='language_id']").on('change', function() {
                $(".request-loader").addClass("show");
                let url = "{{ url('/') }}/admin/rtlcheck/" + $(this).val();
                console.log(url);
                $.get(url, function(data) {
                    $(".request-loader").removeClass("show");
                    if (data == 1) {
                        $("form input").each(function() {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form select").each(function() {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form textarea").each(function() {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form .summernote").each(function() {
                            $(this).siblings('.note-editor').find('.note-editable')
                                .addClass('rtl text-right');
                        });

                    } else {
                        $("form input, form select, form textarea").removeClass('rtl');
                        $("form .summernote").siblings('.note-editor').find('.note-editable')
                            .removeClass('rtl text-right');
                    }
                })
            });

        });
    </script>
@endsection


