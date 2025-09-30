@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Actor to {{ $movie->title }}</h3>

    <form action="{{ route('actors.store') }}"
          method="POST" enctype="multipart/form-data">
        @include('movies.actors.form')
        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
    </form>
</div>
@endsection
