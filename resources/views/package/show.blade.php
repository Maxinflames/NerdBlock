@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Checks if there are any posts to display, if not, notifies the user -->

        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                <th class="text-center">Package ID</th>
                <th class="text-center">Package Genre</th>
                <th class="text-center">Package Month</th>
                <th class="text-center">Package Year</th>
            </tr>
            <tr>
                <td class="text-center">{{ $retrieved_package->package_id }}</td>
                <td class="text-center">{{ $retrieved_package->genre_id }}</td>
                <td class="text-center">{{ $retrieved_package->package_month }}</td>
                <td class="text-center">{{ $retrieved_package->package_year }}</td>
            </tr>
        </table>
        @if (count($associated_products) == 0)
            <p class="text-center">Currently there are no associated products!</p>
        @endif
        <div class="form-group text-center">
            @if ($retrieved_package->genre_id != null)
                <a href="/packages/fulfill/create/{{ $retrieved_package->package_id }}" class="btn btn-primary">Ship Package</a>
            @endif
            @if (Session::has('active_user'))
                @if (session()->get('user_type') == 'A')
                    <a href="/packaged-item/create/{{ $retrieved_package->package_id }}" class="btn btn-primary">Add Product to Package</a>
                @endif
            @endif
        </div>
    </div>
    <table class="table table-striped">
        <!-- Table column headers -->
        <tr>
            <th class="text-center">Packaged Item ID</th>
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
        <!-- loop through database data and display for each entry -->
        @foreach ($associated_products as $product)
            <tr>
                <td class="text-center">{{ $product->packaged_item_id }}</td>
                <td class="text-center">{{ $product->product_id }}</td>
                <td class="text-center">{{ $product->genre_id }}</td>
                <td class="text-center width-15">{{ $product->product_title }}</td>
                <td class="text-center width-60">{{ $product->product_description }}</td>
                <td class="text-center">${{ number_format($product->product_cost, 2, '.', ',') }}</td>
                <td class="text-center width-15">{{ $product->product_manufacturer }}</td>
                <td class="text-center width-15">{{ $product->product_brand }}</td>
                <td class="text-center width-15">{{ $product->product_license }}</td>
                <td class="text-center">{{ $product->product_quantity }}</td>
                <td class="text-center width-5"><a class="btn btn-secondary"
                        href="/products/{{ $product->product_id }}">View</a></td>
                @if (session()->get('user_type') == 'A')
                    <td class="text-center width-5"><a class="btn btn-secondary"
                            href="/products/edit/{{ $product->product_id }}">Edit</a></td>
                @endif
            </tr>
        @endforeach
    </table>
@endsection
