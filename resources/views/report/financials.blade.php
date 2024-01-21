@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center">
            <h1>Sales Reports</h1>
            <div class="panel panel-default">
                <div class="panel-heading">Generate Package Report</div>

                <div class="panel-heading">
                    <p>Quarterly will start at the beginning of the closest quarter by given month.</p>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/reports/financials">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="content form-group">
                            <input class="radio-input" id="timeframe1" type="radio" name="timeframe" value="Year"
                                checked="true" />
                            <label class="radio-label" for="timeframe1">Yearly</label>

                            <input class="radio-input" id="timeframe2" type="radio" name="timeframe" value="Quarter" />
                            <label class="radio-label" for="timeframe2">Quarterly</label>

                            <input class="radio-input" id="timeframe3" type="radio" name="timeframe" value="Month" />
                            <label class="radio-label" for="timeframe3">Monthly</label>

                            <input class="radio-input" id="timeframe4" type="radio" name="timeframe" value="Week" />
                            <label class="radio-label" for="timeframe4">Weekly</label><br>
                        </div>

                        @if ($errors->has('timeframe'))
                            <span class="help-block">
                                <strong>{{ $errors->first('timeframe') }}</strong>
                            </span>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <label for="package_start_date" class="col-md-4 control-label">Start Date</label>

                                <div class="col-md-4">
                                    <input id="package_start_date" type="text" class="form-control"
                                        name="package_start_date" value="{{ old('package_start_date') }}"
                                        placeholder="YYYY-MM-DD">

                                    @if ($errors->has('package_start_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('package_start_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <label for="set_count" class="col-md-4 control-label">Number of Sets</label>

                                <div class="col-md-4">
                                    <input id="set_count" type="number" class="form-control" name="set_count"
                                        placeholder="Default: until now." value="{{ old('set_count') }}" min="1">

                                    @if ($errors->has('set_count'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('set_count') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if (Session::has('entry_error'))
                            <label>{{ Session::pull('entry_error') }}</label>
                        @endif

                        <div class="form-group">
                            <div class="Center">
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
@endsection
