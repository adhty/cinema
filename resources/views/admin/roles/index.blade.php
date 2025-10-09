@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white rounded-2xl shadow p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-purple-700">Daftar Hak Akses</h2>
        <a href="{{ route('admin.roles.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow">+ Tambah Role</a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border text-sm border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-3 text-left">Role Name</th>
                <th class="border p-3 text-left">Permissions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($roles as $role)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 font-medium">{{ $role->name }}</td>
                <td class="p-3">
                    <ul class="list-disc list-inside text-gray-700">
                        @foreach ($role->permissions as $perm)
                            <li>
                                <strong>{{ $perm->menu_name }}</strong>:
                                @php
                                    $actions = [];
                                    if ($perm->can_view) $actions[] = 'View';
                                    if ($perm->can_create) $actions[] = 'Create';
                                    if ($perm->can_update) $actions[] = 'Update';
                                    if ($perm->can_delete) $actions[] = 'Delete';
                                    if ($perm->can_approve) $actions[] = 'Approve';
                                @endphp
                                {{ implode(', ', $actions) ?: 'Tidak ada izin' }}
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center text-gray-500 p-4">Belum ada role yang dibuat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
