@extends('admin.layout')

@php
    $selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp
@section('styles')
@endsection

@section('content')
    <div class="page-header">
        <h4 class="page-title">Inbox Account Overview</h4>
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
                <a href="#">INBOX</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card-title d-inline-block">Inbox Account Overview</div>
                        </div>
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                            <a href="{{ route('admin.inboxwebmail.add') }}" class="btn btn-primary float-right btn-sm"><i
                                    class="fas fa-plus"></i> Add New</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (count($inboxwebmails) == 0)
                                <h3 class="text-center">NO DATA FOUND</h3>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ __('Name') }}</th>
                                                <th scope="col">{{ __('Email') }}</th>
                                                <th scope="col">{{ __('Status') }}</th>
                                                <th scope="col">{{ __('Delete from server') }}</th>
                                                <th scope="col">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inboxwebmails as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ strip_tags($data->name) }} </td>
                                                    <td>{{ strip_tags($data->email) }}</td>
                                                    <td>
                                                        @if ($data->active == 1)
                                                            <span class="badge badge-success">{{ __('Active') }}</span>
                                                        @elseif($data->active == 0)
                                                            <span class="badge badge-warning">{{ __('Block') }}</span>
                                                        @else
                                                            <span class="badge badge-info">{{ __('block') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($data->d_from_server == 1)
                                                            <span class="badge badge-success">{{ __('Yes') }}</span>
                                                        @elseif($data->d_from_server == 0)
                                                            <span class="badge badge-warning">{{ __('No') }}</span>
                                                        @else
                                                            <span class="badge badge-info">{{ __('block') }}</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <a href="{{ route('admin.inboxwebmail.edit', $data->id) }}"> <button
                                                                type="button" class="btn btn-info"><i
                                                                    class="fa fa-edit"></i> {{ __('Edit') }}
                                                            </button></a>
                                                        &nbsp; <a href="{{ route('admin.inboxwebmail.delete', $data->id) }}"
                                                            onclick="return confirm('Are you sure you want to delete this account? Email of this account also will delete and no re-cover.');">
                                                            <button type="button" class="btn btn-danger"><i
                                                                    class="fa fa-remove"></i> {{ __('Delete') }}
                                                            </button></a>
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
                            {{ $inboxwebmails->links() }}
                        </div>
                    </div>
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

                } else if (id == 2) {

                    $(".media_type_img").hide();
                    $(".media_type_doc").show();
                    $(".media_type_video").hide();

                } else if (id == 3) {

                    $(".media_type_img").hide();
                    $(".media_type_doc").hide();
                    $(".media_type_video").show();
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
    </script>
@endsection
