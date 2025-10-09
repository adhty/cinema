@extends('layouts.admin')

@section('title', 'Daftar Cinema')

@section('content')
<div class="container mx-auto py-4">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-2xl">Daftar Cinema</h2>
        <a href="{{ route('admin.cinemas.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center">
            <i class="bi bi-plus-lg mr-1"></i> Tambah Cinema
        </a>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-3" role="alert">
        <strong class="font-bold"><i class="bi bi-check-circle-fill"></i></strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <button type="button" onclick="this.parentElement.parentElement.remove()">
                <i class="bi bi-x-lg"></i>
            </button>
        </span>
    </div>
    @endif

    {{-- Search bar --}}
    <form action="{{ route('admin.cinemas.index') }}" method="GET" class="mb-3">
        <div class="flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama cinema..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-l focus:outline-none focus:ring focus:border-blue-300">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    {{-- Card Tabel --}}
    <div class="bg-white shadow rounded overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-800 text-white text-center">
                    <tr>
                        <th class="w-1/12 px-2 py-2">#</th>
                        @php
                            $nameSort = request('name_sort') === 'asc' ? 'desc' : 'asc';
                            $citySort = request('city_sort') === 'asc' ? 'desc' : 'asc';
                        @endphp
                        <th class="w-24 px-2 py-2">Gambar</th>
                        <th class="px-2 py-2">
                            <a href="{{ route('admin.cinemas.index', array_merge(request()->all(), ['name_sort' => $nameSort])) }}" class="text-white hover:underline">
                                Nama
                                @if(request('name_sort') === 'asc')
                                    <i class="bi bi-arrow-up-short"></i>
                                @elseif(request('name_sort') === 'desc')
                                    <i class="bi bi-arrow-down-short"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-2 py-2">
                            <a href="{{ route('admin.cinemas.index', array_merge(request()->all(), ['city_sort' => $citySort])) }}" class="text-white hover:underline">
                                Kota
                                @if(request('city_sort') === 'asc')
                                    <i class="bi bi-arrow-up-short"></i>
                                @elseif(request('city_sort') === 'desc')
                                    <i class="bi bi-arrow-down-short"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-2 py-2">Alamat</th>
                        <th class="w-44 px-2 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center divide-y divide-gray-200">
                    @forelse($cinemas as $cinema)
                    <tr class="hover:bg-gray-50">
                        <td class="px-2 py-2">{{ $loop->iteration + ($cinemas->currentPage() - 1) * $cinemas->perPage() }}</td>
                        <td class="px-2 py-2">
                            @if($cinema->image)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $cinema->id }}">
                                    <img src="{{ asset('storage/'.$cinema->image) }}" 
                                         alt="{{ $cinema->name }}" 
                                         class="rounded w-20 h-12 object-cover mx-auto">
                                </a>

                                {{-- Modal Zoom Image --}}
                                <div class="modal fade" id="imageModal{{ $cinema->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <img src="{{ asset('storage/'.$cinema->image) }}" class="w-full">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>
                        <td class="px-2 py-2">{{ $cinema->name }}</td>
                        <td class="px-2 py-2">{{ $cinema->city->name ?? '-' }}</td>
                        <td class="px-2 py-2">{{ $cinema->address }}</td>
                        <td class="px-2 py-2 space-x-1">
                            <a href="{{ route('admin.cinemas.edit', $cinema->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded inline-flex items-center">
                                <i class="bi bi-pencil-square mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.cinemas.destroy', $cinema->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus cinema ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded inline-flex items-center">
                                    <i class="bi bi-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-gray-400 py-3">Belum ada data cinema</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-end mt-3">
        {{ $cinemas->withQueryString()->links() }}
    </div>

</div>
@endsection
