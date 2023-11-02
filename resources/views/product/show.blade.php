@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                <th class="text-center">Product ID</th>
                <th class="text-center">Genre ID</th>
                <th class="text-center">Product Title</th>
                <th class="text-center">Product Description</th>
                <th class="text-center">Product Cost</th>
                <th class="text-center">Product Manufacturer</th>
                <th class="text-center">Product Brand</th>
                <th class="text-center">Product License</th>
                <th class="text-center">Product Quantity</th>
            </tr>
            <tr>
                <td class="text-center">{{ $product_data->product_id }}</td>
                <td class="text-center">{{ $product_data->genre_id }}</td>
                <td class="text-center width-15">{{ $product_data->product_title }}</td>
                <td class="text-center width-60">{{ $product_data->product_description }}</td>
                <td class="text-center">${{ number_format($product_data->product_cost, 2, '.', ',') }}</td>
                <td class="text-center width-15">{{ $product_data->product_manufacturer }}</td>
                <td class="text-center width-15">{{ $product_data->product_brand }}</td>
                <td class="text-center width-15">{{ $product_data->product_license }}</td>
                <td class="text-center">{{ $product_data->product_quantity }}</td>
            </tr>
        </table>

        <div class="center d-flex">
            @if (session()->get('user_type') == 'A')
                <a class="btn btn-secondary" href="/products/edit/{{ $product_data->product_id }}">Edit Product</a>
            @endif
            @if ($product_data->packaged_item_id != null)
                <a class="btn btn-secondary" href="/packages/{{ $product_data->package_id }}">View Associated Package</a>
            @else
                @if (session()->get('user_type') == 'A')
                    <a class="btn btn-secondary" href="/packageItem/assign/{{ $product_data->product_id }}">Assign to
                        Package</a>
                @endif
            @endif
        </div>
        <br />
        <div>
            <table class="table table-striped">
                <!-- Table column headers -->
                <tr>
                    <th class="text-center">Shipment ID</th>
                    <th class="text-center">Shipment Date</th>
                    <th class="text-center">Shipment Destination</th>
                    <th class="text-center">Shipped Quantity</th>
                    <th class="text-center">Unit Cost</th>
                </tr>
                @foreach ($associated_shipments as $shipment)
                    <tr>
                        <td class="text-center">{{ $shipment->shipment_id }}</td>
                        <td class="text-center">{{ $shipment->shipment_date }}</td>
                        <td class="text-center width-15">{{ $shipment->shipment_destination }}</td>
                        <td class="text-center width-15">{{ $shipment->shipment_item_quantity }}</td>
                        <td class="text-center">{{ $shipment->shipment_item_unit_cost }}</td>
                        <td class="text-center width-5"><a class="btn btn-secondary"
                                href="/shipments/{{ $shipment->shipment_id }}">View</a></td>
                        @if (session()->get('user_type') == 'A')
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/shipments/edit/{{ $shipment->shipment_id }}">Edit</a></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
