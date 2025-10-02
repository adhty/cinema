@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Movie</h2>

    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.movies.form')
        
        <button type="submit" class="btn btn-primary">Save Movie</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
