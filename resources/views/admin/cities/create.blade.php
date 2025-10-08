@extends('layouts.admin')

@section('title', 'Tambah City')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Tambah Kota</h2>
        <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
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
            <form action="{{ route('admin.cities.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kota</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama kota" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
