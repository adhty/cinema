@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Movie</h2>

    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('movies.form')
        
        <button type="submit" class="btn btn-primary">Save Movie</button>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
