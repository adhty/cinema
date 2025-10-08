@extends('layouts.admin')

@section('title', 'Movies')

@section('content')
<div class="container my-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Movies</h1>
        <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Movie
        </a>
    </div>

    {{-- Movies Grid --}}
    <div class="row g-4">
        @forelse($movies as $movie)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    @if($movie->cover)
                        <img src="{{ asset('storage/'.$movie->cover) }}" 
                             class="card-img-top" 
                             style="height: 300px; object-fit: cover;" 
                             alt="{{ $movie->title }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                            <span class="text-muted">No Cover</span>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $movie->title }}</h5>
                        <p class="mb-1"><strong>Duration:</strong> {{ $movie->duration }} mins</p>
                        <p class="mb-1"><strong>Age:</strong> <span class="badge bg-primary">{{ $movie->age }}+</span></p>
                        <p class="mb-2"><strong>Actors:</strong> {{ $movie->actors->count() }}</p>

                        <div class="mt-auto d-flex justify-content-between">
                            <a href="{{ route('admin.movies.show', $movie) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this movie?')" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                No movies found.
            </div>
        @endforelse
    </div>
</div>
@endsection
