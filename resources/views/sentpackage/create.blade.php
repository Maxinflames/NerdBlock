@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <tr>
                <th class="text-center">Package ID</th>
                <th class="text-center">Package Month</th>
                <th class="text-center">Package Year</th>
            </tr>
            <tr>
                <td class="text-center">{{ $package->package_id }}</td>
                <td class="text-center">{{ $package->package_month }}</td>
                <td class="text-center">{{ $package->package_year }}</td>
            </tr>
        </table>
        <div class="center">
            <p>Available Subscriptions</p>
        </div>
        <table class="table table-striped">
            <tr>
                <th class="text-center">Subscription ID</th>
                <th class="text-center">Client ID</th>
                <th class="text-center">Genre ID</th>
                <th class="text-center">Genre Title</th>
                <th class="text-center">Subscription Date</th>
                <th class="text-center">Subscription Length (Months)</th>
                <th class="text-center">Subscription End Date</th>
            </tr>
            @foreach ($subscriptions as $subscription)
                <tr>
                    <td class="text-center">{{ $subscription->subscription_id }}</td>
                    <td class="text-center">{{ $subscription->client_id }}</td>
                    <td class="text-center">{{ $subscription->genre_id }}</td>
                    <td class="text-center">{{ $subscription->genre_title }}</td>
                    <td class="text-center">{{ $subscription->subscription_date }}</td>
                    <td class="text-center">{{ $subscription->subscription_length }}</td>
                    <td class="text-center">{{ $subscription->subscription_end_date }}</td>
                    <td class="text-center width-5"><a href="/subscriptions/{{ $subscription->subscription_id }}" class="btn btn-primary">View Subscription</a></td>
                    <td class="text-center width-5">
                        <form method="POST" action="/sent-package">
                            {{ csrf_field() }}
                            <input type="hidden" value="1" name="create_route">
                            <input type="hidden" value="{{ $package->package_id }}" name="package_id">
                            <input type="hidden" value="{{ $subscription->subscription_id }}" name="subscription_id">
                            <button class="btn btn-primary">Send</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
