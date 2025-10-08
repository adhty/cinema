@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-plus-circle me-2"></i> Tambah Studio
        </h4>
        <a href="{{ route('admin.studios.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Card Form --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.studios.store') }}" method="POST">
                @csrf

                {{-- Cinema --}}
                <div class="mb-3">
                    <label for="cinema_id" class="form-label fw-semibold">Pilih Cinema</label>
                    <select name="cinema_id" id="cinema_id" 
                            class="form-select @error('cinema_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Cinema --</option>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}" {{ old('cinema_id') == $cinema->id ? 'selected' : '' }}>
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
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required placeholder="Contoh: Studio 1 / VIP Hall">
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
                               value="{{ old('weekday_price', 0) }}" required>
                        @error('weekday_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Harga Jumat (Rp)</label>
                        <input type="number" name="friday_price" min="0" step="1"
                               class="form-control @error('friday_price') is-invalid @enderror"
                               value="{{ old('friday_price', 0) }}" required>
                        @error('friday_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Harga Weekend (Rp)</label>
                        <input type="number" name="weekend_price" min="0" step="1"
                               class="form-control @error('weekend_price') is-invalid @enderror"
                               value="{{ old('weekend_price', 0) }}" required>
                        @error('weekend_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i> Simpan Studio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
