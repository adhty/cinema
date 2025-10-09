@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-4">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-3">
        <h4 class="font-bold text-xl flex items-center">
            <i class="bi bi-pencil-square me-2"></i> Edit Studio
        </h4>
        <a href="{{ route('admin.studios.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded flex items-center">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white shadow rounded border border-gray-100">
        <div class="p-6">
            <form action="{{ route('admin.studios.update', $studio->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Cinema --}}
                <div>
                    <label for="cinema_id" class="block mb-1 font-semibold">Pilih Cinema</label>
                    <select name="cinema_id" id="cinema_id" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 @error('cinema_id') border-red-500 @enderror">
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}" {{ $studio->cinema_id == $cinema->id ? 'selected' : '' }}>
                                {{ $cinema->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cinema_id')
                        <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Studio --}}
                <div>
                    <label for="name" class="block mb-1 font-semibold">Nama Studio</label>
                    <input type="text" id="name" name="name" required
                           value="{{ old('name', $studio->name) }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 @error('name') border-red-500 @enderror">
                    @error('name')
                        <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block mb-1 font-semibold">Harga Weekday (Rp)</label>
                        <input type="number" name="weekday_price" min="0" step="1" required
                               value="{{ old('weekday_price', $studio->cinemaPrice->weekday_price ?? 0) }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 @error('weekday_price') border-red-500 @enderror">
                        @error('weekday_price')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Harga Jumat (Rp)</label>
                        <input type="number" name="friday_price" min="0" step="1" required
                               value="{{ old('friday_price', $studio->cinemaPrice->friday_price ?? 0) }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 @error('friday_price') border-red-500 @enderror">
                        @error('friday_price')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Harga Weekend (Rp)</label>
                        <input type="number" name="weekend_price" min="0" step="1" required
                               value="{{ old('weekend_price', $studio->cinemaPrice->weekend_price ?? 0) }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 @error('weekend_price') border-red-500 @enderror">
                        @error('weekend_price')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex items-center">
                        <i class="bi bi-save me-1"></i> Update Studio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
