@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-4">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-3">
        <h4 class="font-bold text-xl flex items-center">
            <i class="bi bi-camera-reels me-2"></i> Daftar Studio
        </h4>
        <a href="{{ route('admin.studios.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow flex items-center">
            <i class="bi bi-plus-circle me-1"></i> Tambah Studio
        </a>
    </div>

    {{-- Card Tabel --}}
    <div class="bg-white shadow rounded border border-gray-100">
        <div class="p-4">
            @if($studios->isEmpty())
                <div class="text-center text-gray-400 py-10">
                    <i class="bi bi-exclamation-circle text-3xl block mb-2"></i>
                    Belum ada data studio.
                </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse">
                    <thead class="bg-gray-100 text-left text-gray-700">
                        <tr>
                            <th class="px-3 py-2">ID</th>
                            <th class="px-3 py-2">Cinema</th>
                            <th class="px-3 py-2">Nama Studio</th>
                            <th class="px-3 py-2">Harga Weekday</th>
                            <th class="px-3 py-2">Harga Jumat</th>
                            <th class="px-3 py-2">Harga Weekend</th>
                            <th class="px-3 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($studios as $studio)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2">{{ $studio->id }}</td>
                            <td class="px-3 py-2">{{ optional($studio->cinema)->name ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $studio->name }}</td>
                            <td class="px-3 py-2">Rp {{ number_format($studio->weekday_price, 0, ',', '.') }}</td>
                            <td class="px-3 py-2">Rp {{ number_format($studio->friday_price, 0, ',', '.') }}</td>
                            <td class="px-3 py-2">Rp {{ number_format($studio->weekend_price, 0, ',', '.') }}</td>
                            <td class="px-3 py-2 text-center space-x-1">
                                <a href="{{ route('admin.studios.edit', $studio->id) }}" 
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded inline-flex items-center">
                                   <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.studios.destroy', $studio->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded inline-flex items-center"
                                            onclick="return confirm('Yakin ingin menghapus studio ini?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
