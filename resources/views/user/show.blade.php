@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">User Details</div>

                    <div class="panel-body">
                        <form class="form-horizontal">
                            @if (!session()->get('user_type') == 'C')
                                <div class="form-group">
                                    <label for="user_id" class="col-md-4 control-label">User ID</label>
                                    <div class="col-md-6">
                                        <input id="user_id" type="text" readonly="true" class="form-control"
                                            name="user_id" value="{{ $user->user_id }}" />
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="user_first_name" class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <input id="user_first_name" type="text" readonly="true" class="form-control"
                                        name="user_first_name" value="{{ $user->user_first_name }}" value="" required
                                        autofocus>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="user_last_name" class="col-md-4 control-label">Last Name</label>

                                <div class="col-md-6">
                                    <input id="user_last_name" type="text" readonly="true" class="form-control"
                                        name="user_last_name" value="{{ $user->user_last_name }}" value="">
                                </div>
                            </div>
                            @if ($user->user_type == 'C')
                                @if (!session()->get('user_type') == 'C')
                                    <div class="form-group">
                                        <label for="client_id" class="col-md-4 control-label">Client ID</label>

                                        <div class="col-md-6">
                                            <input id="client_id" type="text" readonly="true" class="form-control"
                                                name="client_id" value="{{ $client->client_id }}" required>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="client_country" class="col-md-4 control-label">Country</label>

                                    <div class="col-md-6">
                                        <input id="client_country" type="text" readonly="true" class="form-control"
                                            name="client_country" value="{{ $client->client_country }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="client_region" class="col-md-4 control-label">Region</label>

                                    <div class="col-md-6">
                                        <input id="client_region" type="text" readonly="true" class="form-control"
                                            name="client_region" value="{{ $client->client_region }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="client_city" class="col-md-4 control-label">City</label>

                                    <div class="col-md-6">
                                        <input id="client_city" type="text" readonly="true" class="form-control"
                                            name="client_city" value="{{ $client->client_city }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="client_address" class="col-md-4 control-label">Address</label>

                                    <div class="col-md-6">
                                        <input id="client_address" type="text" readonly="true" class="form-control"
                                            name="client_address" value="{{ $client->client_address }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="client_loc_code" class="col-md-4 control-label">Postal or Zip
                                        Code</label>

                                    <div class="col-md-6">
                                        <input id="client_region_post_code" type="text" readonly="true"
                                            class="form-control" name="client_region_post_code"
                                            value="{{ $client->client_region_post_code }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="client_country_code" class="col-md-4 control-label">Country Dialing
                                        Code</label>

                                    <div class="col-md-6">
                                        <input id="client_country_code" type="text" readonly="true"
                                            class="form-control" value="{{ $client->client_country_code }}"
                                            name="client_country_code" placeholder="X" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="client_telephone" class="col-md-4 control-label">Phone Number</label>

                                    <div class="col-md-6">
                                        <input id="client_telephone" type="text" readonly="true" class="form-control"
                                            name="client_telephone" value="{{ $client->client_telephone }}"
                                            placeholder="(XXX) XXX-XXXX" required>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="user_email_address" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="user_email_address" type="email" readonly="true" class="form-control"
                                        value="{{ $user->user_email_address }}" name="user_email_address" value=""
                                        required>
                                </div>
                            </div>
                            @if (!session()->get('user_type') == 'C')
                                <div class="form-group">
                                    @if ($user->user_type == 'E')
                                        <label class="col-md-4 control-label" for="user_type">User Type</label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="user_type" type="text" readonly="true"
                                                name="user_type" checked="true" value="Employee" tabindex="5" />
                                        </div>
                                    @elseif ($user->user_type == 'A')
                                        <label class="col-md-4 control-label" for="user_type">User Type</label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="user_type" type="text" readonly="true"
                                                name="user_type" checked="true" value="Administrator" tabindex="5" />
                                        </div>
                                    @else
                                        <label class="col-md-4 control-label" for="user_type">User Type</label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="user_type" type="text" readonly="true"
                                                name="user_type" checked="true" value="Client" tabindex="5" />
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </form>
                    </div>
                    <div class="panel panel-footer">
                        <td class="text-center">
                            <div class="center"><a class="btn btn-primary"
                                    href="/users/edit/{{ $user->user_id }}">Edit</a></div>
                        </td>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
