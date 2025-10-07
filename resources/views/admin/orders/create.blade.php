@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Booking Kursi untuk {{ $movie->title }}</h2>

    {{-- Error handling --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        {{-- Seat map --}}
        <div class="seat-map d-grid gap-2 mb-4" style="grid-template-columns: repeat(10, 1fr); max-width:600px;">
            @foreach($seats as $seat)
                <label class="seat {{ $seat->status === 'booked' ? 'booked' : 'available' }}">
                    <input 
                        type="checkbox" 
                        name="seats[]" 
                        value="{{ $seat->id }}" 
                        {{ $seat->status === 'booked' ? 'disabled' : '' }}
                    >
                    {{ $seat->number }}
                </label>
            @endforeach
        </div>

        {{-- Legend --}}
        <div class="mb-4">
            <span class="badge bg-success">Available</span>
            <span class="badge bg-danger">Booked</span>
            <span class="badge bg-primary">Selected</span>
        </div>

        <button type="submit" class="btn btn-success">Booking</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('styles')
<style>
    .seat {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        padding: 10px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
        user-select: none;
        transition: 0.2s;
        text-align: center;
    }
    .seat input {
        display: none;
    }
    .seat.available {
        background-color: #28a745; /* hijau */
        color: white;
    }
    .seat.booked {
        background-color: #dc3545; /* merah */
        color: white;
        cursor: not-allowed;
        opacity: 0.7;
    }
    .seat input:checked + span,
    .seat input:checked ~ * {
        background-color: #0d6efd !important; /* biru */
        color: white;
    }
</style>
@endpush
