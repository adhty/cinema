@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Promo Details</h1>
        <a href="{{ route('admin.promos.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded shadow">
            Back to Promos
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-blue-600">Promo Information</h2>
        </div>
        <div class="px-6 py-4">
            <div class="md:flex md:gap-6">
                <div class="md:w-1/3 mb-4 md:mb-0">
                    @if ($promo->cover)
                        <img src="{{ asset('storage/' . $promo->cover) }}" alt="{{ $promo->title }}" class="w-full h-auto rounded">
                    @else
                        <div class="w-full h-48 flex items-center justify-center bg-gray-100 rounded">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="md:w-2/3">
                    <h2 class="text-xl font-semibold mb-2">{{ $promo->title }}</h2>
                    <p class="mb-2"><strong>Deadline:</strong> {{ $promo->deadline->format('d M Y') }}</p>
                    <p class="mb-1 font-semibold">Description:</p>
                    <p class="mb-2 text-gray-700">{{ $promo->description ?? 'No description' }}</p>
                    <p class="mb-1 font-semibold">Term & Condition:</p>
                    <p class="mb-4 text-gray-700">{{ $promo->term_condition ?? 'No term & condition' }}</p>

                    <div class="flex gap-3">
                        <a href="{{ route('admin.promos.edit', $promo) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded shadow">
                            Edit
                        </a>
                        <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
