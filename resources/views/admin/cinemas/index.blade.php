@extends('layouts.admin')

@section('title', 'Daftar Cinema')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Cinema</h2>
    <a href="{{ route('admin.cinemas.create') }}" class="btn btn-primary">+ Tambah Cinema</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Gambar</th> {{-- 🔥 kolom baru --}}
            <th>Nama</th>
            <th>Kota</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($cinemas as $cinema)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                @if($cinema->image)
                    <img src="{{ asset('storage/'.$cinema->image) }}" 
                         alt="{{ $cinema->name }}" 
                         width="80" 
                         class="rounded">
                @else
                    <span class="text-muted">No Image</span>
                @endif
            </td>
            <td>{{ $cinema->name }}</td>
            <td>{{ $cinema->city->name ?? '-' }}</td>
            <td>{{ $cinema->address }}</td>
            <td>
                <a href="{{ route('admin.cinemas.edit', $cinema->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.cinemas.destroy', $cinema->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus cinema ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Belum ada data cinema</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
