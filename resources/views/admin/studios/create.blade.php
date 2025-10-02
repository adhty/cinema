@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Studio</h2>
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
        <div class="mb-3">
            <label>Cinema</label>
            <select name="cinema_id" class="form-control @error('cinema_id') is-invalid @enderror" required>
                <option value="">-- Select Cinema --</option>
                @foreach($cinemas as $cinema)
                <option value="{{ $cinema->id }}" {{ old('cinema_id') == $cinema->id ? 'selected' : '' }}>{{ $cinema->name }}</option>
                @endforeach
            </select>
            @error('cinema_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Studio Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
       
        <div class="mb-3">
            <label>Weekday Price (Rp)</label>
            <input type="number" name="weekday_price" class="form-control @error('weekday_price') is-invalid @enderror" min="0" step="1" value="{{ old('weekday_price', 0) }}" required>
            @error('weekday_price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Friday Price (Rp)</label>
            <input type="number" name="friday_price" class="form-control @error('friday_price') is-invalid @enderror" min="0" step="1" value="{{ old('friday_price', 0) }}" required>
            @error('friday_price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Weekend Price (Rp)</label>
            <input type="number" name="weekend_price" class="form-control @error('weekend_price') is-invalid @enderror" min="0" step="1" value="{{ old('weekend_price', 0) }}" required>
            @error('weekend_price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection