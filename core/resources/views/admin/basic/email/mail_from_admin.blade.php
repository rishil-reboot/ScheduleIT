@extends('admin.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Mail From Admin</h4>
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
                <a href="#">Basic Settings</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Email Settings</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Mail From Admin</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <?php
                
                $abs = \App\BasicSetting::first();
                
                ?>
                <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data"
                    action="{{ route('admin.support.update') }}" method="POST">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="card-title">Update Support Informations</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5 pb-5">
                        <div class="row">
                            <div class="col-lg-6 offset-lg-3">
                                @csrf
                                <div class="form-group">
                                    <label>Email **</label>
                                    <input class="form-control ltr" name="support_email" value="{{ $abs->support_email }}"
                                        placeholder="Email">
                                    @if ($errors->has('support_email'))
                                        <p class="mb-0 text-danger">{{ $errors->first('support_email') }}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Phone **</label>
                                    <input class="form-control" name="support_phone" value="{{ $abs->support_phone }}"
                                        placeholder="Phone">
                                    @if ($errors->has('support_phone'))
                                        <p class="mb-0 text-danger">{{ $errors->first('support_phone') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer pt-3">
                        <div class="form">
                            <div class="form-group from-show-notify row">
                                <div class="col-lg-3 col-md-3 col-sm-12">

                                </div>
                                <div class="col-12 text-center">
                                    <button id="displayNotif" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">

            <div class="card">
                <form action="{{ route('admin.mailfromadmin.update') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-title">Mail From Admin</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5 pb-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-warning text-center" role="alert">
                                    <strong>This mail addres will be used to send all mails from this website.</strong>
                                </div>
                                @csrf
                                <div class="form-group">
                                    <label>SMTP Status **</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_smtp" value="1" class="selectgroup-input"
                                                {{ $abe->is_smtp == 1 ? 'checked' : '' }}>
                                            <span class="selectgroup-button">Active</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_smtp" value="0" class="selectgroup-input"
                                                {{ $abe->is_smtp == 0 ? 'checked' : '' }}>
                                            <span class="selectgroup-button">Deactive</span>
                                        </label>
                                    </div>
                                    @if ($errors->has('is_smtp'))
                                        <p class="mb-0 text-danger">{{ $errors->first('is_smtp') }}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>SMTP Auth **</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_smtp_auth" value="1" class="selectgroup-input"
                                                {{ $abe->is_smtp_auth == 1 ? 'checked' : '' }}>
                                            <span class="selectgroup-button">Active</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_smtp_auth" value="0" class="selectgroup-input"
                                                {{ $abe->is_smtp_auth == 0 ? 'checked' : '' }}>
                                            <span class="selectgroup-button">Deactive</span>
                                        </label>
                                    </div>
                                    @if ($errors->has('is_smtp_auth'))
                                        <p class="mb-0 text-danger">{{ $errors->first('is_smtp_auth') }}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                  <label for="">Mail Driver</label>
                                  <select id="mail_driver" name="mail_driver" class="form-control">
                                      <option value="">Select a Mail Driver</option>
                                      <option value="1" @if($abe->mail_driver == 1) selected @endif >SMTP</option>
                                      <option value="2" @if($abe->mail_driver == 2) selected @endif >Mail</option>
                                      <option value="3" @if($abe->mail_driver == 3) selected @endif >SendMail</option>
                                  </select>
                                  @if ($errors->has('mail_driver'))
                                      <p class="mb-0 text-danger">{{ $errors->first('mail_driver') }}</p>
                                  @endif
                              </div>

                                <div class="form-group">
                                    <label>SMTP Host **</label>
                                    <input class="form-control" name="smtp_host" value="{{ $abe->smtp_host }}">
                                    @if ($errors->has('smtp_host'))
                                        <p class="mb-0 text-danger">{{ $errors->first('smtp_host') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>SMTP Port **</label>
                                    <input class="form-control" name="smtp_port" value="{{ $abe->smtp_port }}">
                                    @if ($errors->has('smtp_port'))
                                        <p class="mb-0 text-danger">{{ $errors->first('smtp_port') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Encryption **</label>
                                    <input class="form-control" name="encryption" value="{{ $abe->encryption }}">
                                    @if ($errors->has('encryption'))
                                        <p class="mb-0 text-danger">{{ $errors->first('encryption') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>SMTP Username **</label>
                                    <input class="form-control" name="smtp_username" value="{{ $abe->smtp_username }}">
                                    @if ($errors->has('smtp_username'))
                                        <p class="mb-0 text-danger">{{ $errors->first('smtp_username') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>SMTP Password **</label>
                                    <input class="form-control" type="password" name="smtp_password"
                                        value="{{ $abe->smtp_password }}">
                                    @if ($errors->has('smtp_password'))
                                        <p class="mb-0 text-danger">{{ $errors->first('smtp_password') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>From Email **</label>
                                    <input class="form-control" type="email" name="from_mail"
                                        value="{{ $abe->from_mail }}">
                                    @if ($errors->has('from_mail'))
                                        <p class="mb-0 text-danger">{{ $errors->first('from_mail') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>From Name **</label>
                                    <input class="form-control" name="from_name" value="{{ $abe->from_name }}">
                                    @if ($errors->has('from_name'))
                                        <p class="mb-0 text-danger">{{ $errors->first('from_name') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form">
                            <div class="form-group from-show-notify row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <form action="{{ route('admin.mailfromadmin.sendTestUpdate') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-title">Send Test Mail</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5 pb-5">
                        <div class="row">
                            <div class="col-lg-12">
                                @csrf
                                <?php
                                
                                $templateArray = \App\EmailTemplate::where('status', 1)
                                    ->pluck('name', 'id')
                                    ->toArray();
                                ?>
                                <div class="form-group">
                                    <label for="">Template</label>
                                    <select id="language" name="email_template_id" class="form-control">
                                        <option value="">Select a email template</option>
                                        @foreach ($templateArray as $key => $v)
                                            <option value="{{ $key }}"
                                                @if ($abe->email_template_id == $key) selected @endif>{{ $v }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('email_template_id'))
                                        <p class="mb-0 text-danger">{{ $errors->first('email_template_id') }}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>To Email **</label>
                                    <input class="form-control" type="email" placeholder="Add email address"
                                        name="test_mail_to" value="{{ $abe->test_mail_to }}">
                                    @if ($errors->has('test_mail_to'))
                                        <p class="mb-0 text-danger">{{ $errors->first('test_mail_to') }}</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form">
                            <div class="form-group from-show-notify row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success">Send Test Mail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">

                <form class="mb-3 dm-uploader drag-and-drop-zone" enctype="multipart/form-data"
                    action="{{ route('admin.email-template.template.update-footer-section') }}" method="POST">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="card-title">Template Footer Section Content</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5 pb-5">
                        <div class="row">
                            @csrf

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="">Footer Section Content</label>
                                    <textarea class="form-control summernote" name="template_footer_content" data-height="300"
                                        placeholder="Enter template_footer_content">{!! $bs->template_footer_content !!}</textarea>
                                    <p id="errtemplate_footer_content" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer pt-3">
                        <div class="form">
                            <div class="form-group from-show-notify row">
                                <div class="col-lg-3 col-md-3 col-sm-12">

                                </div>
                                <div class="col-12 text-center">
                                    <button id="displayNotif" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('admin.basic.email.template.index', $bcategorys)

    </div>
@endsection
