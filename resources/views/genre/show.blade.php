@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">{{ $genre->genre_title }}</h1>
        <p> {{ $genre->genre_description }}</p>

        <a class="btn btn-secondary" href="/subscription/create/{{ $genre->genre_id }}">View</a>
    </div>
@endsection
