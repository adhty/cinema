@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🎟️ Daftar Promosi</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola semua promo aktif maupun yang sudah kedaluwarsa.</p>
        </div>
        <a href="{{ route('admin.promos.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-indigo-600 hover:to-blue-700 text-white font-medium px-5 py-2.5 rounded-xl shadow-md transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                 d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Promo
        </a>
    </div>

    {{-- Navigation Tabs --}}
    <div class="mb-6">
        <div class="flex border-b border-gray-200 dark:border-gray-700">
            @php
                $tabs = [
                    'all' => 'Semua Promo',
                    'active' => 'Aktif',
                    'expired' => 'Kedaluwarsa',
                ];
            @endphp

            @foreach ($tabs as $key => $label)
                <a href="{{ route('admin.promos.index', ['status' => $key]) }}"
                   class="px-4 py-2 text-sm font-semibold transition-all duration-200 
                   {{ $status == $key || ($key == 'all' && is_null($status)) 
                      ? 'border-b-2 border-indigo-600 text-indigo-600' 
                      : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-6 shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Promo Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Cover</th>
                    <th class="px-6 py-3 text-left font-semibold">Judul</th>
                    <th class="px-6 py-3 text-left font-semibold">Batas Waktu</th>
                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                    <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($promos as $promo)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-6 py-3">
                            @if ($promo->cover)
                                <img src="{{ asset('storage/' . $promo->cover) }}"
                                     alt="{{ $promo->title }}"
                                     class="w-28 h-16 object-cover rounded-lg shadow-sm border">
                            @else
                                <span class="text-gray-400 italic">No Image</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 font-semibold text-gray-900 dark:text-gray-100">
                            {{ $promo->title }}
                        </td>
                        <td class="px-6 py-3 text-gray-600 dark:text-gray-300">
                            {{ $promo->deadline->format('d M Y') }}
                        </td>
                        <td class="px-6 py-3">
                            @if ($promo->deadline >= now())
                                <span class="px-3 py-1.5 inline-flex items-center gap-1 text-sm font-semibold bg-green-100 text-green-800 rounded-full">
                                    🟢 Aktif
                                </span>
                            @else
                                <span class="px-3 py-1.5 inline-flex items-center gap-1 text-sm font-semibold bg-red-100 text-red-800 rounded-full">
                                    🔴 Kedaluwarsa
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.promos.show', $promo) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs shadow transition duration-200">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.promos.edit', $promo) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs shadow transition duration-200">
                                    Edit
                                </a>
                                <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus promo ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs shadow transition duration-200">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada promo ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
