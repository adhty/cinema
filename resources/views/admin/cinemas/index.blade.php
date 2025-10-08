@extends('layouts.admin')

@section('title', 'Daftar Cinema')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Daftar Cinema</h2>
        <a href="{{ route('admin.cinemas.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Tambah Cinema
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
    <form action="{{ route('admin.cinemas.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama cinema...">
            <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    {{-- Card Tabel --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th style="width:5%;">#</th>
                            @php
                                $nameSort = request('name_sort') === 'asc' ? 'desc' : 'asc';
                                $citySort = request('city_sort') === 'asc' ? 'desc' : 'asc';
                            @endphp
                            <th style="width:100px;">Gambar</th>
                            <th>
                                <a href="{{ route('admin.cinemas.index', array_merge(request()->all(), ['name_sort' => $nameSort])) }}" class="text-white text-decoration-none">
                                    Nama
                                    @if(request('name_sort') === 'asc')
                                        <i class="bi bi-arrow-up-short"></i>
                                    @elseif(request('name_sort') === 'desc')
                                        <i class="bi bi-arrow-down-short"></i>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.cinemas.index', array_merge(request()->all(), ['city_sort' => $citySort])) }}" class="text-white text-decoration-none">
                                    Kota
                                    @if(request('city_sort') === 'asc')
                                        <i class="bi bi-arrow-up-short"></i>
                                    @elseif(request('city_sort') === 'desc')
                                        <i class="bi bi-arrow-down-short"></i>
                                    @endif
                                </a>
                            </th>
                            <th>Alamat</th>
                            <th style="width:180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cinemas as $cinema)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($cinemas->currentPage() - 1) * $cinemas->perPage() }}</td>
                            <td class="text-center">
                                @if($cinema->image)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $cinema->id }}">
                                        <img src="{{ asset('storage/'.$cinema->image) }}" 
                                             alt="{{ $cinema->name }}" 
                                             width="80" height="50" 
                                             class="rounded">
                                    </a>

                                    {{-- Modal Zoom Image --}}
                                    <div class="modal fade" id="imageModal{{ $cinema->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <img src="{{ asset('storage/'.$cinema->image) }}" class="img-fluid w-100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $cinema->name }}</td>
                            <td>{{ $cinema->city->name ?? '-' }}</td>
                            <td>{{ $cinema->address }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.cinemas.edit', $cinema->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.cinemas.destroy', $cinema->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus cinema ini?')">
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
                            <td colspan="6" class="text-center text-muted py-3">Belum ada data cinema</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $cinemas->withQueryString()->links() }}
    </div>

</div>
@endsection
