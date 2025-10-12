@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white rounded-2xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6 text-purple-700">Edit Hak Akses: {{ $role->name }}</h2>

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf

        <!-- Role Name -->
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-gray-700">User Role</label>
            <input type="text" name="name" value="{{ old('name', $role->name) }}"
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
                            <td class="p-3 border-r font-medium">{{ $menu }}</td>
                            @foreach (['view','create','update','delete','approve'] as $permType)
                            <td class="text-center p-3">
                                <input type="checkbox"
                                    name="permissions[{{ $menu }}][{{ $permType }}]"
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

        <!-- Submit -->
        <div class="mt-6 text-right">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition">
                Update Hak Akses
            </button>
        </div>
    </form>
</div>
@endsection
