@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Cities</h1>
    <a href="{{ route('cities.create') }}" class="btn btn-primary mb-3">Tambah City</a>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        @foreach($cities as $city)
        <tr>
            <td>{{ $city->id }}</td>
            <td>{{ $city->name }}</td>
            <td>
                <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('cities.destroy', $city->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
