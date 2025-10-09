@extends('layouts.admin')

@section('title', 'Movies')

@section('content')
<div class="container mx-auto my-4">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Movies</h1>
        <a href="{{ route('admin.movies.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex items-center">
            <i class="bi bi-plus-lg me-1"></i> Add Movie
        </a>
    </div>

    {{-- Movies Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($movies as $movie)
            <div class="bg-white shadow rounded overflow-hidden flex flex-col h-full">
                @if($movie->cover)
                    <img src="{{ asset('storage/'.$movie->cover) }}" 
                         class="h-72 w-full object-cover" 
                         alt="{{ $movie->title }}">
                @else
                    <div class="h-72 w-full bg-gray-100 flex items-center justify-center">
                        <span class="text-gray-400">No Cover</span>
                    </div>
                @endif

                <div class="p-4 flex flex-col flex-1">
                    <h5 class="font-semibold text-lg mb-1">{{ $movie->title }}</h5>
                    <p class="mb-1 text-sm"><strong>Duration:</strong> {{ $movie->duration }} mins</p>
                    <p class="mb-1 text-sm"><strong>Age:</strong> <span class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded">{{ $movie->age }}+</span></p>
                    <p class="mb-2 text-sm"><strong>Actors:</strong> {{ $movie->actors->count() }}</p>

                    <div class="mt-auto flex justify-between gap-2">
                        <a href="{{ route('admin.movies.show', $movie) }}" class="bg-teal-400 hover:bg-teal-500 text-white px-2 py-1 rounded text-sm flex items-center justify-center" title="Detail">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.movies.edit', $movie) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded text-sm flex items-center justify-center" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-sm flex items-center justify-center" 
                                    onclick="return confirm('Delete this movie?')" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-3 text-center text-gray-400 py-6">
                No movies found.
            </div>
        @endforelse
    </div>
</div>
@endsection
