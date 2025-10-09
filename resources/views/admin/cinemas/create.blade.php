@extends('layouts.admin')

@section('title', 'Tambah Cinema')

@section('content')
<div class="container mx-auto py-4">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-2xl">Create Cinema</h2>
        <a href="{{ route('admin.cinemas.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded flex items-center">
            <i class="bi bi-arrow-left mr-1"></i> Back
        </a>
    </div>

    {{-- Card Form --}}
    <div class="bg-white shadow rounded">
        <div class="p-6">

            {{-- Error --}}
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc list-inside mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-700">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('admin.cinemas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block mb-1 font-medium">Cover Image</label>
                    <input type="file" name="cover" accept="image/*" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Cinema Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama cinema" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Masukkan alamat" required
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div>
                    <label class="block mb-1 font-medium">City</label>
                    <select name="city_id" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                        <option value="">-- Pilih Kota --</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center">
                        <i class="bi bi-check-lg mr-1"></i> Save
                    </button>
                    <a href="{{ route('admin.cinemas.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded flex items-center">
                        <i class="bi bi-x-lg mr-1"></i> Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
