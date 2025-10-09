@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto mt-10 bg-white rounded-2xl shadow p-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-purple-700 flex items-center gap-2">
            <i class="bi bi-people"></i> Daftar Pengguna
        </h2>
        <a href="{{ route('admin.users.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-1">
            <i class="bi bi-person-plus"></i> Tambah User
        </a>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-3 mb-6 items-start sm:items-center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
               class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-1/3 focus:outline-none focus:ring-2 focus:ring-purple-500">
        
        <select name="role" class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-1/4 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="">-- Semua Role --</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
        </select>

        <div class="flex gap-2 w-full sm:w-auto mt-2 sm:mt-0">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-1">
                <i class="bi bi-search"></i> Cari
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow transition flex items-center gap-1">
                <i class="bi bi-arrow-repeat"></i> Reset
            </a>
        </div>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr class="text-gray-700 uppercase text-sm">
                    <th class="p-3 border-b">No</th>
                    <th class="p-3 border-b">Nama Lengkap</th>
                    <th class="p-3 border-b">Email</th>
                    <th class="p-3 border-b">Role</th>
                    <th class="p-3 border-b">Dibuat Pada</th>
                    <th class="p-3 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse ($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3 border-b">{{ $users->firstItem() + $index }}</td>
                        <td class="p-3 border-b">{{ $user->name }}</td>
                        <td class="p-3 border-b">{{ $user->email }}</td>
                        <td class="p-3 border-b">
                            <span class="px-2 py-1 rounded-full text-sm font-semibold {{ $user->role === 'admin' ? 'bg-purple-600 text-white' : 'bg-gray-400 text-white' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="p-3 border-b">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="p-3 border-b text-center flex justify-center gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition flex items-center">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition flex items-center">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Tidak ada data pengguna</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 flex justify-end">
        {{ $users->appends(request()->query())->links() }}
    </div>
</div>
@endsection
