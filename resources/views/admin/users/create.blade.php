@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white rounded-2xl shadow p-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-purple-700 flex items-center gap-2">
            <i class="bi bi-person-plus-fill"></i> Tambah User
        </h2>
        <a href="{{ route('admin.users.index') }}"
           class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow transition flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Nama Lengkap --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                   required>
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                   required>
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                   required>
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                   required>
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
            <select name="role" id="role"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                    required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        {{-- Nomor Telepon (Opsional) --}}
        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon (Opsional)</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                   placeholder="Contoh: 081234567890">
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end pt-6">
            <button type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg shadow transition flex items-center gap-2 font-semibold">
                <i class="bi bi-check-circle-fill"></i> Simpan User
            </button>
        </div>
    </form>
</div>

{{-- Animasi loading saat submit --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        form.addEventListener('submit', () => {
            const btn = form.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Menyimpan...';
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        });
    });
</script>
@endsection
