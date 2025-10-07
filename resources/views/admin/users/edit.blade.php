@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Edit User</h4>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ $user->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                           value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label fw-semibold">Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Masukkan password baru jika ingin mengubah">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-pencil"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
