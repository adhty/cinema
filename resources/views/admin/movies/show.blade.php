@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>{{ $movie->title }}</h2>
            
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Duration:</strong> {{ $movie->duration }} minutes</p>
                            <p><strong>Age Rating:</strong> {{ $movie->age }}+</p>
                            @if($movie->animation_type)
                                <p><strong>Animation Type:</strong> {{ $movie->animation_type }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($movie->start_showing)
                                <p><strong>Start Showing:</strong> {{ $movie->start_showing }}</p>
                            @endif
                            @if($movie->start_selling)
                                <p><strong>Start Selling:</strong> {{ $movie->start_selling }}</p>
                            @endif
                        </div>
                    </div>
                    
                    @if($movie->synopsis)
                        <p><strong>Synopsis:</strong> {{ $movie->synopsis }}</p>
                    @endif
                    
                    <div class="row mt-3">
                        @if($movie->producer)
                            <div class="col-md-6">
                                <p><strong>Producer:</strong> {{ $movie->producer }}</p>
                            </div>
                        @endif
                        @if($movie->director)
                            <div class="col-md-6">
                                <p><strong>Director:</strong> {{ $movie->director }}</p>
                            </div>
                        @endif
                        @if($movie->writer)
                            <div class="col-md-6">
                                <p><strong>Writer:</strong> {{ $movie->writer }}</p>
                            </div>
                        @endif
                        @if($movie->production)
                            <div class="col-md-6">
                                <p><strong>Production:</strong> {{ $movie->production }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2 mb-3">
                <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-warning">Edit Movie</a>
                <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this movie?')">Delete Movie</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <h4>Actors</h4>
            <p>To manage actors, please <a href="{{ route('admin.movies.edit', $movie) }}">edit the movie</a>.</p>
            
            <div class="row">
                @forelse($movie->actors as $actor)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            @if($actor->photo)
                                <img src="{{ asset('storage/'.$actor->photo) }}" class="card-img-top" alt="{{ $actor->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-muted">No Photo</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $actor->name }}</h5>
                                @if($actor->character_name)
                                    <p class="card-text"><small class="text-muted">as {{ $actor->character_name }}</small></p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p>No actors added yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
