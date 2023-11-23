@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Checks if there are any posts to display, if not, notifies the user -->
        @if (count($subscriptions) == 0)
            <p class="text-center">Currently there are no unfulfilled Subscriptions!</p>
        @endif
        <div class="form-group text-center">
            <!-- Searches for a post using ID of the post -->
            @if (count($subscriptions) != 0)
                <div class="text-end">
                    <form method="POST" action="/subscriptions/fulfill">
                        {{ csrf_field() }}
                        @if (Session::has('search_error'))
                            <label for="search_text">{{ Session::pull('search_error') }}</label>
                        @endif
                        <select id="genre_search" name="genre_search">
                            <option value="disabled" disabled="true" selected="true">Select Genre</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->genre_id }}">{{ $genre->genre_title }}</option>
                            @endforeach
                        </select>
                        <input id="search_text" name="search_text" placeholder="Search Date..." type="text" />
                        <button class="btn btn-secondary">Search</button>
                    </form>
                    @if ($errors->has('search_text'))
                        <span class="help-block">
                            <strong>{{ $errors->first('search_text') }}</strong>
                        </span>
                    @endif
                </div>
            @endif
        </div>
        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                <th class="text-center">Subscription ID</th>
                <th class="text-center">Client ID</th>
                <th class="text-center">Genre ID</th>
                <th class="text-center">Genre Title</th>
                <th class="text-center">Subscription Date</th>
                <th class="text-center">Subscription Length (Months)</th>
                <th class="text-center">Subscription End Date</th>
            </tr>
            <!-- loop through database data and display for each entry -->
            @foreach ($subscriptions as $subscription)
                <tr>
                    <td class="text-center">{{ $subscription->subscription_id }}</td>
                    <td class="text-center">{{ $subscription->client_id }}</td>
                    <td class="text-center">{{ $subscription->genre_id }}</td>
                    <td class="text-center">{{ $subscription->genre_title }}</td>
                    <td class="text-center">{{ $subscription->subscription_date }}</td>
                    <td class="text-center">{{ $subscription->subscription_length }}</td>
                    <td class="text-center">{{ $subscription->subscription_end_date }}</td>
                    <td class="text-center width-5"><a class="btn btn-secondary"
                            href="/subscriptions/{{ $subscription->subscription_id }}">View</a></td>
                    @if (session()->get('user_type') == 'A')
                        <td class="text-center width-5"><a class="btn btn-secondary"
                                href="/subscriptions/fulfill/assign/{{ $subscription->subscription_id }}">Fulfill Subscription</a></td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection
