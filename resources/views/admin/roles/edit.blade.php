@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white rounded-2xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6 text-purple-700">
        Edit Hak Akses: {{ $role->name }}
    </h2>

    {{-- 🔴 Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- ⬅️ penting! agar route update bisa dikenali oleh Laravel --}}

        <!-- Role Name -->
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-gray-700">Nama Role</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $role->name) }}"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                   required>
        </div>

        <!-- Menu List -->
        <div class="border border-gray-200 rounded-xl">
            <div class="bg-purple-50 px-4 py-3 border-b border-gray-200 flex items-center">
                <i class="fas fa-list text-purple-600 mr-2"></i>
                <span class="font-semibold text-gray-700">Menu List Allowed</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-gray-100 border-b">
                        <tr class="text-gray-700">
                            <th class="p-3 border-r font-semibold">Menu Name</th>
                            <th class="p-3 text-center">View</th>
                            <th class="p-3 text-center">Create</th>
                            <th class="p-3 text-center">Update</th>
                            <th class="p-3 text-center">Delete</th>
                            <th class="p-3 text-center">Approve</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($menus as $menu)
                            @php
                                $perm = $role->permissions->firstWhere('menu_name', $menu);
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 border-r font-medium text-gray-800">{{ $menu }}</td>
                                @foreach (['view','create','update','delete','approve'] as $permType)
                                    <td class="text-center p-3">
                                        <input
                                            type="checkbox"
                                            name="permissions[{{ $menu }}][{{ $permType }}]"
                                            value="1"
                                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                            {{ $perm && $perm["can_{$permType}"] ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tombol Update -->
        <div class="mt-6 text-right">
            <a href="{{ route('admin.roles.index') }}"
               class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg shadow-md transition mr-2">
                Batal
            </a>
            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition">
                💾 Update Hak Akses
            </button>
        </div>
    </form>
</div>
@endsection
