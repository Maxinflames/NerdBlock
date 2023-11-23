@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Product</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/products">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group">
                                <label for="genre_select" class="col-md-4 control-label">Associated Genre</label>

                                <div class="col-md-6 center">
                                    <select class="form-control" id="genre_select" name="genre_id" required focus>
                                        <option value="" disabled selected>Please select Genre</option>
                                        @foreach ($genres as $genre)
                                            <option value="{{ $genre->genre_id }}">{{ $genre->genre_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_title" class="col-md-4 control-label">Product Title</label>

                                <div class="col-md-6">
                                    <input id="product_title" type="text" class="form-control" name="product_title"
                                        value="{{ old('product_title') }}" value=""
                                        placeholder="Short title of the Product" required autofocus>

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
                                        placeholder="Longer description of the Product" required>{{ old('product_description') }}</textarea>

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
                                    <input id="product_cost" g class="form-control"
                                        name="product_cost" value="{{ old('product_cost') }}" required>

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
                                        name="product_manufacturer" value="{{ old('product_manufacturer') }}"   >

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
                                        value="{{ old('product_brand') }}">

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
                                        value="{{ old('product_license') }}">

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
                                        value="{{ old('product_quantity') }}" required>

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
                                        Submit Product
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
