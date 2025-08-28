@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Studios</h2>
    <a href="{{ route('studios.create') }}" class="btn btn-primary mb-3">+ Add Studio</a>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Cinema</th>
            <th>Name</th>
            <th>Weekday Price</th>
            <th>Friday Price</th>
            <th>Weekend Price</th>
            <th>Action</th>
        </tr>
        @foreach($studios as $studio)
        <tr>
            <td>{{ $studio->id }}</td>
            <td>{{ optional($studio->cinema)->name ?? '-' }}</td>
            <td>{{ $studio->name }}</td>
            <td>Rp {{ number_format(optional($studio->cinemaPrice)->weekday_price ?? 0, 0, ',', '.') }}</td>
            <td>Rp {{ number_format(optional($studio->cinemaPrice)->friday_price ?? 0, 0, ',', '.') }}</td>
            <td>Rp {{ number_format(optional($studio->cinemaPrice)->weekend_price ?? 0, 0, ',', '.') }}</td>
            <td>
                <a href="{{ route('studios.edit',$studio->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('studios.destroy',$studio->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
