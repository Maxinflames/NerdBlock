@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <tr>
                <th class="text-center">Package ID</th>
                <th class="text-center">Package Month</th>
                <th class="text-center">Package Year</th>
                <th class="text-center">Package Genre</th>
            </tr>
            <tr>
                <td class="text-center">{{ $package->package_id }}</td>
                <td class="text-center">{{ $package->package_month }}</td>
                <td class="text-center">{{ $package->package_year }}</td>
                <td class="text-center">{{ $package->genre_title }}</td>
            </tr>
        </table>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Enter Rating</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/sent_package/update">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="sent_package_id" value="{{ $sent_package->sent_package_id }}" />
                            <input type="hidden" name="subscription_id" value="{{ $sent_package->subscription_id }}" />

                            <div class="form-group">
                                <label for="sent_package_rating" class="col-md-4 control-label">Rating</label>

                                <div class="col-md-6">
                                    <input id="sent_package_rating" type="number" class="form-control"
                                        name="sent_package_rating" value="{{ $sent_package->sent_package_rating }}"
                                        min="1" max="5" placeholder="1-5" autofocus>

                                    @if ($errors->has('sent_package_rating'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('sent_package_rating') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sent_package_rating_description" class="col-md-4 control-label">Reason for
                                    Rating</label>

                                <div class="col-md-6">
                                    <textarea rows="4" id="sent_package_rating_description" type="text" class="form-control"
                                        name="sent_package_rating_description" placeholder="Description of reason for your Rating" required>{{ $sent_package->sent_package_rating_description }}</textarea>


                                    @if ($errors->has('sent_package_rating_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('sent_package_rating_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="center">
                                    <button type="submit" class="btn btn-primary">
                                        Update Rating
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
