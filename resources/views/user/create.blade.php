@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register User</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/users">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group">
                                <label for="user_first_name" class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <input id="user_first_name" type="text" class="form-control" name="user_first_name"
                                        value="{{ old('user_first_name') }}" tabindex="0" required autofocus>

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
                                        value="{{ old('user_last_name') }}" tabindex="1">

                                    @if ($errors->has('user_last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_email_address" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="user_email_address" type="email" class="form-control"
                                        value="{{ old('user_email_address') }}" name="user_email_address"
                                        tabindex="2" required>

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
                                    <input id="user_password" type="password" class="form-control" name="user_password"
                                    tabindex="3" required>

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
                                        name="password_confirmation" tabindex="4" required>
                                </div>
                            </div>

                            <div class="content form-group">
                                <input class="radio-input" id="type1" type="radio" name="user_type" checked="true"
                                    value="E" tabindex="5" />
                                <label class="radio-label" for="type1">Employee</label>
                            
                                <input class="radio-input" id="type2" type="radio" name="user_type" value="A" tabindex="6"/>
                                <label class="radio-label" for="type2">Administrator</label><br>
                            </div>
                            @if ($errors->has('user_type'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('user_type') }}</strong>
                                </span>
                            @endif

                            <div class="form-group">
                                <div class="content">
                                    <button type="submit" tabindex="7" class="btn btn-primary">
                                        Register User
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
