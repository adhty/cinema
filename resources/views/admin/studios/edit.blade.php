@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-pencil-square me-2"></i> Edit Studio
        </h4>
        <a href="{{ route('admin.studios.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.studios.update', $studio->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Cinema --}}
                <div class="mb-3">
                    <label for="cinema_id" class="form-label fw-semibold">Pilih Cinema</label>
                    <select name="cinema_id" id="cinema_id" 
                            class="form-select @error('cinema_id') is-invalid @enderror" required>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}" 
                                {{ $studio->cinema_id == $cinema->id ? 'selected' : '' }}>
                                {{ $cinema->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cinema_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Studio --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Studio</label>
                    <input type="text" id="name" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $studio->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Harga Weekday (Rp)</label>
                        <input type="number" name="weekday_price" min="0" step="1"
                            class="form-control @error('weekday_price') is-invalid @enderror"
                            value="{{ old('weekday_price', $studio->cinemaPrice->weekday_price ?? 0) }}" required>
                        @error('weekday_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Harga Jumat (Rp)</label>
                        <input type="number" name="friday_price" min="0" step="1"
                            class="form-control @error('friday_price') is-invalid @enderror"
                            value="{{ old('friday_price', $studio->cinemaPrice->friday_price ?? 0) }}" required>
                        @error('friday_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Harga Weekend (Rp)</label>
                        <input type="number" name="weekend_price" min="0" step="1"
                            class="form-control @error('weekend_price') is-invalid @enderror"
                            value="{{ old('weekend_price', $studio->cinemaPrice->weekend_price ?? 0) }}" required>
                        @error('weekend_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Update Studio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
