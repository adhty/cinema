@extends('layouts.admin')

@section('title', 'Tambah Cinema')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Create Cinema</h2>
        <a href="{{ route('admin.cinemas.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Card Form --}}
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Error --}}
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('admin.cinemas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Cover Image</label>
                    <input type="file" name="cover" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Cinema Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama cinema" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Masukkan alamat" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">City</label>
                    <select name="city_id" class="form-select" required>
                        <option value="">-- Pilih Kota --</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Save
                </button>
                <a href="{{ route('admin.cinemas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-lg"></i> Cancel
                </a>

            </form>

        </div>
    </div>

</div>
@endsection
