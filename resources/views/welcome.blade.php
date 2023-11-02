@extends('layouts.app')

@section('content')
    @if (Session::has('active_user'))
        <div class="help-block">
            <strong>{{ session()->get('active_user') }}</strong>
            <strong>{{ session()->get('user_id') }}</strong>
            <strong>{{ session()->get('first_name') }}</strong>
            <strong>{{ session()->get('last_name') }}</strong>
            <strong>{{ session()->get('email') }}</strong>
            <strong>{{ session()->get('user_type') }}</strong>
            <strong>{{ session()->get('client_id') }}</strong>
        </div>
    @endif
    <div class="flex-center position-ref partial-height">

        <div class="content">
            <div class="title m-b-md">
                NerdBlock
            </div>
        </div>
    </div>
    <div class="flex-center position-ref">
        <div class="content">
            <div>
                Get your very own NerdBlock crate today!
            </div>
            <div>
                <a href="{{ route('genre') }}">View Genre Catalogue</a>
            </div>
        </div>
    </div>
@endsection
