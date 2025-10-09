@extends('layouts.admin')

@section('title', 'Tambah Kota')

@section('content')
<div class="px-6 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Kota</h2>
        <a href="{{ route('admin.cities.index') }}"
           class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-medium shadow transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 rounded-lg p-4">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Card Form --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
        <form action="{{ route('admin.cities.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Input --}}
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-2">Nama Kota</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name') }}"
                       placeholder="Masukkan nama kota"
                       required
                       class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition p-2.5 text-gray-800">
            </div>

            {{-- Tombol --}}
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-5 py-2.5 rounded-lg font-semibold transition shadow">
                <i class="fa-solid fa-check"></i> Simpan
            </button>
        </form>
    </div>
</div>
@endsection
