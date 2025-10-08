@extends('layouts.admin')

@section('title', 'Daftar Kota')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Daftar Kota</h2>
        <a href="{{ route('admin.cities.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Tambah Kota
        </a>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Search bar --}}
    <form action="{{ route('admin.cities.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama kota...">
            <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    {{-- Card Tabel --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th>Nama Kota</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $city)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($cities->currentPage() - 1) * $cities->perPage() }}</td>
                            <td>{{ $city->name }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin mau dihapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">Belum ada data kota</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $cities->withQueryString()->links() }}
    </div>
</div>
@endsection
