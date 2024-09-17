@extends('admin.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Add Member</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Home Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Add Member</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Add Member</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                        href="{{ route('admin.member.index') . '?language=' . request()->input('language') }}">
                        <span class="btn-label">
                            <i class="fas fa-backward" style="font-size: 12px;"></i>
                        </span>
                        Back
                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data"
                                action="{{ route('admin.member.upload') }}" method="POST">
                                <div class="form-row px-2">
                                    <div class="col-12 mb-2">
                                        <label for=""><strong>Image **</strong></label>
                                    </div>
                                    <div class="col-md-12 d-md-block d-sm-none mb-3">
                                        <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="..."
                                            class="img-thumbnail">
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="from-group mb-2">
                                            <input type="text" class="form-control progressbar"
                                                aria-describedby="fileHelp" placeholder="No image uploaded..."
                                                readonly="readonly" />

                                            <div class="progress mb-2 d-none">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                                    role="progressbar" style="width: 0%;" aria-valuenow="0"
                                                    aria-valuemin="0" aria-valuemax="0">
                                                    0%
                                                </div>
                                            </div>

                                        </div>

                                        <div class="mt-4">
                                            <div role="button" class="btn btn-primary mr-2">
                                                <i class="fa fa-folder-o fa-fw"></i> Browse Files
                                                <input type="file" title='Click to add Files' />
                                            </div>
                                            <small class="status text-muted">Select a file or drag it over this
                                                area..</small>
                                            <p class="em text-danger mb-0" id="errmember_image"></p>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form id="ajaxForm" class="" action="{{ route('admin.member.store') }}" method="POST">
                                @csrf
                                <input type="hidden" id="image" name="" value="">
                                <div class="row">
                                    <div class="col-lg-6">
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
                                    </div>
                                    {{-- <div class="form-group">
                                    <label for="">Name **</label>
                                    <input type="text" class="form-control" name="name" value=""
                                        placeholder="Enter name">
                                    <p id="errname" class="mb-0 text-danger em"></p>
                                </div> --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Name **</label>
                                            <input type="text" name="name" onkeyup="makeslug(this.value)"
                                                class="form-control" placeholder="Enter Name">
                                            <p id="errname" class="em text-danger mb-0"></p>
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
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Rank **</label>
                                            <input type="text" class="form-control" name="rank" value=""
                                                placeholder="Enter rank">
                                            <p id="errrank" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Facebook</label>
                                            <input type="text" class="form-control ltr" name="facebook"
                                                value="" placeholder="Enter facebook url">
                                            <p id="errfacebook" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Facebook **</label>
                                            <div class="selectgroup w-100">
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_facebook" value="1" class="selectgroup-input" checked>
                                                      <span class="selectgroup-button">Active</span>
                                                  </label>
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_facebook" value="0" class="selectgroup-input">
                                                      <span class="selectgroup-button">Deactive</span>
                                                  </label>
                                              </div>
                                          </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Twitter</label>
                                            <input type="text" class="form-control ltr" name="twitter" value=""
                                                placeholder="Enter twitter url">
                                            <p id="errtwitter" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Twitter **</label>
                                            <div class="selectgroup w-100">
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_twitter" value="1" class="selectgroup-input" checked>
                                                      <span class="selectgroup-button">Active</span>
                                                  </label>
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_twitter" value="0" class="selectgroup-input">
                                                      <span class="selectgroup-button">Deactive</span>
                                                  </label>
                                              </div>
                                          </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Instagram</label>
                                            <input type="text" class="form-control ltr" name="instagram"
                                                value="" placeholder="Enter instagram url">
                                            <p id="errinstagram" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Instagram **</label>
                                            <div class="selectgroup w-100">
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_instagram" value="1" class="selectgroup-input" checked>
                                                      <span class="selectgroup-button">Active</span>
                                                  </label>
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_instagram" value="0" class="selectgroup-input">
                                                      <span class="selectgroup-button">Deactive</span>
                                                  </label>
                                              </div>
                                          </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Linkedin</label>
                                            <input type="text" class="form-control ltr" name="linkedin"
                                                value="" placeholder="Enter linkedin url">
                                            <p id="errlinkedin" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Linkedin **</label>
                                            <div class="selectgroup w-100">
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_linkedin" value="1" class="selectgroup-input" checked>
                                                      <span class="selectgroup-button">Active</span>
                                                  </label>
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_linkedin" value="0" class="selectgroup-input">
                                                      <span class="selectgroup-button">Deactive</span>
                                                  </label>
                                              </div>
                                          </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="">Body **</label>
                                    <textarea id="body" class="form-control summernote" name="body" data-height="500"></textarea>
                                    <p id="errbody" class="em text-danger mb-0"></p>
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
        function makeslug(slug) {

            var a = slug;

            var b = a.toLowerCase().replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');

            $(".set-slug").val(b);
        }

        $(document).ready(function() {
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
                    } else {
                        $("form input, form select, form textarea").removeClass('rtl');
                    }
                })
            });
        });
    </script>
@endsection
