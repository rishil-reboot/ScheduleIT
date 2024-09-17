@extends('admin.layout')

@php
    $selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp
@if (!empty($selLang) && $selLang->rtl == 1)
    @section('styles')
        <style>
            form:not(.modal-form) input,
            form:not(.modal-form) textarea,
            form:not(.modal-form) select,
            select[name='language'] {
                direction: rtl;
            }

            form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Media</h4>
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
                <a href="#">Media Management</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="card-title d-inline-block">Media</div>
                        </div>
                        <div class="col-lg-2">
                            @if (!empty($langs))
                                <select name="language" class="form-control"
                                    onchange="window.location='{{ url()->current() . '?language=' }}'+this.value">
                                    <option value="" selected disabled>Select a Language</option>
                                    @foreach ($langs as $lang)
                                        <option value="{{ $lang->code }}"
                                            {{ $lang->code == request()->input('language') ? 'selected' : '' }}>
                                            {{ $lang->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-lg-3 offset-lg-1 mt-2 mt-lg-0">
                            <span class="label label-danger">
                                <?php $tSize = (new \App\Gallery())->getTotalMedaiFileSize(); ?>
                                <h5>Media Storage</h5>
                                <div class="badge badge-success">{{ $tSize }}</div>
                            </span>
                        </div>
                        <div class="col-lg-3 offset-lg-1 mt-2 mt-lg-0">
                            <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal"
                                data-target="#createModal"><i class="fas fa-plus"></i> Add Media</a>
                            <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete"
                                data-href="{{ route('admin.gallery.bulk.delete') }}"><i class="flaticon-interface-5"></i>
                                Delete</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($galleries) == 0)
                                <h3 class="text-center">NO IMAGE FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <input type="checkbox" class="bulk-check" data-val="all">
                                                </th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Link</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Serial Number</th>
                                                <th scope="col">Storage</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($galleries as $key => $gallery)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="bulk-check"
                                                            data-val="{{ $gallery->id }}">
                                                    </td>
                                                    <td>
                                                        @if ($gallery->media_type == 1)
                                                            <img src="{{ asset('assets/front/img/gallery/' . $gallery->image) }}"
                                                                alt="" width="80">
                                                        @elseif($gallery->media_type == 2)
                                                            <img src="{{ asset('assets/front/img/icon/doc.png') }}"
                                                                alt="video" width="80">
                                                        @elseif($gallery->media_type == 3)
                                                            @if (isset($gallery->main_image) && (strpos($gallery->main_image, 'http://') !== false || strpos($gallery->main_image, 'https://') !== false))
                                                                <a href="{{ $gallery->main_image }}">{{ $gallery->main_image }}</a>
                                                            @elseif(isset($gallery->main_image))
                                                                <img src="{{ asset('assets/front/img/videos/' . $gallery->main_image) }}"
                                                                    alt="" width="80">
                                                            @else
                                                                <img src="{{ asset('assets/front/img/icon/video.png') }}"
                                                                    alt="video" width="80">
                                                            @endif
                                                        @elseif($gallery->media_type == 4)
                                                            @if(isset($gallery->audio_thumb))
                                                                <img src="{{ asset('assets/front/img/audio/' . $gallery->audio_thumb) }}"
                                                                    alt="" width="80">
                                                            @else
                                                                <img src="{{ asset('assets/front/img/icon/audio.png') }}"
                                                                alt="video" width="80">
                                                            @endif
                                                        @endif

                                                    </td>
                                                    <td>

                                                        <?php
                                                        
                                                        $getPath = $gallery->getMediaFilePath();
                                                        
                                                        if ($getPath != '') {
                                                            $filePath = $getPath;
                                                            $target = '_blank';
                                                        } else {
                                                            $filePath = 'javascript:void';
                                                            $target = '';
                                                        }
                                                        ?>
                                                        @if ($gallery->media_type == 1)
                                                            <a href="{{ $filePath }}" target="{{ $target }}">
                                                                <span class="badge badge-primary">Image</span>
                                                            </a>
                                                        @elseif($gallery->media_type == 2)
                                                            <a href="{{ $filePath }}" target="{{ $target }}">
                                                                <span class="badge badge-secondary">Doc</span>
                                                            </a>
                                                        @elseif($gallery->media_type == 3)
                                                            <a href="{{ $filePath }}" target="{{ $target }}">
                                                                <span class="badge badge-light">Video</span>
                                                            </a>
                                                        @elseif($gallery->media_type == 4)
                                                            <a href="{{ $filePath }}" target="{{ $target }}">
                                                                <span class="badge badge-dark">Audio</span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td> <button class="btn btn-primary btn-sm copy-url"
                                                            data-url="{{ $filePath }}">
                                                            <span class="btn-label">
                                                                <i class="fas fa-copy"></i>
                                                            </span>
                                                            Copy URL
                                                        </button></td>
                                                    <td>{{ convertUtf8(strlen($gallery->title)) > 70 ? convertUtf8(substr($gallery->title, 0, 70)) . '...' : convertUtf8($gallery->title) }}
                                                    </td>
                                                    <td>{{ $gallery->serial_number }}</td>
                                                    <td>
                                                        {{ $gallery->getMedaiFileSize() }}
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-secondary btn-sm"
                                                            href="{{ route('admin.gallery.edit', $gallery->id) . '?language=' . request()->input('language') }}">
                                                            <span class="btn-label">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                            Edit
                                                        </a>
                                                        <form class="deleteform d-inline-block"
                                                            action="{{ route('admin.gallery.delete') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="gallery_id"
                                                                value="{{ $gallery->id }}">
                                                            <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                                                <span class="btn-label">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="d-inline-block mx-auto">
                            {{ $galleries->appends(['language' => request()->input('language')])->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Create Gallery Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Media</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ajaxForm" class="modal-form" action="{{ route('admin.gallery.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="radio-inline"><input class="media_type_class" type="radio" name="media_type"
                                    checked value="1"> Image </label>&nbsp;&nbsp;
                            <label class="radio-inline"><input class="media_type_class" type="radio" name="media_type"
                                    value="2"> Doc </label>
                            <label class="radio-inline"><input class="media_type_class" type="radio" name="media_type"
                                    value="3"> Video </label>
                            <label class="radio-inline"><input class="media_type_class" type="radio" name="media_type"
                                    value="4"> Audio </label>
                        </div>

                        <div class="media_type_img" style="display:none">
                            <div class="form-group">
                                <div role="button" class="btn btn-primary mr-2">
                                    <i class="fa fa-folder-o fa-fw"></i>
                                    <input type="file" name="image" title='Click to add Image' />
                                </div>
                                <p id="errimage" class="mb-0 text-danger em"></p>
                                <p class="text-warning"><small>Note. Only Png ,Jpg and JPEG files types are
                                        allowed.</small></p>
                            </div>
                        </div>

                        <div class="media_type_doc" style="display:none">
                            <div class="form-group">
                                <div role="button" class="btn btn-primary mr-2 ">
                                    <i class="fa fa-folder-o fa-fw"></i>
                                    <input type="file" name="document_file" title='Click to add Document File' />
                                </div>
                                <p id="errdocument_file" class="mb-0 text-danger em"></p>
                                <p class="text-warning"><small>Note. Only .doc , .docx , .odt , .pdf , .tex , .txt , .rtf ,
                                        .wps , .wks , .wpd files types are allowed.</small></p>
                            </div>
                        </div>

                        <div class="media_type_video" style="display:none">

                            <div class="form-group">
                                <label class="radio-inline"><input type="radio" name="is_video" value="0"
                                        checked> Video Upload</label>&nbsp;&nbsp;
                                <label class="radio-inline"><input type="radio" name="is_video" value="1"> Video
                                    url</label>
                            </div>
                            <div class="form-group" id="is_video_url" style="display: none;">
                                <label>Video Url***</label>
                                <input type="text" class="form-control" name="videoUrl" placeholder="Enter Video Url"
                                    id="is_video_url">
                            </div>
                            <div class="form-group" id="is_video_button">
                                <div class="file btn btn-md btn-primary">
                                    <input type="file" name="video_upload" />
                                    <br>
                                    <p id="errvideo_upload" class="mb-0 text-danger em"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="radio-inline"><input type="radio" name="is_thum" value="0" checked>
                                    Thumb Upload</label>&nbsp;&nbsp;
                                <label class="radio-inline"><input type="radio" name="is_thum" value="1"> Thumb
                                    url</label>
                            </div>

                            <div class="form-row px-2">
                                <div class="col-12 mb-2">
                                    <label for=""><strong>Thumb Image </strong></label>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mt-4">
                                        <input name="img_url" type="text" id="is_img_url" class="form-control"
                                            style="display: none;">
                                        <div id="is_img_button">
                                            <div role="button" class="btn btn-primary mr-2 ">
                                                <i class="fa fa-folder-o fa-fw"></i>
                                                <input type="file" name="img_upload" title='Click to add Files' />
                                            </div>
                                            <p id="errimg_upload" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="media_type_audio" style="display:none">
                            <div class="form-group">
                                <div role="button" class="btn btn-primary mr-2 ">
                                    Audio File
                                    <i class="fa fa-folder-o fa-fw"></i>
                                    <input type="file" name="audio_file" title='Click to add audio file' />
                                </div>
                                <p id="erraudio_file" class="mb-0 text-danger em"></p>
                                <p class="text-warning"><small>Note. Only .M4A , .FLAC , .MP3 , .MP4 , .WAV , .WMA , .AAC
                                        .</small></p>
                            </div>
                            <div class="form-group">
                                <div role="button" class="btn btn-primary mr-2">
                                    Thumb Image
                                    <i class="fa fa-folder-o fa-fw"></i>
                                    <input type="file" name="audio_thumb" title='Click to add thumb Image' />
                                </div>
                                <p id="erraudio_image" class="mb-0 text-danger em"></p>
                                <p class="text-warning"><small>Note. Only Png ,Jpg and JPEG files types are
                                        allowed.</small></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Language **</label>
                            <select name="language_id" class="form-control">
                                <option value="" selected disabled>Select a language</option>
                                @foreach ($langs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Title **</label>
                            <input type="text" class="form-control" name="title" placeholder="Enter title"
                                value="">
                            <p id="errtitle" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Serial Number **</label>
                            <input type="number" class="form-control ltr" name="serial_number"
                                value="{{ rand() }}" placeholder="Enter Serial Number">
                            <p id="errserial_number" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the image will be
                                    shown.</small></p>
                        </div>

                        <div class="form-group">
                            <label>Meta Keywords</label>
                            <input class="form-control" name="keyword" value="" placeholder="Enter meta keywords"
                                data-role="tagsinput">
                        </div>
                        <div class="form-group">
                            <label>Meta Description</label>
                            <textarea class="form-control" name="description" rows="5" placeholder="Enter meta description"></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {


            $(document).on("change", ".media_type_class", function() {

                changeMediaType();
            });

            function changeMediaType() {

                var id = $('.media_type_class:checked').val();

                if (id == 1) {

                    $(".media_type_img").show();
                    $(".media_type_doc").hide();
                    $(".media_type_video").hide();
                    $(".media_type_audio").hide();

                } else if (id == 2) {

                    $(".media_type_img").hide();
                    $(".media_type_doc").show();
                    $(".media_type_video").hide();
                    $(".media_type_audio").hide();

                } else if (id == 3) {

                    $(".media_type_img").hide();
                    $(".media_type_doc").hide();
                    $(".media_type_video").show();
                    $(".media_type_audio").hide();

                } else if (id == 4) {

                    $(".media_type_img").hide();
                    $(".media_type_doc").hide();
                    $(".media_type_video").hide();
                    $(".media_type_audio").show();
                }
            }

            changeMediaType();

            $("input[name='is_thum']").change(function() {
                var id = this.value;
                if (id == 1) {
                    $("#is_img_button").hide();
                    $("#is_img_url").show();
                } else {
                    $("#is_img_button").show();
                    $("#is_img_url").hide();
                }
            });

            $("input[name='is_video']").change(function() {
                var id = this.value;
                if (id == 1) {
                    $("#is_video_button").hide();
                    $("#is_video_url").show();
                } else {
                    $("#is_video_url").hide();
                    $("#is_video_button").show();

                }
            });

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
                        $("form .nicEdit-main").each(function() {
                            $(this).addClass('rtl text-right');
                        });

                    } else {
                        $("form input, form select, form textarea").removeClass('rtl');
                        $("form .nicEdit-main").removeClass('rtl text-right');
                    }
                })
            });

        });


        function copyURLToClipboard(urlToCopy) {
            // Create a temporary input element to copy the URL to clipboard
            const tempInput = document.createElement('input');
            document.body.appendChild(tempInput);
            tempInput.value = urlToCopy;
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            // Show a success message
            const successMessage = document.createElement('div');
            successMessage.classList.add('alert', 'alert-success', 'mt-2');
            successMessage.textContent = 'URL copied to clipboard!';
            this.parentElement.appendChild(successMessage);

            // Remove the success message after a few seconds
            setTimeout(function() {
                successMessage.remove();
            }, 3000);
        }

        // Add a click event listener to all "Copy URL" buttons
        const copyButtons = document.querySelectorAll('.copy-url');

        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const urlToCopy = this.getAttribute('data-url');

                // Call the copyURLToClipboard function
                copyURLToClipboard(urlToCopy);
            });
        });
    </script>
@endsection
