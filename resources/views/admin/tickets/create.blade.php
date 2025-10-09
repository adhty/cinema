@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold">🎫 Create New Ticket</h2>
        <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">← Back to Tickets</a>
    </div>

    {{-- Form --}}
    <div class="bg-white shadow rounded p-6">
        <form method="POST" action="{{ route('admin.tickets.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Movie --}}
                <div>
                    <label for="movie_id" class="block font-medium mb-1">Movie <span class="text-red-500">*</span></label>
                    <select name="movie_id" id="movie_id" class="w-full border-gray-300 rounded @error('movie_id') border-red-500 @enderror" required>
                        <option value="">Select Movie</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
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
                            <option value="{{ $cinema->id }}" {{ old('cinema_id') == $cinema->id ? 'selected' : '' }}>
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
                            <option value="{{ $studio->id }}" {{ old('studio_id') == $studio->id ? 'selected' : '' }}>
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
                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
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
                    <input type="date" name="date" id="date" value="{{ old('date') }}" min="{{ date('Y-m-d') }}" 
                           class="w-full border-gray-300 rounded @error('date') border-red-500 @enderror" required>
                    @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Time --}}
                <div>
                    <label for="time" class="block font-medium mb-1">Time <span class="text-red-500">*</span></label>
                    <input type="time" name="time" id="time" value="{{ old('time') }}" 
                           class="w-full border-gray-300 rounded @error('time') border-red-500 @enderror" required>
                    @error('time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label for="price" class="block font-medium mb-1">Price (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="1000" placeholder="50000"
                           class="w-full border-gray-300 rounded @error('price') border-red-500 @enderror" required>
                    @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Create Ticket
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Set default time suggestion
document.addEventListener('DOMContentLoaded', function() {
    const timeInput = document.getElementById('time');
    if (!timeInput.value) {
        const times = ['10:00','13:00','16:00','19:00','21:30'];
        const now = new Date().getHours();
        for (let t of times) {
            if (parseInt(t.split(':')[0]) > now) {
                timeInput.value = t;
                break;
            }
        }
    }
});
</script>
@endsection
