@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Shipment</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/shipments">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group">
                                <label for="shipment_date" class="col-md-4 control-label">Shipment Date</label>

                                <div class="col-md-6">
                                    <input id="shipment_date" type="text" class="form-control" name="shipment_date"
                                        value="{{ old('shipment_date') }}" placeholder="YYYY-MM-DD" autofocus>

                                    @if (session()->has('ShipmentDateError'))
                                        <span class="help-block">
                                            <strong>{{ session()->pull('ShipmentDateError') }}</strong>
                                        </span>
                                    @endif
                                    @if ($errors->has('shipment_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('shipment_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shipment_destination" class="col-md-4 control-label">Shipment
                                    Destination</label>

                                <div class="col-md-6">
                                    <input id="shipment_destination" type="text" class="form-control"
                                        name="shipment_destination" value="{{ old('shipment_destination') }}">

                                    @if ($errors->has('shipment_destination'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('shipment_destination') }}</strong>
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
