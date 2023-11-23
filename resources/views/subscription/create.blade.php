@extends('layouts.app')

@section('content')
    <h1 class="text-center">Genre: {{ $genre->genre_title }}</h1>
    <p>Genre Description: {{ $genre->genre_description }}</p>

    <div class="panel panel-default">
        <div class="content panel-heading">Subscribe Now!</div>

        @if (session()->has('SubscriptionError'))
            <span class="content help-block">
                <strong>{{ session()->pull('SubscriptionError') }}</strong>
            </span>
        @endif

        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="/subscriptions">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <input type="hidden" name="genre_id" value={{ $genre->genre_id }}>

                <div class="content form-group">
                    <input class="radio-input" id="length1" type="radio" name="subscription_length" checked="true"
                        value="3" />
                    <label class="radio-label" for="length1">3 Months - $75<br>($25 per Month)</label><br>
                </div>
                <div class="content form-group">
                    <input class="radio-input" id="length2" type="radio" name="subscription_length" value="6" />
                    <label class="radio-label" for="length2">6 Months - $120<br>($20 per Month)</label><br>
                </div>
                <div class="content form-group">
                    <input class="radio-input" id="length3" type="radio" name="subscription_length" value="12" />
                    <label class="radio-label" for="length3">12 Months - $180<br>($15 per Month)</label><br>
                </div>
                <div class="content form-group">
                    <button type="submit" class="btn btn-primary">
                        Subscribe
                    </button>
                </div>
            </form>
        </div>
    @endsection
