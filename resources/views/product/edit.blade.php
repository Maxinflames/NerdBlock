@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Product</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/products/update">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <input type="hidden" name="product_id" value="{{ $product->product_id }}" />

                            <div class="form-group">
                                <label for="genre_select" class="col-md-4 control-label">Associated Genre</label>

                                <div class="col-md-6 center">
                                    <select class="form-control" id="genre_select" name="genre_id" focus>
                                        <option value="" disabled>Please select Genre</option>
                                        @foreach ($genres as $genre)
                                            @if ($genre->genre_id == $product->genre_id)
                                            {
                                                <option value="{{ $genre->genre_id }}" selected>{{ $genre->genre_title }}</option>
                                            }
                                            @else
                                            {
                                                <option value="{{ $genre->genre_id }}">{{ $genre->genre_title }}</option>
                                            }
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_title" class="col-md-4 control-label">Product Title</label>

                                <div class="col-md-6">
                                    <input id="product_title" type="text" class="form-control" name="product_title"
                                        value="{{ $product->product_title }}" value=""
                                        placeholder="Short title of the Product" autofocus>

                                    @if ($errors->has('product_title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('product_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_description" class="col-md-4 control-label">Product Description</label>

                                <div class="col-md-6">
                                    <textarea rows="4" id="product_description" type="text" class="form-control" name="product_description"
                                        placeholder="Longer description of the Product">{{ $product->product_description }}</textarea>

                                    @if ($errors->has('product_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('product_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_cost" class="col-md-4 control-label">Product Cost</label>

                                <div class="col-md-6">
                                    <input id="product_cost" type="number" step="0.01" class="form-control"
                                        name="product_cost" value="{{ $product->product_cost }}">

                                    @if ($errors->has('product_cost'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('product_cost') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_manufacturer" class="col-md-4 control-label">Product
                                    Manufacturer</label>

                                <div class="col-md-6">
                                    <input id="product_manufacturer" type="text" class="form-control"
                                        name="product_manufacturer" value="{{ $product->product_manufacturer }}">

                                    @if ($errors->has('product_manufacturer'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('product_manufacturer') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_brand" class="col-md-4 control-label">Product Brand</label>

                                <div class="col-md-6">
                                    <input id="product_brand" type="text" class="form-control" name="product_brand"
                                        value="{{ $product->product_brand }}">

                                    @if ($errors->has('product_brand'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('product_brand') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_license" class="col-md-4 control-label">Product License</label>

                                <div class="col-md-6">
                                    <input id="product_license" type="text" class="form-control" name="product_license"
                                        value="{{ $product->product_license }}">

                                    @if ($errors->has('product_license'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('product_license') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_quantity" class="col-md-4 control-label">Product Quantity</label>

                                <div class="col-md-6">
                                    <input id="product_quantity" type="number" class="form-control" name="product_quantity"
                                        value="{{ $product->product_quantity }}">

                                    @if ($errors->has('product_quantity'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('product_quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Product
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
