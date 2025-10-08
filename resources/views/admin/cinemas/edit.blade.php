@extends('layouts.admin')

@section('title', 'Edit Cinema')

@section('content')
<h2 class="mb-4">Edit Cinema</h2>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.cinemas.update', $cinema->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Cover Image --}}
    <div class="mb-3">
        <label class="form-label">Cover Image (biarkan kosong jika tidak ganti)</label>
        <input type="file" name="cover" class="form-control" accept="image/*" id="coverInput">
        @if($cinema->image)
            <div class="mt-2">
                <small>Current:</small><br>
                <img src="{{ asset('storage/'.$cinema->image) }}" id="coverPreview" width="150" class="img-thumbnail">
            </div>
        @else
            <img id="coverPreview" width="150" class="img-thumbnail mt-2 d-none">
        @endif
    </div>

    {{-- Nama Cinema --}}
    <div class="mb-3">
        <label class="form-label">Cinema Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $cinema->name) }}" required>
    </div>

    {{-- Alamat --}}
    <div class="mb-3">
        <label class="form-label">Addres</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $cinema->address) }}" required>
    </div>

    {{-- Kota --}}
    <div class="mb-3">
        <label class="form-label">City</label>
        <select name="city_id" class="form-select" required>
            <option value="">Select City/option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}" {{ old('city_id', $cinema->city_id) == $city->id ? 'selected' : '' }}>
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Buttons --}}
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('admin.cinemas.index') }}" class="btn btn-secondary">Batal</a>
</form>

{{-- Preview Image Script --}}
@push('scripts')
<script>
    const coverInput = document.getElementById('coverInput');
    const coverPreview = document.getElementById('coverPreview');

    coverInput.addEventListener('change', function(e) {
        const [file] = coverInput.files;
        if (file) {
            coverPreview.src = URL.createObjectURL(file);
            coverPreview.classList.remove('d-none');
        }
    });
</script>
@endpush

@endsection
