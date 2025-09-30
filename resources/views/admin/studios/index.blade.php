@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Studios</h1>
    <a href="{{ route('admin.studios.create') }}" class="btn btn-primary mb-3">+ Tambah Studio</a>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Cinema</th>
                <th>Name</th>
                <th>Weekday Price</th>
                <th>Friday Price</th>
                <th>Weekend Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($studios as $studio)
            <tr>
                <td>{{ $studio->id }}</td>
                <td>{{ optional($studio->cinema)->name ?? '-' }}</td>
                <td>{{ $studio->name }}</td>
                <td>Rp {{ number_format(optional($studio->cinemaPrice)->weekday_price ?? 0, 0, ',', '.') }}</td>
                <td>Rp {{ number_format(optional($studio->cinemaPrice)->friday_price ?? 0, 0, ',', '.') }}</td>
                <td>Rp {{ number_format(optional($studio->cinemaPrice)->weekend_price ?? 0, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('admin.studios.edit', $studio->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.studios.destroy', $studio->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau dihapus?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
