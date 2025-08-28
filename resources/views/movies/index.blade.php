@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Movies</h1>
    <a href="{{ route('movies.create') }}" class="btn btn-primary">Add Movie</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Duration</th>
                <th>Age Rating</th>
                <th>Producer</th>
                <th>Actors</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->duration }} mins</td>
                    <td>{{ $movie->age }}+</td>
                    <td>{{ $movie->producer }}</td>
                    <td>{{ $movie->actors->count() }}</td>
                    <td>
                        <a href="{{ route('movies.show', $movie) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('movies.edit', $movie) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('movies.destroy', $movie) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this movie?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
