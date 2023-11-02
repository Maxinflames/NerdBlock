@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Package</div>
                    <div class="panel-body">
                        <span class="help-block content">
                            <strong>Changing this data is dangerous and may cause errors!<br>(Plan to resolve this through validation, but low priority)</strong>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/packages/update">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <input type="hidden" name="package_id" value="{{ $package->package_id }}" />

                            <div class="form-group">
                                <label for="package_month" class="col-md-4 control-label">Package Month</label>

                                <div class="col-md-6">
                                    <input id="package_month" type="number" min="1" max="12"
                                        class="form-control" name="package_month" value="{{ $package->package_month }}"
                                        value="" required autofocus>

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
                                        value="{{ $package->package_year }}" value="" required>

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
                                        Update Package
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
