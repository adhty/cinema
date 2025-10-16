@extends('layouts.admin')

@section('title', $movie->title)

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    {{-- Movie Detail Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">{{ $movie->title }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.movies.edit', $movie) }}"
               class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-white font-medium px-4 py-2 rounded-lg shadow transition">
                ✏️ Edit
            </a>
            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this movie?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white font-medium px-4 py-2 rounded-lg shadow transition">
                    🗑️ Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Movie Card --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-10">
        <div class="flex flex-col lg:flex-row">
            {{-- Cover --}}
            @if($movie->cover)
                <div class="lg:w-1/3">
                    <img src="{{ asset('storage/'.$movie->cover) }}" alt="{{ $movie->title }}"
                         class="w-full h-full object-cover">
                </div>
            @endif

            {{-- Info --}}
            <div class="lg:w-2/3 p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                    <div class="space-y-1">
                        <p><span class="font-semibold">🎞️ Duration:</span> {{ $movie->duration }} minutes</p>
                        <p><span class="font-semibold">🔞 Age Rating:</span> {{ $movie->age }}+</p>
                        @if($movie->animation_type)
                            <p><span class="font-semibold">🧩 Animation Type:</span> {{ $movie->animation_type }}</p>
                        @endif
                    </div>
                    <div class="space-y-1">
                        @if($movie->start_showing)
                            <p><span class="font-semibold">📅 Start Showing:</span> {{ $movie->start_showing }}</p>
                        @endif
                        @if($movie->start_selling)
                            <p><span class="font-semibold">🎟️ Start Selling:</span> {{ $movie->start_selling }}</p>
                        @endif
                    </div>
                </div>

                {{-- Synopsis --}}
                @if($movie->synopsis)
                    <div class="pt-3 border-t border-gray-200">
                        <h3 class="font-semibold mb-1">🧾 Synopsis</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $movie->synopsis }}</p>
                    </div>
                @endif

                {{-- Crew Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-4 border-t border-gray-200 text-gray-700">
                    @if($movie->producer)
                        <p><strong>🎬 Producer:</strong> {{ $movie->producer }}</p>
                    @endif
                    @if($movie->director)
                        <p><strong>🎥 Director:</strong> {{ $movie->director }}</p>
                    @endif
                    @if($movie->writer)
                        <p><strong>✍️ Writer:</strong> {{ $movie->writer }}</p>
                    @endif
                    @if($movie->production)
                        <p><strong>🏢 Production:</strong> {{ $movie->production }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Actors Section --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">🎭 Cast & Actors</h2>
            <a href="{{ route('admin.movies.edit', $movie) }}"
               class="text-blue-600 hover:underline font-medium">
               Manage Actors →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($movie->actors as $actor)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    @if($actor->photo)
                        <img src="{{ asset('storage/'.$actor->photo) }}" alt="{{ $actor->name }}"
                             class="h-64 w-full object-cover">
                    @else
                        <div class="h-64 w-full bg-gray-100 flex items-center justify-center text-gray-400">
                            No Photo
                        </div>
                    @endif
                    <div class="p-4">
                        <h5 class="font-semibold text-gray-800">{{ $actor->name }}</h5>
                        @if($actor->character_name)
                            <p class="text-sm text-gray-500 italic">as {{ $actor->character_name }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-gray-400 text-center py-10">
                    No actors added yet 🎬
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
