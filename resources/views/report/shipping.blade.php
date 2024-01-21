@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center">
            <h1>Shipping Report</h1>
            <div class="panel panel-default">
                <form method="POST" action="/reports/shipping">
                    {{ csrf_field() }}
                    <div class="panel-heading">Generate Shipping Report</div>

                    <div class="content form-group">
                        <input class="radio-input" id="type1" type="radio" name="shipment_outgoing" checked="true"
                            value="all" />
                        <label class="radio-label" for="type1">All</label>

                        <input class="radio-input" id="type2" type="radio" name="shipment_outgoing" value="1" />
                        <label class="radio-label" for="type2">Outgoing</label>

                        <input class="radio-input" id="type3" type="radio" name="shipment_outgoing" value="0" />
                        <label class="radio-label" for="type3">Incoming</label><br>
                    </div>

                    <div class="panel-body">
                        <div class="content">
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <label for="shipment_start_date" class="col-md-4 control-label">Start Date</label>

                                    <div class="col-md-4">
                                        <input id="shipment_start_date" type="text" class="form-control"
                                            name="shipment_start_date" value="{{ old('shipment_start_date') }}"
                                            placeholder="YYYY-MM-DD">

                                        @if ($errors->has('shipment_start_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('shipment_start_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <label for="shipment_end_date" class="col-md-4 control-label">End Date</label>

                                    <div class="col-md-4">
                                        <input id="shipment_end_date" type="text" class="form-control"
                                            name="shipment_end_date" value="{{ old('shipment_end_date') }}"
                                            placeholder="YYYY-MM-DD">

                                        @if ($errors->has('shipment_end_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('shipment_end_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if (Session::has('entry_error'))
                                <label>{{ Session::pull('entry_error') }}</label>
                            @endif

                        </div>

                    </div>
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
@endsection
