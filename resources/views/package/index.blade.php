@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Checks if there are any posts to display, if not, notifies the user -->
        @if (count($packages) == 0)
            <p class="text-center">Currently there are no packages!</p>
        @endif
        <div class="form-group text-center">
            @if (Session::has('active_user'))
                @if (session()->get('user_type') == 'A')
                    <a href="/packages/create" class="btn btn-primary">Create New Package</a>
                @endif
            @endif
            <!-- Searches for a post using ID of the post -->
            @if (count($packages) != 0)
                <div class="text-end">
                    <form method="POST" action="/packages/search">
                        {{ csrf_field() }}
                        @if (Session::has('search_error'))
                            <label for="search_text">{{ Session::pull('search_error') }}</label>
                        @endif
                        <input id="search_text" name="search_text" placeholder="Search Here..." type="text" />
                        <button class="btn btn-secondary">Search</button>
                    </form>
                </div>
            @endif
        </div>
        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                <th class="text-center">Package ID</th>
                <th class="text-center">Package Genre</th>
                <th class="text-center">Package Month</th>
                <th class="text-center">Package Year</th>
            </tr>
            <!-- loop through database data and display for each entry -->
            @foreach ($packages as $package)
                <tr>
                    <td class="text-center">{{ $package->package_id }}</td>
                    @if($package->genre_title != null)
                        <td class="text-center">{{ $package->genre_title }}</td>
                    @else
                        <td class="text-center">Not Assigned</td>
                    @endif
                    <td class="text-center">{{ $package->package_month }}</td>
                    <td class="text-center">{{ $package->package_year }}</td>
                    <td class="text-center width-5"><a class="btn btn-secondary"
                            href="/packages/{{ $package->package_id }}">View</a></td>
                    @if (session()->get('user_type') == 'A')
                        <td class="text-center width-5"><a class="btn btn-secondary"
                                href="/packages/edit/{{ $package->package_id }}">Edit</a></td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection
