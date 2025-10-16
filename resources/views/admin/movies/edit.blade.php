@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">🎬 Edit Movie</h1>
        <a href="{{ route('admin.movies.index') }}"
           class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded-lg shadow transition">
           ← Back to Movies
        </a>
    </div>

    {{-- Edit Form Card --}}
    <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100">
        <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Include Form Partial --}}
            @include('admin.movies.form')

            {{-- Buttons --}}
            <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                <button type="submit"
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg shadow transition">
                    💾 Update Movie
                </button>
                <a href="{{ route('admin.movies.index') }}"
                   class="inline-flex items-center bg-gray-400 hover:bg-gray-500 text-white px-6 py-2.5 rounded-lg shadow transition">
                    ✖ Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
