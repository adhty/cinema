@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white rounded-2xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6 text-purple-700">Tambah Hak Akses Baru</h2>

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

    {{-- 🟣 Form create role --}}
    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        {{-- Input nama role --}}
        <div class="mb-6">
            <label for="name" class="block mb-2 font-semibold text-gray-700">Nama Role</label>
            <input
                type="text"
                id="name"
                name="name"
                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                placeholder="Contoh: Admin"
                value="{{ old('name') }}"
                required
            >
        </div>

        {{-- Table permission --}}
        <table class="w-full border text-sm border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border p-2 text-left">Menu</th>
                    <th class="border p-2">View</th>
                    <th class="border p-2">Create</th>
                    <th class="border p-2">Update</th>
                    <th class="border p-2">Delete</th>
                    <th class="border p-2">Approve</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr class="text-center">
                        <td class="border p-2 text-left font-medium text-gray-800">{{ $menu }}</td>
                        @foreach (['view', 'create', 'update', 'delete', 'approve'] as $action)
                            <td class="border p-2">
                                <input
                                    type="checkbox"
                                    name="permissions[{{ $menu }}][{{ $action }}]"
                                    value="1"
                                    {{ old("permissions.$menu.$action") ? 'checked' : '' }}
                                    class="cursor-pointer w-4 h-4 accent-purple-600"
                                >
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tombol simpan --}}
        <div class="mt-6 text-right">
            <button
                type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg shadow-md transition-all duration-200"
            >
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
