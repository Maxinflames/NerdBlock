@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit User</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/users/update">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            @if (!session()->get('user_type') == 'C')
                                <input type="hidden" name="user_id" value="{{ $user->user_id }}" />
                            @endif
                            
                            <div class="form-group">
                                <label for="user_first_name" class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <input id="user_first_name" type="text" class="form-control" name="user_first_name"
                                        value="{{ $user->user_first_name }}" value="" required autofocus>

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
                                        value="{{ $user->user_last_name }}" value="">

                                    @if ($errors->has('user_last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if ($user->user_type == 'C')
                                <input type="hidden" name="client_id" value="{{ $client->client_id }}" />

                                <div class="form-group">
                                    <label for="client_country" class="col-md-4 control-label">Country</label>

                                    <div class="col-md-6">
                                        <input id="client_country" type="text" class="form-control" name="client_country"
                                            value="{{ $client->client_country }}" required>

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
                                            value="{{ $client->client_region }}" required>

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
                                            value="{{ $client->client_city }}" required>

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
                                            value="{{ $client->client_address }}" required>

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
                                            name="client_region_post_code" value="{{ $client->client_region_post_code }}"
                                            required>

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
                                            value="{{ $client->client_country_code }}" name="client_country_code"
                                            placeholder="X" required>

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
                                            name="client_telephone" value="{{ $client->client_telephone }}"
                                            placeholder="(XXX) XXX-XXXX" required>

                                        @if ($errors->has('client_telephone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('client_telephone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if (!session()->get('user_type') == 'C')
                                <div class="form-group">
                                    <label for="user_email_address" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="user_email_address" type="email" class="form-control"
                                            value="{{ $user->user_email_address }}" name="user_email_address"
                                            value="" required>

                                        @if ($errors->has('user_email_address'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('user_email_address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="user_password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="user_password" type="password" class="form-control" name="user_password"
                                        placeholder="Leave blank to keep current password">

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

                            @if (!session()->get('user_type') == 'C')
                                @if ($user->user_type != 'C')
                                    <div class="content form-group">
                                        @if ($user->user_type == 'E')
                                            <input class="radio-input" id="type1" type="radio" name="user_type"
                                                checked="true" value="E" tabindex="5" />
                                            <label class="radio-label" for="type1">Employee</label>

                                            <input class="radio-input" id="type2" type="radio" name="user_type"
                                                value="A" tabindex="6" />
                                            <label class="radio-label" for="type2">Administrator</label><br>
                                        @else
                                            <input class="radio-input" id="type1" type="radio" name="user_type"
                                                value="E" tabindex="5" />
                                            <label class="radio-label" for="type1">Employee</label>

                                            <input class="radio-input" id="type2" type="radio" name="user_type"
                                                checked="true" value="A" tabindex="6" />
                                            <label class="radio-label" for="type2">Administrator</label><br>
                                        @endif
                                    </div>
                                    @if ($errors->has('user_type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('user_type') }}</strong>
                                        </span>
                                    @endif
                                @else
                                    <input type="hidden" name="user_type" value="C" />
                                @endif
                            @else
                                <input type="hidden" name="user_type" value="C" />
                            @endif

                            <div class="form-group">
                                <div class="content">
                                    <button type="submit" tabindex="7" class="btn btn-primary">
                                        Update User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel panel-footer">
                        <td class="text-center">
                            <div class="center"><a class="btn btn-primary" href="/users/{{ $user->user_id }}">View</a>
                            </div>
                        </td>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
