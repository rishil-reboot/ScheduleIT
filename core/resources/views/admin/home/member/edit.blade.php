@extends('admin.layout')

@if (!empty($member->language) && $member->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select {
                direction: rtl;
            }

            .nicEdit-main {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Edit Member</h4>
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
                <a href="#">Edit Member</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-inline-block">Edit Member</div>
                    <a class="btn btn-info btn-sm float-right d-inline-block"
                        href="{{ route('admin.member.index') . '?language=' . request()->input('language') }}">
                        <span class="btn-label">
                            <i class="fas fa-backward" style="font-size: 12px;"></i>
                        </span>
                        Back
                    </a>
                    <a style="margin-right:10px" class="btn btn-secondary btn-sm get-my-preview float-right d-inline-block" data-id="{{$member->id}}" href="javascript:void(0)">
                        <span class="btn-label">
                            <i class="fas fa-eye"></i>
                        </span>
                        Preview
                    </a>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data"
                                action="{{ route('admin.member.uploadUpdate', $member->id) }}" method="POST">
                                @csrf
                                <div class="form-row px-2">
                                    <div class="col-12 mb-2">
                                        <label for=""><strong>Image **</strong></label>
                                    </div>
                                    <div class="col-md-12 d-md-block d-sm-none mb-3">
                                        <img src="{{ asset('assets/front/img/members/' . $member->image) }}" alt="..."
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
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form id="ajaxForm" class="" action="{{ route('admin.member.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="member_id" value="{{ $member->id }}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Name **</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $member->name }}" placeholder="Enter name">
                                            <p id="errname" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">URL Slug **</label>
                                            <input type="text" class="form-control" name="slug"
                                                placeholder="Enter SEO Friendly URL Slug" value="{{ $member->slug }}">
                                            <p id="errslug" class="em text-danger mb-0"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Rank **</label>
                                            <input type="text" class="form-control" name="rank"
                                                value="{{ $member->rank }}" placeholder="Enter rank">
                                            <p id="errrank" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Facebook</label>
                                            <input type="text" class="form-control ltr" name="facebook"
                                                value="{{ $member->facebook }}" placeholder="Enter facebook url">
                                            <p id="errfacebook" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Facebook **</label>
                                            <div class="selectgroup w-100">
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_facebook" @if($member->display_facebook == 1) checked @endif value="1" class="selectgroup-input">
                                                      <span class="selectgroup-button">Active</span>
                                                  </label>
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_facebook" @if($member->display_facebook == 0) checked @endif value="0" class="selectgroup-input">
                                                      <span class="selectgroup-button">Deactive</span>
                                                  </label>
                                              </div>
                                          </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Twitter</label>
                                            <input type="text" class="form-control ltr" name="twitter"
                                                value="{{ $member->twitter }}" placeholder="Enter twitter url">
                                            <p id="errtwitter" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Twitter **</label>
                                            <div class="selectgroup w-100">
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_twitter" @if($member->display_twitter == 1) checked @endif value="1" class="selectgroup-input" >
                                                      <span class="selectgroup-button">Active</span>
                                                  </label>
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_twitter" @if($member->display_twitter == 0) checked @endif value="0" class="selectgroup-input">
                                                      <span class="selectgroup-button">Deactive</span>
                                                  </label>
                                              </div>
                                          </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Instagram</label>
                                            <input type="text" class="form-control ltr" name="instagram"
                                                value="{{ $member->instagram }}" placeholder="Enter instagram url">
                                            <p id="errinstagram" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Instagram **</label>
                                            <div class="selectgroup w-100">
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_instagram" @if($member->display_instagram == 1) checked @endif value="1" class="selectgroup-input" >
                                                      <span class="selectgroup-button">Active</span>
                                                  </label>
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_instagram" @if($member->display_instagram == 0) checked @endif value="0" class="selectgroup-input">
                                                      <span class="selectgroup-button">Deactive</span>
                                                  </label>
                                              </div>
                                          </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Linkedin</label>
                                            <input type="text" class="form-control ltr" name="linkedin"
                                                value="{{ $member->linkedin }}" placeholder="Enter linkedin url">
                                            <p id="errlinkedin" class="mb-0 text-danger em"></p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Linkedin **</label>
                                            <div class="selectgroup w-100">
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_linkedin" @if($member->display_linkedin == 1) checked @endif value="1" class="selectgroup-input" >
                                                      <span class="selectgroup-button">Active</span>
                                                  </label>
                                                  <label class="selectgroup-item">
                                                      <input type="radio" name="display_linkedin" @if($member->display_linkedin == 0) checked @endif value="0" class="selectgroup-input">
                                                      <span class="selectgroup-button">Deactive</span>
                                                  </label>
                                              </div>
                                          </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="">Body **</label>
                                    <textarea id="body" class="form-control summernote" name="body" data-height="500">{{ replaceBaseUrl($member->body) }}</textarea>
                                    <p id="errbody" class="em text-danger mb-0"></p>
                                </div>
                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <input class="form-control" name="meta_keywords"
                                        value="{{ $member->meta_keywords }}" placeholder="Enter meta keywords"
                                        data-role="tagsinput">
                                </div>
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{ $member->meta_description }}</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
                                <a class="btn btn-secondary get-my-preview" data-id="{{$member->id}}" href="javascript:void(0)">
                                    <span class="btn-label">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    Preview
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="preview-data"></div>
<!-- Include the media selection modal -->
@include('admin.partials.media-selection-modal', ['mediaData' => $mediaData])
@endsection
@section('scripts')
    @include('admin.home.member.common-script')
@endsection