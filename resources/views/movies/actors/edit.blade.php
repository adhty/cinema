@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Actor in {{ $movie->title }}</h3>

    <form action="{{ route('actors.update', $actor->id) }}"
          method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('movies.actors.form')
        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
    </form>
</div>
@endsection
