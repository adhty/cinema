@extends('layouts.admin')

@section('title', 'Daftar Kota')

@section('content')
<div class="px-6 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Kota</h2>
        <a href="{{ route('admin.cities.create') }}"
           class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium shadow transition">
            <i class="fa-solid fa-plus"></i> Tambah Kota
        </a>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="flex items-center justify-between bg-green-100 border border-green-300 text-green-800 rounded-lg p-4">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-green-600"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-800 hover:text-green-900">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    {{-- Search bar --}}
    <form action="{{ route('admin.cities.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 sm:gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama kota..."
               class="w-full sm:w-auto flex-grow rounded-lg border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition p-2.5">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg font-medium transition">
            <i class="fa-solid fa-magnifying-glass"></i> Cari
        </button>
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="px-4 py-3 text-center w-12">#</th>
                    <th class="px-4 py-3">Nama Kota</th>
                    <th class="px-4 py-3 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cities as $city)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 text-center font-medium text-gray-700">
                            {{ $loop->iteration + ($cities->currentPage() - 1) * $cities->perPage() }}
                        </td>
                        <td class="px-4 py-3 text-gray-800">{{ $city->name }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.cities.edit', $city->id) }}"
                                   class="text-yellow-500 hover:text-yellow-600 transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.cities.destroy', $city->id) }}"
                                      method="POST" onsubmit="return confirm('Yakin mau dihapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-gray-400 py-6">Belum ada data kota</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-end">
        {{ $cities->withQueryString()->links() }}
    </div>
</div>
@endsection
