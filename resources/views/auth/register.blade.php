@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/register">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group">
                                <label for="user_first_name" class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <input id="user_first_name" type="text" class="form-control" name="user_first_name"
                                        value="{{ old('user_first_name') }}" value="" autofocus>

                                    @if ($errors->has('user_first_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_last_name" class="col-md-4 control-label">Last Name</label>

                                <div class="col-md-6">
                                    <input id="user_last_name" type="text" class="form-control" name="user_last_name"
                                        value="{{ old('user_last_name') }}" value="">

                                    @if ($errors->has('user_last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_country" class="col-md-4 control-label">Country</label>

                                <div class="col-md-6">
                                    <input id="client_country" type="text" class="form-control" name="client_country"
                                        value="{{ old('client_country') }}">

                                    @if ($errors->has('client_country'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('client_country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_region" class="col-md-4 control-label">Region</label>

                                <div class="col-md-6">
                                    <input id="client_region" type="text" class="form-control" name="client_region"
                                        value="{{ old('client_region') }}">

                                    @if ($errors->has('client_region'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('client_region') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_city" class="col-md-4 control-label">City</label>

                                <div class="col-md-6">
                                    <input id="client_city" type="text" class="form-control" name="client_city"
                                        value="{{ old('client_city') }}">

                                    @if ($errors->has('client_city'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('client_city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_address" class="col-md-4 control-label">Address</label>

                                <div class="col-md-6">
                                    <input id="client_address" type="text" class="form-control" name="client_address"
                                        value="{{ old('client_address') }}">

                                    @if ($errors->has('client_address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('client_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_loc_code" class="col-md-4 control-label">Postal or Zip
                                    Code</label>

                                <div class="col-md-6">
                                    <input id="client_region_post_code" type="text" class="form-control"
                                        name="client_region_post_code" value="{{ old('client_region_post_code') }}"
                                       >

                                    @if ($errors->has('client_region_post_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('client_region_post_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_country_code" class="col-md-4 control-label">Country Dialing
                                    Code</label>

                                <div class="col-md-6">
                                    <input id="client_country_code" type="text" class="form-control"
                                        value="{{ old('client_country_code') }}" name="client_country_code" placeholder="X"
                                       >

                                    @if ($errors->has('client_country_code'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('client_country_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_telephone" class="col-md-4 control-label">Phone Number</label>

                                <div class="col-md-6">
                                    <input id="client_telephone" type="text" class="form-control"
                                        name="client_telephone" value="{{ old('client_telephone') }}"
                                        placeholder="(XXX) XXX-XXXX">

                                    @if ($errors->has('client_telephone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('client_telephone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_email_address" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="user_email_address" type="email" class="form-control"
                                        value="{{ old('user_email_address') }}" name="user_email_address" value="">

                                    @if ($errors->has('user_email_address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_email_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="user_password" type="password" class="form-control" name="user_password">

                                    @if ($errors->has('user_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
