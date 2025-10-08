@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-camera-reels me-2"></i> Daftar Studio
        </h4>
        <a href="{{ route('admin.studios.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Studio
        </a>
    </div>

    {{-- Card Tabel --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if($studios->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
                    Belum ada data studio.
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cinema</th>
                            <th>Nama Studio</th>
                            <th>Harga Weekday</th>
                            <th>Harga Jumat</th>
                            <th>Harga Weekend</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studios as $studio)
                        <tr>
                            <td>{{ $studio->id }}</td>
                            <td>{{ optional($studio->cinema)->name ?? '-' }}</td>
                            <td>{{ $studio->name }}</td>
                            <td>Rp {{ number_format($studio->weekday_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($studio->friday_price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($studio->weekend_price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.studios.edit', $studio->id) }}" 
                                   class="btn btn-warning btn-sm me-1">
                                   <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.studios.destroy', $studio->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus studio ini?')">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
