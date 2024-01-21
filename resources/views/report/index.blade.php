@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center">
            <h1>Reports Menu</h1>

            <div class="content">
                <div>
                    <a class="btn btn-secondary" href="/reports/financials">
                        <h4>Financial Report</h4>
                    </a>
                </div>
                <div>
                    <a class="btn btn-secondary" href="/reports/packages">
                        <h4>Package Report</h4>
                    </a>
                </div>
                <div>
                    <a class="btn btn-secondary" href="/reports/products">
                        <h4>Product Report</h4>
                    </a>
                </div>
                <div>
                    <a class="btn btn-secondary" href="/reports/shipping">
                        <h4>Shipping Report</h4>
                    </a>
                </div>
                <div>
                    <a class="btn btn-secondary" href="/reports/subscriptions">
                        <h4>Subscription Report</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
