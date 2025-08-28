<!-- resources/views/cinemas/create.blade.php -->

@extends('layouts.app')

@section('content')
<h1>Tambah Cinema</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('cinemas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group mb-3">
        <label for="cover">Cover Image</label>
        <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Nama Cinema</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
    </div>

    <div class="mb-3">
        <label for="city_id" class="form-label">Kota</label>
        <select name="city_id" id="city_id" class="form-select">
            <option value="">Pilih Kota</option>
            @foreach ($cities as $city)
            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                {{ $city->name }}
            </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection
