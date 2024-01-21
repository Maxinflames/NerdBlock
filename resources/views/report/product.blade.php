@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center">
            <h1>Product Report</h1>

            <div class="content">
                @if (!$products_in_stock->isEmpty())
                    <table class="table table-striped">
                        <tr>
                            <th class="text-center">Product ID</th>
                            <th class="text-center">Product Title</th>
                            <th class="text-center">Product Description</th>
                            <th class="text-center">Genre Title</th>
                            <th class="text-center">Product Cost</th>
                            <th class="text-center">Product Quantity</th>
                            <th class="text-center">Product Manufacturer</th>
                            <th class="text-center">Product Brand</th>
                            <th class="text-center">Product License</th>
                            <th class="text-center">Total Cost</th>
                        </tr>
                        @foreach ($products_in_stock as $product_in_stock)
                            <tr>
                                <td class="text-center">{{ $product_in_stock->product_id }}</td>
                                <td class="text-center">{{ $product_in_stock->product_title }}</td>
                                <td class="text-center">{{ $product_in_stock->product_description }}</td>
                                <td class="text-center">{{ $product_in_stock->genre_title }}</td>
                                <td class="text-center">${{ number_format($product_in_stock->product_cost, 2, '.', ',') }}</td>
                                <td class="text-center">{{ $product_in_stock->product_quantity }}</td>
                                <td class="text-center">{{ $product_in_stock->product_manufacturer }}</td>
                                <td class="text-center">{{ $product_in_stock->product_brand }}</td>
                                <td class="text-center">{{ $product_in_stock->product_license }}</td>
                                <td class="text-center">
                                    ${{ number_format($product_in_stock->total_product_cost, 2, '.', ',') }}</td>
                                <td class="text-center"><a class="btn btn-secondary"
                                        href="/products/{{ $product_in_stock->product_id }}">View</a></td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div class="center">
                        No Products in Stock!
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
