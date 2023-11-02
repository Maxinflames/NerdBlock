@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Genre</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="/catalogue">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group">
                                <label for="genre_title" class="col-md-4 control-label">Genre Title</label>

                                <div class="col-md-6">
                                    <input id="genre_title" type="text" class="form-control" name="genre_title"
                                        value="{{ old('genre_title') }}" value="" placeholder="Short title of the Genre" required autofocus>

                                    @if ($errors->has('genre_title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('genre_title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="genre_description" class="col-md-4 control-label">Genre Description</label>

                                <div class="col-md-6">
                                    <textarea rows="4" id="genre_description" type="text" class="form-control" name="genre_description"
                                        value="{{ old('genre_description') }}" value="" placeholder="Longer description of the Genre" required></textarea>

                                    @if ($errors->has('genre_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('genre_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Publish Genre
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
