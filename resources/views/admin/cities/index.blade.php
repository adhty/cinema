@extends('layouts.admin')

@section('title', 'Daftar Kota')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Kota</h2>
        <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">+ Tambah Kota</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama Kota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cities as $city)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $city->name }}</td>
                <td>
                    <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin mau dihapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Belum ada data kota</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
