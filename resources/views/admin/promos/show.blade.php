@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-10">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
            🎟️ Promo Details
        </h1>
        <a href="{{ route('admin.promos.index') }}" 
           class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- Promo Card --}}
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100 p-6 md:p-8">
        <div class="grid md:grid-cols-2 gap-8 items-start">
            {{-- Image Section --}}
            <div class="w-full">
                @if ($promo->cover)
                    <img src="{{ asset('storage/' . $promo->cover) }}" 
                         alt="{{ $promo->title }}" 
                         class="w-full h-auto max-h-[380px] object-contain rounded-lg border border-gray-200 shadow-sm">
                @else
                    <div class="w-full h-64 flex items-center justify-center bg-gray-100 rounded-lg border border-gray-200">
                        <span class="text-gray-500 text-sm">No Image Available</span>
                    </div>
                @endif
            </div>

            {{-- Text Section --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">{{ $promo->title }}</h2>

                {{-- Status --}}
                <div class="mb-4">
                    @if ($promo->deadline >= now())
                        <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold bg-green-100 text-green-700 rounded-full">
                            <i class="fa-solid fa-circle-check"></i> Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-3 py-1 text-sm font-semibold bg-red-100 text-red-700 rounded-full">
                            <i class="fa-solid fa-clock"></i> Expired
                        </span>
                    @endif
                </div>

                {{-- Info --}}
                <p class="text-gray-700 mb-3">
                    <strong>Deadline:</strong> {{ $promo->deadline->format('d M Y') }}
                </p>

                <div class="mb-5">
                    <p class="font-semibold mb-1 text-blue-600">Description:</p>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $promo->description ?? 'No description provided.' }}
                    </p>
                </div>

                <div class="mb-6">
                    <p class="font-semibold mb-1 text-blue-600">Terms & Conditions:</p>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $promo->term_condition ?? 'No terms & conditions available.' }}
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex gap-4 mt-6">
                    <a href="{{ route('admin.promos.edit', $promo) }}" 
                       class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>

                    <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this promo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg shadow transition duration-200">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
