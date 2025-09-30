@extends('layouts.app')

@section('title', 'Edit Cinema')

@section('content')
<h2>Edit Cinema</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.cinemas.update', $cinema->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Cover Image (biarkan kosong jika tidak ganti)</label>
        <input type="file" name="cover" class="form-control" accept="image/*">
        @if($cinema->image)
            <small class="d-block mt-2">Current: <img src="{{ asset('storage/'.$cinema->image) }}" width="120"></small>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Cinema</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $cinema->name) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Alamat</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $cinema->address) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Kota</label>
        <select name="city_id" class="form-select">
            <option value="">Pilih Kota</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}"
                    {{ old('city_id', $cinema->city_id) == $city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.cinemas.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
