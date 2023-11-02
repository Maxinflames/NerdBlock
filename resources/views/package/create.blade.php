@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Package</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/packages">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group">
                                <label for="package_month" class="col-md-4 control-label">Package Month</label>

                                <div class="col-md-6">
                                    <input id="package_month" type="number" class="form-control" name="package_month"
                                        value="{{ old('package_month') }}" placeholder="January = 1, February = 2, Etc..." autofocus>

                                    @if ($errors->has('package_month'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('package_month') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="package_year" class="col-md-4 control-label">Package Year</label>

                                <div class="col-md-6">
                                    <input id="package_year" type="number" class="form-control" name="package_year"
                                        value="{{ old('package_year') }}">

                                    @if ($errors->has('package_year'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('package_year') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
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
