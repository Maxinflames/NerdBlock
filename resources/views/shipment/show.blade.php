@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Checks if there are any posts to display, if not, notifies the user -->

        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                <th class="text-center">Shipment ID</th>
                <th class="text-center">Shipment Date</th>
                <th class="text-center">Shipment Destination</th>
            </tr>
            <tr>
                <td class="text-center">{{ $shipment->shipment_id }}</td>
                <td class="text-center">{{ $shipment->shipment_date }}</td>
                <td class="text-center">{{ $shipment->shipment_destination }}</td>
            </tr>
        </table>

        @if (count($associated_products) == 0)
            <p class="text-center">Currently there are no associated products!</p>
        @endif
        <div class="form-group text-center">
            @if (Session::has('active_user'))
                @if (session()->get('user_type') == 'A')
                    <a href="/shipments/edit/{{ $shipment->shipment_id }}" class="btn btn-primary">Edit Shipment</a>
                    <a href="/shipment-item/create/{{ $shipment->shipment_id }}" class="btn btn-primary">Add Product to Shipment</a>
                @endif
            @endif
        </div>
    </div>
    <table class="table table-striped">
        <!-- Table column headers -->
        <tr>
            <th class="text-center">Shipment Item ID</th>
            <th class="text-center">Quantity Shipped</th>
            <th class="text-center">Unit Cost</th>
            <th></th>
            <th class="text-center">Product ID</th>
            <th class="text-center">Genre ID</th>
            <th class="text-center">Product Title</th>
            <th class="text-center">Product Description</th>
            <th class="text-center">Product Manufacturer</th>
            <th class="text-center">Product Brand</th>
            <th class="text-center">Product License</th>
        </tr>
        <!-- loop through database data and display for each entry -->
        @foreach ($associated_products as $product)
            <tr>
                <td class="text-center">{{ $product->shipment_item_id }}</td>
                <td class="text-center">{{ $product->shipment_item_quantity }}</td>
                <td class="text-center">${{ number_format($product->shipment_item_unit_cost, 2, '.', ',') }}</td>
                @if (session()->get('user_type') == 'A')
                    <td class="text-center width-5"><a class="btn btn-secondary"
                            href="#NotImplemented">Edit</a></td>
                @endif
                <td class="text-center">{{ $product->product_id }}</td>
                <td class="text-center">{{ $product->genre_id }}</td>
                <td class="text-center width-15">{{ $product->product_title }}</td>
                <td class="text-center width-60">{{ $product->product_description }}</td>
                <td class="text-center width-15">{{ $product->product_manufacturer }}</td>
                <td class="text-center width-15">{{ $product->product_brand }}</td>
                <td class="text-center width-15">{{ $product->product_license }}</td>
                <td class="text-center width-5"><a class="btn btn-secondary"
                        href="/products/{{ $product->product_id }}">View</a></td>
            </tr>
        @endforeach
    </table>
@endsection
