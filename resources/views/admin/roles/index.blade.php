@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto mt-10">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-extrabold text-purple-700 tracking-tight">
                🛡️ Daftar Hak Akses
            </h2>
            <a href="{{ route('admin.roles.create') }}" 
               class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:opacity-90 text-white font-medium px-5 py-2 rounded-xl shadow-md transition duration-200">
                + Tambah Role
            </a>
        </div>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="flex items-center bg-green-50 border border-green-400 text-green-800 px-4 py-3 rounded-lg mb-6 shadow-sm">
                ✅ <span class="ml-2">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="overflow-hidden border border-gray-200 rounded-xl shadow-sm">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gradient-to-r from-gray-100 to-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Role Name</th>
                        <th class="px-6 py-3 text-left font-semibold">Permissions</th>
                        <th class="px-6 py-3 text-center font-semibold w-1/5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($roles as $role)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            {{-- Nama Role --}}
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $role->name }}</td>

                            {{-- Permissions --}}
                            <td class="px-6 py-4">
                                @if ($role->permissions->isEmpty())
                                    <span class="text-gray-400 italic">Tidak ada izin</span>
                                @else
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($role->permissions as $perm)
                                            <div class="bg-purple-50 border border-purple-100 px-3 py-2 rounded-lg">
                                                <span class="font-semibold text-purple-700">{{ $perm->menu_name }}</span>:
                                                @php
                                                    $actions = [];
                                                    if ($perm->can_view) $actions[] = '<span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-md text-xs">View</span>';
                                                    if ($perm->can_create) $actions[] = '<span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-md text-xs">Create</span>';
                                                    if ($perm->can_update) $actions[] = '<span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-md text-xs">Update</span>';
                                                    if ($perm->can_delete) $actions[] = '<span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-md text-xs">Delete</span>';
                                                    if ($perm->can_approve) $actions[] = '<span class="bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-md text-xs">Approve</span>';
                                                @endphp
                                                {!! implode(' ', $actions) !!}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                       class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-white font-medium px-3 py-1.5 rounded-lg text-xs shadow-sm transition duration-200">
                                        ✏️ Edit
                                    </a>
                                    
                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" 
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus role {{ $role->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white font-medium px-3 py-1.5 rounded-lg text-xs shadow-sm transition duration-200">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-gray-500 italic">
                                Belum ada role yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
