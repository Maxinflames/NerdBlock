@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Checks if there are any posts to display, if not, notifies the user -->
        @if (count($genres) == 0)
            <br />
            <p class="text-center">Currently there are no genres!</p>
        @endif
        <br />
        <div class="form-group text-center">
            @if (Session::has('active_user'))
                @if (session()->get('user_type') == 'A')
                    <a href="/catalogue/create" class="btn btn-primary">Create New Genre</a>
                @endif
            @endif
            <!-- Searches for a post using ID of the post -->
            <div class="text-end">
                <form method="POST" action="/catalogue/search">
                    {{ csrf_field() }}
                    @if (Session::has('search_error'))
                        <label for="search_text">{{ Session::pull('search_error') }}</label>
                    @endif
                    <input id="search_text" name="search_text" placeholder="Search Here..." type="text" />
                    <button class="btn btn-secondary">Search</button>
                </form>
            </div>
        </div>
        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                <th class="text-center">Genre Title</th>
                <th class="text-center">Genre Description</th>
                @if (Session::has('active_user'))
                    @if (session()->get('user_type') == 'A')
                        <th colspan="3"></th>
                    @endif
                @endif
            </tr>
            <!-- loop through database data and display for each entry -->
            @foreach ($genres as $genre)
                <tr>
                    <td colspan="3"><img class="width-100" height="150px"
                            src="/images/genre-image-{{ $genre->genre_id }}.jpg"></td>
                </tr>
                <tr>
                    <td class="text-center width-15">{{ $genre->genre_title }}</td>
                    <td class="text-center width-60">{{ $genre->genre_description }}</td>
                    @if (Session::has('active_user'))
                        @if (session()->get('user_type') == 'C')
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/subscriptions/create/{{ $genre->genre_id }}">Subscribe</a></td>
                        @endif
                        @if (session()->get('user_type') == 'A')
                            <td class="text-center width-5"><a class="btn btn-secondary"
                                    href="/catalogue/edit/{{ $genre->genre_id }}">Edit</a></td>
                            <td class="text-center width-5"><a class="btn btn-danger" href="#">Disable</a></td>
                        @endif
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection
