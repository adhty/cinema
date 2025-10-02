@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Movies</h1>
        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
            Add Movie
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Age Rating</th>
                    <th>Producer</th>
                    <th>Actors</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movies as $movie)
                    <tr>
                        <td><strong>{{ $movie->title }}</strong></td>
                        <td>{{ $movie->duration }} mins</td>
                        <td>
                            <span class="badge bg-primary">{{ $movie->age }}+</span>
                        </td>
                        <td>{{ $movie->producer }}</td>
                        <td>
                            <span class="badge bg-success">{{ $movie->actors->count() }} actors</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.movies.show', $movie) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this movie?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No movies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
