@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name ?? 'Admin' }} 👋</h1>
            <p class="text-gray-500">Here’s what’s happening today</p>
        </div>
        <a href="{{ route('admin.promos.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-medium rounded-lg transition">
            <i class="fa-solid fa-plus"></i> New Promo
        </a>
    </div>

    {{-- Stats Section --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Total Promos --}}
        <div class="flex items-center bg-white shadow rounded-xl p-5 border border-gray-100">
            <div class="w-12 h-12 flex items-center justify-center bg-violet-500 rounded-lg text-white text-2xl">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Promos</p>
                <h3 class="text-xl font-semibold">{{ $totalPromos ?? 0 }}</h3>
                <p class="text-gray-400 text-sm">All promo data in system</p>
            </div>
        </div>

        {{-- Active Promos --}}
        <div class="flex items-center bg-white shadow rounded-xl p-5 border border-gray-100">
            <div class="w-12 h-12 flex items-center justify-center bg-green-500 rounded-lg text-white text-2xl">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Active Promos</p>
                <h3 class="text-xl font-semibold">{{ $activePromos ?? 0 }}</h3>
                <p class="text-gray-400 text-sm">Currently running promos</p>
            </div>
        </div>

        {{-- Total Cities --}}
        <div class="flex items-center bg-white shadow rounded-xl p-5 border border-gray-100">
            <div class="w-12 h-12 flex items-center justify-center bg-sky-500 rounded-lg text-white text-2xl">
                <i class="fa-solid fa-city"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Cities</p>
                <h3 class="text-xl font-semibold">{{ $totalCities ?? 0 }}</h3>
                <p class="text-gray-400 text-sm">Cities in database</p>
            </div>
        </div>
    </div>

    {{-- Promo Management --}}
    <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-2">
            <i class="fa-solid fa-bullhorn text-yellow-400"></i> Promo Management
        </h2>
        <p class="text-gray-500 text-sm mb-4">Manage and monitor all promos</p>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.promos.index') }}" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-yellow-400 hover:text-gray-900 transition">
                <i class="fa-solid fa-list"></i> All Promos
            </a>
            <a href="#" class="px-4 py-2 rounded-lg bg-green-100 text-green-700 font-medium hover:bg-green-200 transition">
                <i class="fa-solid fa-check"></i> Active Promos
            </a>
            <a href="#" class="px-4 py-2 rounded-lg bg-red-100 text-red-700 font-medium hover:bg-red-200 transition">
                <i class="fa-solid fa-clock-rotate-left"></i> Expired Promos
            </a>
        </div>
    </div>

    {{-- Cities --}}
    <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-4">
            <i class="fa-solid fa-city text-sky-400"></i> Cities
        </h2>
        <a href="{{ route('admin.cities.index') }}" class="inline-flex items-center gap-2 text-sm text-sky-600 hover:text-sky-800 mb-4">
            <i class="fa-solid fa-eye"></i> View All
        </a>

        <table class="w-full border-collapse text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-left">
                    <th class="p-3">#</th>
                    <th class="p-3">City Name</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cities ?? [] as $city)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3">{{ $city->name }}</td>
                    <td class="p-3 flex items-center gap-2">
                        <a href="{{ route('admin.cities.edit', $city->id) }}" class="text-yellow-500 hover:text-yellow-600">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" onsubmit="return confirm('Delete this city?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
