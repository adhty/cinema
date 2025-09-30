@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Studio</h2>
    <form action="{{ route('studios.update',$studio->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Cinema</label>
            <select name="cinema_id" class="form-control" required>
                @foreach($cinemas as $cinema)
                <option value="{{ $cinema->id }}" {{ $studio->cinema_id == $cinema->id ? 'selected' : '' }}>
                    {{ $cinema->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Studio Name</label>
            <input type="text" name="name" class="form-control" value="{{ $studio->name }}" required>
        </div>
       
        <div class="mb-3">
            <label>Weekday Price (Rp)</label>
            <input type="number" name="weekday_price" class="form-control @error('weekday_price') is-invalid @enderror" min="0" step="1" value="{{ $studio->cinemaPrice->weekday_price ?? 0 }}" required>
            @error('weekday_price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Friday Price (Rp)</label>
            <input type="number" name="friday_price" class="form-control @error('friday_price') is-invalid @enderror" min="0" step="1" value="{{ $studio->cinemaPrice->friday_price ?? 0 }}" required>
            @error('friday_price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label>Weekend Price (Rp)</label>
            <input type="number" name="weekend_price" class="form-control @error('weekend_price') is-invalid @enderror" min="0" step="1" value="{{ $studio->cinemaPrice->weekend_price ?? 0 }}" required>
            @error('weekend_price')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection