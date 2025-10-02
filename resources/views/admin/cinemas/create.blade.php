@extends('layouts.admin')

@section('title', 'Tambah Cinema')

@section('content')
<h2>Tambah Cinema</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.cinemas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Cover Image</label>
        <input type="file" name="cover" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Cinema</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Alamat</label>
        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Kota</label>
        <select name="city_id" class="form-select">
            <option value="">Pilih Kota</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.cinemas.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
