@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Account Report</h1>
                </div>

                <div class="panel-body">
                    <div class="content">

                        <div class="panel-heading">
                            <h3>Inactive Accounts</h3>
                        </div>
                        @if ($inactive_accounts != null)
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center">Used Id</th>
                                    <th class="text-center">First Name</th>
                                    <th class="text-center">Last Name</th>
                                    <th class="text-center">Email Address</th>
                                    <th class="text-center">Client Id</th>
                                    <th class="text-center">Country</th>
                                    <th class="text-center">Region</th>
                                    <th class="text-center">City</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Regional Post Code</th>
                                    <th class="text-center">Country Code</th>
                                    <th class="text-center">Telephone</th>
                                </tr>
                                @foreach ($inactive_accounts as $inactive_account)
                                    <tr>
                                        <td class="text-center">{{ $inactive_account->user_id }}</td>
                                        <td class="text-center width-5">{{ $inactive_account->user_first_name }}</td>
                                        <td class="text-center width-5">{{ $inactive_account->user_last_name }}</td>
                                        <td class="text-center width-10">{{ $inactive_account->user_email_address }}</td>
                                        <td class="text-center">{{ $inactive_account->client_id }}</td>
                                        <td class="text-center width-5">{{ $inactive_account->client_country }}</td>
                                        <td class="text-center width-5">{{ $inactive_account->client_region }}</td>
                                        <td class="text-center width-5">{{ $inactive_account->client_city }}</td>
                                        <td class="text-center width-10">{{ $inactive_account->client_address }}</td>
                                        <td class="text-center width-10">{{ $inactive_account->client_region_post_code }}
                                        </td>
                                        <td class="text-center">{{ $inactive_account->client_country_code }}</td>
                                        <td class="text-center width-10">{{ $inactive_account->client_telephone }}</td>
                                        <td class="text-center"><a class="btn btn-secondary"
                                                href="/users/{{ $inactive_account->user_id }}">View</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="center">
                                No inactive accounts that have previously been active.
                            </div>
                        @endif
                        <br />
                        
                        <div class="panel-heading">
                            <h3>New Accounts</h3>
                        </div>
                        @if ($never_active_accounts != null)
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center">Used Id</th>
                                    <th class="text-center">First Name</th>
                                    <th class="text-center">Last Name</th>
                                    <th class="text-center">Email Address</th>
                                    <th class="text-center">Client Id</th>
                                    <th class="text-center">Country</th>
                                    <th class="text-center">Region</th>
                                    <th class="text-center">City</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Regional Post Code</th>
                                    <th class="text-center">Country Code</th>
                                    <th class="text-center">Telephone</th>
                                </tr>
                                @foreach ($never_active_accounts as $never_active_account)
                                    <tr>
                                        <td class="text-center">{{ $never_active_account->user_id }}</td>
                                        <td class="text-center width-5">{{ $never_active_account->user_first_name }}</td>
                                        <td class="text-center width-5">{{ $never_active_account->user_last_name }}</td>
                                        <td class="text-center width-10">{{ $never_active_account->user_email_address }}
                                        </td>
                                        <td class="text-center">{{ $never_active_account->client_id }}</td>
                                        <td class="text-center width-5">{{ $never_active_account->client_country }}</td>
                                        <td class="text-center width-5">{{ $never_active_account->client_region }}</td>
                                        <td class="text-center width-5">{{ $never_active_account->client_city }}</td>
                                        <td class="text-center width-10">{{ $never_active_account->client_address }}</td>
                                        <td class="text-center width-10">
                                            {{ $never_active_account->client_region_post_code }}</td>
                                        <td class="text-center">{{ $never_active_account->client_country_code }}</td>
                                        <td class="text-center width-10">{{ $never_active_account->client_telephone }}</td>
                                        <td class="text-center"><a class="btn btn-secondary"
                                                href="/users/{{ $never_active_account->user_id }}">View</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="center">
                                No new accounts with no subscriptions.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
