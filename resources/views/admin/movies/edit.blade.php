@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Movie</h2>

    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.movies.form')
        
        <button type="submit" class="btn btn-primary">Update Movie</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
