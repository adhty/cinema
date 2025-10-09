@extends('layouts.admin')

@section('title', 'Edit City')

@section('content')
<div class="max-w-3xl mx-auto py-10">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">✏️ Edit Kota</h2>
        <a href="{{ route('admin.cities.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white shadow-md rounded-xl p-8 border border-gray-100">

        {{-- Error Alert --}}
        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-lg">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.cities.update', $city->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Kota --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kota</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $city->name) }}"
                       placeholder="Masukkan nama kota"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                    <i class="bi bi-pencil-square"></i> Update
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
