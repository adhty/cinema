@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-people text-primary"></i> Daftar Pengguna</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah User</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama atau email...">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select">
                <option value="">-- Semua Role --</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
        </div>
        <div class="col-md-2 d-grid">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-repeat"></i> Reset</a>
        </div>
    </form>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td class="text-start">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-success me-1"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">Tidak ada data pengguna</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
