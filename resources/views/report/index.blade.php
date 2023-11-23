@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center">
            <h1>Reports Menu</h1>

            <div class="content">
                <div>
                    <a class="btn btn-secondary" href="/reports/packages">
                        <h4>Shipped Package Reports</h4>
                    </a>
                </div>
                <div>
                    <a class="btn btn-secondary" href="/reports/sales">
                        <h4>Sales Reports</h4>
                    </a>
                </div>
                <div>
                    <a class="btn btn-secondary" href="/reports/subscriptions">
                        <h4>Subscription Reports</h4>
                    </a>
                </div>
                <div>
                    <a class="btn btn-secondary" href="/reports/products">
                        <h4>Product Reports</h4>
                    </a>
                </div>
                <div>
                    <a class="btn btn-secondary" href="/reports/shipping">
                        <h4>Shipping Reports</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
