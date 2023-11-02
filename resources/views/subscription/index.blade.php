@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="form-group text-center">
            <!-- Checks if there are any posts to display, if not, notifies the user -->
            @if (count($subscriptions) == 0)
                <p>There are no Subscriptions!</p>
            @endif
            @if (count($subscriptions) != 0)
                <div class="text-end">
                    <form method="POST" action="/subscriptions/search">
                        {{ csrf_field() }}
                        @if (Session::has('search_error'))
                            <label for="search_text">{{ Session::pull('search_error') }}</label>
                        @endif
                        <input class="width-30" id="search_text" name="search_text" placeholder="Search Subscription Id or Genre Title Here..." type="text" />
                        <button class="btn btn-secondary">Search</button>
                    </form>
                </div>
            @endif
        </div>
        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                @if (Session::has('active_user'))
                    @if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E')
                        <th class="text-center">Subscription ID</th>
                        <th class="text-center">Client ID</th>
                    @endif
                @endif

                <th class="text-center">Genre Title</th>
                <th class="text-center">Subscribed Date</th>
                <th class="text-center">Subscription Length (Months)</th>
                <th class="text-center">Subscription End Date</th>
                <th class="text-center">Subscription Cost</th>
                @if (Session::has('active_user'))
                    @if (session()->get('user_type') == 'A')
                        <th colspan="3"></th>
                    @endif
                @endif
            </tr>
            <!-- loop through database data and display for each entry -->
            @foreach ($subscriptions as $subscription)
                <tr>
                    @if (Session::has('active_user'))
                        @if (session()->get('user_type') == 'A' || session()->get('user_type') == 'E')
                            <td class="text-center width-10">{{ $subscription->subscription_id }}</td>
                            <td class="text-center width-10">{{ $subscription->client_id }}</td>
                        @endif
                    @endif
                    <td class="text-center width-15">{{ $subscription->genre_title }}</td>
                    <td class="text-center width-15">{{ $subscription->subscription_date }}</td>
                    <td class="text-center width-15">{{ $subscription->subscription_length }}</td>
                    <td class="text-center width-15">{{ $subscription->subscription_end_date }}</td>
                    <td class="text-center width-15">${{ $subscription->subscription_cost }}</td>
                    <td class="text-center width-5"><a class="btn btn-secondary" href="#">View</a></td>
                    @if (Session::has('active_user'))
                        @if (session()->get('user_type') == 'A')
                            <td class="text-center width-5"><a class="btn btn-secondary" href="#">Edit</a></td>
                        @endif
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection
