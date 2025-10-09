@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold">🎫 Edit Ticket #{{ $ticket->id }}</h2>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">
                ← Back to Ticket
            </a>
            <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 transition">
                All Tickets
            </a>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white shadow rounded p-6 mb-6">
        <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Movie --}}
                <div>
                    <label for="movie_id" class="block font-medium mb-1">Movie <span class="text-red-500">*</span></label>
                    <select name="movie_id" id="movie_id" class="w-full border-gray-300 rounded @error('movie_id') border-red-500 @enderror" required>
                        <option value="">Select Movie</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ (old('movie_id') ?? $ticket->movie_id) == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('movie_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Cinema --}}
                <div>
                    <label for="cinema_id" class="block font-medium mb-1">Cinema <span class="text-red-500">*</span></label>
                    <select name="cinema_id" id="cinema_id" class="w-full border-gray-300 rounded @error('cinema_id') border-red-500 @enderror" required>
                        <option value="">Select Cinema</option>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}" {{ (old('cinema_id') ?? $ticket->cinema_id) == $cinema->id ? 'selected' : '' }}>
                                {{ $cinema->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cinema_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Studio --}}
                <div>
                    <label for="studio_id" class="block font-medium mb-1">Studio <span class="text-red-500">*</span></label>
                    <select name="studio_id" id="studio_id" class="w-full border-gray-300 rounded @error('studio_id') border-red-500 @enderror" required>
                        <option value="">Select Studio</option>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}" {{ (old('studio_id') ?? $ticket->studio_id) == $studio->id ? 'selected' : '' }}>
                                {{ $studio->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('studio_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- City --}}
                <div>
                    <label for="city_id" class="block font-medium mb-1">City <span class="text-red-500">*</span></label>
                    <select name="city_id" id="city_id" class="w-full border-gray-300 rounded @error('city_id') border-red-500 @enderror" required>
                        <option value="">Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ (old('city_id') ?? $ticket->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                {{-- Date --}}
                <div>
                    <label for="date" class="block font-medium mb-1">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="date" value="{{ old('date') ?? $ticket->date }}" min="{{ date('Y-m-d') }}" 
                           class="w-full border-gray-300 rounded @error('date') border-red-500 @enderror" required>
                    @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Time --}}
                <div>
                    <label for="time" class="block font-medium mb-1">Time <span class="text-red-500">*</span></label>
                    <input type="time" name="time" id="time" value="{{ old('time') ?? $ticket->time }}" 
                           class="w-full border-gray-300 rounded @error('time') border-red-500 @enderror" required>
                    @error('time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label for="price" class="block font-medium mb-1">Price (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price') ?? $ticket->price }}" min="0" step="1000" 
                           class="w-full border-gray-300 rounded @error('price') border-red-500 @enderror" required>
                    @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Warning --}}
            @if($ticket->seats->where('status', 'booked')->count() > 0)
                <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-700 p-4 mt-4" role="alert">
                    <p class="font-semibold">Warning:</p>
                    <p>This ticket has {{ $ticket->seats->where('status', 'booked')->count() }} booked seats. Changing date/time may affect existing bookings.</p>
                </div>
            @endif

            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Update Ticket
                </button>
            </div>
        </form>
    </div>

    {{-- Seats Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        @php
            $totalSeats = $ticket->seats->count();
            $bookedSeats = $ticket->seats->where('status', 'booked')->count();
            $availableSeats = $ticket->seats->where('status', 'available')->count();
        @endphp

        <div class="bg-blue-600 text-white p-4 rounded shadow text-center">
            <h4 class="text-2xl font-bold">{{ $totalSeats }}</h4>
            <span>Total Seats</span>
        </div>

        <div class="bg-green-500 text-white p-4 rounded shadow text-center">
            <h4 class="text-2xl font-bold">{{ $availableSeats }}</h4>
            <span>Available</span>
        </div>

        <div class="bg-red-500 text-white p-4 rounded shadow text-center">
            <h4 class="text-2xl font-bold">{{ $bookedSeats }}</h4>
            <span>Booked</span>
        </div>
    </div>
</div>
@endsection
