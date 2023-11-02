@extends('layouts.app')

@section('content')
    <div>
        <!-- Checks if there are any posts to display, if not, notifies the user -->
        @if (count($users) == 0)
            <p class="text-center">Currently there are no users!</p>
        @endif
        <div class="form-group text-center">
            <a href="/users/create" class="btn btn-primary">Create New User</a>

            <!-- Searches for a post using ID of the post -->
            <div class="text-end">
              <form method="POST" action="/users/search">
                {{ csrf_field() }}
                @if (Session::has('search_error'))
                  <label for="id">{{Session::pull('search_error')}}</label>
                @endif
                <input id="id" name="id" placeholder="Search Here..." type="number" min=1 />
                <button class="btn btn-secondary">Search</button>
              </form>
            </div>
        </div>
        @if (count($users) != 0)
            <table class="table table-striped">
                <!-- Table column headers -->
                <tr>
                    <th class="text-center">Used Id</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">Last Name</th>
                    <th class="text-center">Email Address</th>
                    <th class="text-center">User Type</th>
                    <th class="text-center">Client Id</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Region</th>
                    <th class="text-center">City</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Regional Post Code</th>
                    <th class="text-center">Country Code</th>
                    <th class="text-center">Telephone</th>
                    <th colspan="3"></th>
                </tr>
                <!-- loop through database data and display for each entry -->
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->user_id }}</td>
                        <td class="text-center width-5">{{ $user->user_first_name }}</td>
                        <td class="text-center width-5">{{ $user->user_last_name }}</td>
                        <td class="text-center width-10">{{ $user->user_email_address }}</td>
                        <td class="text-center">{{ $user->user_type }}</td>
                        <td class="text-center">{{ $user->client_id }}</td>
                        <td class="text-center width-5">{{ $user->client_country }}</td>
                        <td class="text-center width-5">{{ $user->client_region }}</td>
                        <td class="text-center width-5">{{ $user->client_city }}</td>
                        <td class="text-center width-10">{{ $user->client_address }}</td>
                        <td class="text-center width-10">{{ $user->client_region_post_code }}</td>
                        <td class="text-center">{{ $user->client_country_code }}</td>
                        <td class="text-center width-10">{{ $user->client_telephone }}</td>
                        <td class="text-center"><a class="btn btn-secondary" href="#">Edit</a></td>
                        <td class="text-center"><a class="btn btn-danger" href="#">Disable</a></td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
@endsection
