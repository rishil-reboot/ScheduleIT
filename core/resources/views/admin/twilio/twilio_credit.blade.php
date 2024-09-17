@extends('admin.layout')
@section('content')
<div class="page-header">
    <h4 class="page-title">Twilio Creds</h4>
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
            <a href="#">Twilio Settings</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Message From Admin</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-6">

        <div class="card">
            <form action="{{ route('admin.twilio.update') }}" method="post">
                @csrf
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-title">Message From Admin</div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-warning text-center" role="alert">
                                <strong>This number will be used to send all message from this website.</strong>
                            </div>
                            @csrf
                            <div class="form-group">
                                <label>Twilio Status **</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="is_twilio" value="1" class="selectgroup-input" {{ $abe->is_twilio == 1 ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="is_twilio" value="0" class="selectgroup-input" {{ $abe->is_twilio == 0 ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Deactive</span>
                                    </label>
                                </div>
                                @if ($errors->has('is_twilio'))
                                <p class="mb-0 text-danger">{{ $errors->first('is_twilio') }}</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>TWILIO AUTH TOKEN **</label>
                                <input class="form-control" type="password" name="auth_token" value="{{ $credit->auth_token }}">
                                @if ($errors->has('auth_token'))
                                <p class="mb-0 text-danger">{{ $errors->first('auth_token') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>TWILIO ACCOUNT SID **</label>
                                <input class="form-control" type="password" name="account_sid" value="{{ $credit->account_sid }}">
                                @if ($errors->has('account_sid'))
                                <p class="mb-0 text-danger">{{ $errors->first('account_sid') }}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>TWILIO PHONE NUMBER**</label>
                                <input class="form-control" name="phone_number" value="{{ $credit->phone_number }}">
                                @if ($errors->has('phone_number'))
                                <p class="mb-0 text-danger">{{ $errors->first('phone_number') }}</p>
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
            <form action="{{ route('admin.twilio.sendTestUpdate') }}" method="post">
                @csrf
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-title">Send Test Message</div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-12">
                            @csrf
                            <div class="form-group">
                                <label>From **</label>
                                <input class="form-control" name="from" value="{{$credit->from}}">
                                @if ($errors->has('from'))
                                <p class="mb-0 text-danger">{{$errors->first('from')}}</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Message **</label>
                                <textarea class="form-control" name="message" rows="5" placeholder="Enter message">{{$credit->message}}</textarea>
                            </div>

                            <div class="form-group">
                                <label>To **</label>
                                <input class="form-control" name="to" value="{{$credit->to}}" placeholder="Recipient Number" data-role="tagsinput">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success">Send Message</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('admin.twilio.verifyTextUpdate') }}" method="post">
                @csrf
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-title">Verify Text</div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Verify Page Text **</label>
                                <textarea class="form-control" name="verify_page_text" rows="2" placeholder="Enter text">{{$credit->verify_page_text}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success">Update Text</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection