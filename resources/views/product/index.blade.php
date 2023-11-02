@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Checks if there are any posts to display, if not, notifies the user -->
        @if (count($products) == 0)
            <p class="text-center">Currently there are no products!</p>
        @endif
        <div class="form-group text-center">
            @if (Session::has('active_user'))
                @if (session()->get('user_type') == 'A')
                    <a href="/products/create" class="btn btn-primary">Create New Product</a>
                @endif
            @endif
            <!-- Searches for a post using ID of the post -->
            @if (count($products) != 0)
                <div class="text-end">
                    <form method="POST" action="/products/search">
                        {{ csrf_field() }}
                        @if (Session::has('search_error'))
                            <label for="search_text">{{ Session::pull('search_error') }}</label>
                        @endif
                        <input id="search_text" name="search_text" placeholder="Search Here..." type="text" />
                        <button class="btn btn-secondary">Search</button>
                    </form>
                </div>
            @endif
        </div>
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
                    <td class="text-center width-5"><a class="btn btn-secondary"
                            href="/products/{{ $product->product_id }}">View</a></td>
                    @if (session()->get('user_type') == 'A')
                        <td class="text-center width-5"><a class="btn btn-secondary"
                                href="/products/edit/{{ $product->product_id }}">Edit</a></td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection
