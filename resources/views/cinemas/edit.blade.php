@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Cinema</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('cinemas.update', $cinema->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="cover">Cover Image</label>
            <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Cinema</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $cinema->name) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $cinema->address) }}">
        </div>

        <div class="mb-3">
            <label for="city_id" class="form-label">Kota</label>
            <select name="city_id" id="city_id" class="form-select">
                <option value="">Pilih Kota</option>
                @foreach ($cities as $city)
                <option value="{{ $city->id }}" {{ (string) old('city_id', $cinema->city_id) === (string) $city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('cinemas.index') }}" class="btn btn-secondary">&larr; Kembali</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
</div>
@endsection