@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="center">
                <h1>Package Reports</h1>
                <div class="panel panel-default">
                    <div class="panel-heading">Generate Package Report</div>

                    <div class="panel-heading">
                        <p>All time will ignore all date entries.<br />Yearly will ignore month and day
                            entries.<br />Monthly will ignore
                            day entries.<br />Enter data as needed.</p>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/reports/packages">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="content form-group">
                                <input class="radio-input" id="timeframe1" type="radio" name="timeframe" checked="true"
                                    value="All" />
                                <label class="radio-label" for="timeframe1">All Time</label>

                                <input class="radio-input" id="timeframe2" type="radio" name="timeframe" value="Yearly" />
                                <label class="radio-label" for="timeframe2">Yearly</label>

                                <input class="radio-input" id="timeframe3" type="radio" name="timeframe"
                                    value="Monthly" />
                                <label class="radio-label" for="timeframe3">Monthly</label>

                                <input class="radio-input" id="timeframe4" type="radio" name="timeframe" value="Daily" />
                                <label class="radio-label" for="timeframe4">Daily</label><br>
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
                                    <label for="package_end_date" class="col-md-4 control-label">End Date</label>

                                    <div class="col-md-4">
                                        <input id="package_end_date" type="text" class="form-control"
                                            name="package_end_date" value="{{ old('package_end_date') }}"
                                            placeholder="YYYY-MM-DD">

                                        @if ($errors->has('package_end_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('package_end_date') }}</strong>
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
    </div>
@endsection
