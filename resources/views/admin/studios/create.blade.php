@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-plus-circle text-green-600"></i> Tambah Studio
        </h2>
        <a href="{{ route('admin.studios.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-4 py-2 rounded-lg shadow flex items-center gap-2 transition">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Card Form --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
            
            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-5">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.studios.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Cinema --}}
                <div>
                    <label for="cinema_id" class="block mb-1.5 font-semibold text-gray-700">Pilih Cinema</label>
                    <select name="cinema_id" id="cinema_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('cinema_id') border-red-500 @enderror">
                        <option value="">-- Pilih Cinema --</option>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}" {{ old('cinema_id') == $cinema->id ? 'selected' : '' }}>
                                {{ $cinema->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cinema_id')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Studio --}}
                <div>
                    <label for="name" class="block mb-1.5 font-semibold text-gray-700">Nama Studio</label>
                    <input type="text" name="name" id="name" required placeholder="Contoh: Studio 1 / VIP Hall"
                        value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block mb-1.5 font-semibold text-gray-700">Harga Weekday (Rp)</label>
                        <input type="number" name="weekday_price" min="0" step="1" required
                            value="{{ old('weekday_price', 0) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('weekday_price') border-red-500 @enderror">
                        @error('weekday_price')
                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1.5 font-semibold text-gray-700">Harga Jumat (Rp)</label>
                        <input type="number" name="friday_price" min="0" step="1" required
                            value="{{ old('friday_price', 0) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('friday_price') border-red-500 @enderror">
                        @error('friday_price')
                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1.5 font-semibold text-gray-700">Harga Weekend (Rp)</label>
                        <input type="number" name="weekend_price" min="0" step="1" required
                            value="{{ old('weekend_price', 0) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('weekend_price') border-red-500 @enderror">
                        @error('weekend_price')
                            <p class="text-red-600 mt-1 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end pt-3">
                    <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2.5 rounded-lg shadow flex items-center gap-2 transition">
                        <i class="bi bi-check-circle"></i> Simpan Studio
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
