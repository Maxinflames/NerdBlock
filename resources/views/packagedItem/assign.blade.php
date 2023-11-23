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
        </table>

        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                <tr>
                    <th class="text-center">Package ID</th>
                    <th class="text-center">Package Genre</th>
                    <th class="text-center">Package Month</th>
                    <th class="text-center">Package Year</th>
                    <th></th>
                </tr>
            </tr>
            @foreach ($qualified_packages as $package)
            <tr>
                <td class="text-center">{{ $package->package_id }}</td>
                <td class="text-center">{{ $package->genre_id }}</td>
                <td class="text-center">{{ $package->package_month }}</td>
                <td class="text-center">{{ $package->package_year }}</td>
                <td>
                    <form method="POST" action="/packaged-item">
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $package->package_id }}" name="package_id">
                        <input type="hidden" value="{{ $product->product_id }}" name="product_id">
                        <button class="btn btn-primary">Assign</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
