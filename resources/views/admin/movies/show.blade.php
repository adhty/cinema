@extends('layouts.admin')

@section('title', $movie->title)

@section('content')
<div class="container mx-auto my-4">

    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Movie Info --}}
        <div class="lg:w-2/3">
            <h2 class="text-2xl font-bold mb-3">{{ $movie->title }}</h2>

            <div class="bg-white shadow rounded mb-4 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    @if($movie->cover)
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/'.$movie->cover) }}" class="w-full h-full object-cover" alt="{{ $movie->title }}">
                    </div>
                    @endif
                    <div class="md:w-2/3 p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p><strong>Duration:</strong> {{ $movie->duration }} minutes</p>
                                <p><strong>Age Rating:</strong> {{ $movie->age }}+</p>
                                @if($movie->animation_type)
                                    <p><strong>Animation Type:</strong> {{ $movie->animation_type }}</p>
                                @endif
                            </div>
                            <div>
                                @if($movie->start_showing)
                                    <p><strong>Start Showing:</strong> {{ $movie->start_showing }}</p>
                                @endif
                                @if($movie->start_selling)
                                    <p><strong>Start Selling:</strong> {{ $movie->start_selling }}</p>
                                @endif
                            </div>
                        </div>

                        @if($movie->synopsis)
                            <p class="mt-3"><strong>Synopsis:</strong> {{ $movie->synopsis }}</p>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                            @if($movie->producer)
                                <p><strong>Producer:</strong> {{ $movie->producer }}</p>
                            @endif
                            @if($movie->director)
                                <p><strong>Director:</strong> {{ $movie->director }}</p>
                            @endif
                            @if($movie->writer)
                                <p><strong>Writer:</strong> {{ $movie->writer }}</p>
                            @endif
                            @if($movie->production)
                                <p><strong>Production:</strong> {{ $movie->production }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-2 mb-4">
                <a href="{{ route('admin.movies.edit', $movie) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">Edit Movie</a>
                <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
                            onclick="return confirm('Are you sure you want to delete this movie?')">
                        Delete Movie
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Actors Section --}}
    <div class="mt-4">
        <h4 class="text-xl font-semibold mb-3">Actors</h4>
        <p class="mb-3">To manage actors, please <a href="{{ route('admin.movies.edit', $movie) }}" class="text-blue-500 underline">edit the movie</a>.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($movie->actors as $actor)
                <div class="bg-white shadow rounded overflow-hidden flex flex-col">
                    @if($actor->photo)
                        <img src="{{ asset('storage/'.$actor->photo) }}" class="h-64 w-full object-cover" alt="{{ $actor->name }}">
                    @else
                        <div class="h-64 w-full bg-gray-100 flex items-center justify-center">
                            <span class="text-gray-400">No Photo</span>
                        </div>
                    @endif
                    <div class="p-3 flex-1 flex flex-col justify-between">
                        <h5 class="font-semibold">{{ $actor->name }}</h5>
                        @if($actor->character_name)
                            <p class="text-gray-500 text-sm">as {{ $actor->character_name }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-3 text-gray-400">
                    No actors added yet.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
