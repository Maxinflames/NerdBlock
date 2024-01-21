@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Subscriptions Report</h1>
                </div>

                <div class="panel-body">
                    <div class="content">
                        <div class="content">

                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center">Total Number of Subscriptions</th>
                                    <th class="text-center">Active Subscriptions</th>
                                    <th class="text-center">Resubscribed Accounts</th>
                                    <th class="text-center">Average Subscription Length</th>
                                    <th class="text-center">Accounts Without Subscriptions</th>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        {{ number_format($total_subscriptions->total_subscription_count, 0, '.', ',') }}
                                    </td>
                                    <td class="text-center">{{ number_format($active_subscriptions, 0, '.', ',') }}</td>
                                    <td class="text-center">Not Yet Implemented</td>
                                    <td class="text-center">
                                        {{ number_format($average_subscription_length->average_length, 2, '.', ',') }} Months</td>
                                    <td class="text-center">{{ number_format($inactive_subscriptions, 0, '.', ',') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="4"></th>
                                    <th class="text-center">
                                        <form class="form-horizontal" method="POST" action="/reports/subscriptions">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <div class="form-group">
                                                <div class="Center">
                                                    <button type="submit" class="btn btn-primary">
                                                        View List
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </th>
                                </tr>
                            </table>
                            <br />
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center">Genre ID</th>
                                    <th class="text-center">Genre Title</th>
                                    <th class="text-center">Number of Subscriptions</th>
                                    <th class="text-center">Percentage of Total</th>
                                </tr>
                                @foreach ($genre_subscription_counts as $genre_subscription_count)
                                    <tr>
                                        <td class="text-center width-25">{{ $genre_subscription_count->genre_id }}</td>
                                        <td class="text-center width-25">{{ $genre_subscription_count->genre_title }}</td>
                                        <td class="text-center width-25">
                                            {{ number_format($genre_subscription_count->genre_count, 0, '.', ',') }}</td>
                                        <td class="text-center width-25">
                                            {{ number_format(($genre_subscription_count->genre_count / $total_subscriptions->total_subscription_count) * 100, 2, '.', ',') }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
