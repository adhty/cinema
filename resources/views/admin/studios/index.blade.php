@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-camera-reels text-blue-600"></i> Daftar Studio
        </h2>
        <a href="{{ route('admin.studios.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md transition flex items-center gap-2">
            <i class="bi bi-plus-circle"></i> Tambah Studio
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-4">
            @if($studios->isEmpty())
                <div class="text-center text-gray-400 py-12">
                    <i class="bi bi-exclamation-circle text-4xl mb-2"></i>
                    <p class="text-lg font-medium">Belum ada data studio</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700 border-collapse">
                        <thead class="bg-gray-50 border-b">
                            <tr class="text-left font-semibold">
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Cinema</th>
                                <th class="px-4 py-3">Nama Studio</th>
                                <th class="px-4 py-3">Harga Weekday</th>
                                <th class="px-4 py-3">Harga Jumat</th>
                                <th class="px-4 py-3">Harga Weekend</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studios as $studio)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{ $studio->id }}</td>
                                    <td class="px-4 py-3">{{ optional($studio->cinema)->name ?? '-' }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $studio->name }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($studio->weekday_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($studio->friday_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($studio->weekend_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center flex justify-center gap-2">
                                        <a href="{{ route('admin.studios.edit', $studio->id) }}" 
                                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-md shadow flex items-center justify-center transition">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.studios.destroy', $studio->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus studio ini?')"
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md shadow flex items-center justify-center transition">
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