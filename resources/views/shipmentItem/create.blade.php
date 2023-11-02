@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form class="form-horizontal" method="POST" action="/shipment-item/create/{{ $shipment->shipment_id }}">
                    <div class="panel panel-default">
                        <div class="panel-heading">Add Item to Shipment</div>
                        <div class="panel-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <input type="hidden" name="shipment_id" value="{{ $shipment->shipment_id }}" />

                            <div class="form-group">
                                <label for="shipment_item_quantity" class="col-md-4 control-label">Shipped Quantity</label>

                                <div class="col-md-6">
                                    @if (isset($shipment_item_quantity))
                                        <input id="shipment_item_quantity" type="number" class="form-control"
                                            name="shipment_item_quantity" value="{{ $shipment_item_quantity }}" autofocus>
                                    @else
                                        <input id="shipment_item_quantity" y class="form-control"
                                            name="shipment_item_quantity" value="{{ old('shipment_item_quantity') }}"
                                            autofocus>
                                    @endif
                                    @if ($errors->has('shipment_item_quantity'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('shipment_item_quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shipment_item_unit_cost" class="col-md-4 control-label">Unit Cost</label>

                                <div class="col-md-6">
                                    @if (isset($shipment_item_unit_cost))
                                        <input id="shipment_item_unit_cost" type="number" step="0.01"
                                            class="form-control" name="shipment_item_unit_cost"
                                            value="{{ $shipment_item_unit_cost }}">
                                    @else
                                        <input id="shipment_item_unit_cost" type="number" step="0.01"
                                            class="form-control" name="shipment_item_unit_cost"
                                            value="{{ old('shipment_item_unit_cost') }}">
                                    @endif
                                    @if ($errors->has('shipment_item_unit_cost'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('shipment_item_unit_cost') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_id" class="col-md-4 control-label">Product ID</label>

                                <div class="col-md-6">
                                    @if (isset($product_id))
                                        <input id="product_id" type="text" class="form-control" name="product_id"
                                            value="{{ $product_id }}">
                                    @else
                                        <input id="product_id" type="text" class="form-control" name="product_id"
                                            value="{{ old('product_id') }}">
                                    @endif

                                    @if ($errors->has('product_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('product_id') }}</strong>
                                        </span>
                                    @elseif(session()->has('entryError'))
                                        <span class="help-block">
                                            <strong>{{ session()->pull('entryError') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" id="SubmitBtn" name="action" value="submit"
                                        class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (count($products) != 0)
                        <div class="form-group text-center">
                            <div class="text-end">
                                @if (Session::has('search_error'))
                                    <label for="search_text">{{ Session::pull('search_error') }}</label>
                                @endif
                                <input id="search_text" placeholder="Search Here..." type="text" />
                                <button name="action" value="search" class="btn btn-secondary">Search</button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
            <table class="table table-striped">
                <!-- Table column headers -->
                <tr>
                    <th class="text-center">Product ID</th>
                    <th class="text-center">Genre ID</th>
                    <th class="text-center">Product Title</th>
                    <th class="text-center">Product Description</th>
                    <th class="text-center">Current Product Cost</th>
                    <th class="text-center">Product Manufacturer</th>
                    <th class="text-center">Product Brand</th>
                    <th class="text-center">Product License</th>
                    <th class="text-center">Current Product Quantity</th>
                </tr>
                <!-- loop through database data and display for each entry -->
                @foreach ($products as $product)
                    <tr>
                        <td class="text-center">{{ $product->product_id }}</td>
                        <td class="text-center">{{ $product->genre_id }}</td>
                        <td class="text-center width-15">{{ $product->product_title }}</td>
                        <td class="text-center width-60">{{ $product->product_description }}</td>
                        <td class="text-center">${{ number_format($product->product_cost, 2, '.', ',') }}</td>
                        <td class="text-center width-15">{{ $product->product_manufacturer }}</td>
                        <td class="text-center width-15">{{ $product->product_brand }}</td>
                        <td class="text-center width-15">{{ $product->product_license }}</td>
                        <td class="text-center">{{ $product->product_quantity }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
