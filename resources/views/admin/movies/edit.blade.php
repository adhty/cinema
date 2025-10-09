@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold mb-6">Edit Movie</h2>

    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @include('admin.movies.form')

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow">
                Update Movie
            </button>
            <a href="{{ route('admin.movies.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded shadow">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
