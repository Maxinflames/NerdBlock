@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Checks if there are any posts to display, if not, notifies the user -->

        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                @if (Session::has('active_user'))
                    @if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E')
                        <th class="text-center">Subscription ID</th>
                        <th class="text-center">Client ID</th>
                        <th class="text-center">Genre ID</th>
                    @endif
                @endif
                <th class="text-center">Genre Title</th>
                <th class="text-center">Subscribed Date</th>
                <th class="text-center">Subscription Length (Months)</th>
                <th class="text-center">Subscription End Date</th>
                <th class="text-center">Subscription Cost</th>
            </tr>
            <tr>
                @if (Session::has('active_user'))
                    @if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E')
                        <td class="text-center width-10">{{ $subscription->subscription_id }}</td>
                        <td class="text-center width-10">{{ $subscription->client_id }}</td>
                        <td class="text-center width-10">{{ $subscription->genre_id }}</td>
                    @endif
                @endif
                <td class="text-center width-15">{{ $subscription->genre_title }}</td>
                <td class="text-center width-15">{{ $subscription->subscription_date }}</td>
                <td class="text-center width-15">{{ $subscription->subscription_length }}</td>
                <td class="text-center width-15">{{ $subscription->subscription_end_date }}</td>
                <td class="text-center width-15">${{ $subscription->subscription_cost }}</td>
            </tr>
        </table>

        @if (count($associated_packages) == 0)
            <p class="text-center">Currently there are no associated packages!</p>
        @endif
        <div class="form-group text-center">
            @if (Session::has('active_user'))

                @if (session()->get('user_type') == 'A')
                    @if ($associated_packages->count() == $subscription->subscription_length)
                        <p>This Subscription has been completed!</p>
                    @else
                        <a href="/subscriptions/fulfill/assign/{{ $subscription->subscription_id }}"
                            class="btn btn-primary">Send Package</a>
                    @endif
                @endif
            @endif
        </div>
    </div>

    <table class="table table-striped">
        <!-- Table column headers -->
        <tr>
            <th class="text-center">Package Month</th>
            <th class="text-center">Package Year</th>
            <th class="text-center">Date Sent</th>
            <th></th>
        </tr>
        <!-- loop through database data and display for each entry -->
        @foreach ($associated_packages as $package)
            <tr>
                <td class="text-center">{{ $package->package_month }}</td>
                <td class="text-center">{{ $package->package_year }}</td>
                <td class="text-center">{{ $package->sent_package_date }}</td>
                <td class="text-center"><a class="btn btn-secondary"
                        href="/subscriptions/rate/{{ $package->sent_package_id }}">Rate</a></td>
            </tr>
        @endforeach
    </table>
@endsection
