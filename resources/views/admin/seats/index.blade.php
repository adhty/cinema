@extends('layouts.admin')

@section('title', 'Daftar Kursi')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Kursi</h2>
        <a href="{{ route('admin.seats.create') }}" class="btn btn-primary">+ Tambah Kursi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Film</th>
                <th>Studio</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Nomor Kursi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seats as $seat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $seat->ticket->movie->title ?? '-' }}</td>
                    <td>{{ $seat->ticket->studio->name ?? '-' }}</td>
                    <td>{{ $seat->ticket->date ?? '-' }}</td>
                    <td>{{ $seat->ticket->time ?? '-' }}</td>
                    <td>{{ $seat->number }}</td>
                    <td>
                        @if($seat->status === 'available')
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-danger">Booked</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.seats.edit', $seat->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.seats.destroy', $seat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kursi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data kursi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
