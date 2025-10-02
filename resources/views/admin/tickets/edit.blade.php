@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🎫 Edit Ticket #{{ $ticket->id }}</h2>
        <div>
            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-secondary">← Back to Ticket</a>
            <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary">All Tickets</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Ticket Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="movie_id" class="form-label">Movie <span class="text-danger">*</span></label>
                                    <select name="movie_id" id="movie_id" class="form-select @error('movie_id') is-invalid @enderror" required>
                                        <option value="">Select Movie</option>
                                        @foreach($movies as $movie)
                                            <option value="{{ $movie->id }}" {{ (old('movie_id') ?? $ticket->movie_id) == $movie->id ? 'selected' : '' }}>
                                                {{ $movie->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('movie_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cinema_id" class="form-label">Cinema <span class="text-danger">*</span></label>
                                    <select name="cinema_id" id="cinema_id" class="form-select @error('cinema_id') is-invalid @enderror" required>
                                        <option value="">Select Cinema</option>
                                        @foreach($cinemas as $cinema)
                                            <option value="{{ $cinema->id }}" {{ (old('cinema_id') ?? $ticket->cinema_id) == $cinema->id ? 'selected' : '' }}>
                                                {{ $cinema->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cinema_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="studio_id" class="form-label">Studio <span class="text-danger">*</span></label>
                                    <select name="studio_id" id="studio_id" class="form-select @error('studio_id') is-invalid @enderror" required>
                                        <option value="">Select Studio</option>
                                        @foreach($studios as $studio)
                                            <option value="{{ $studio->id }}" {{ (old('studio_id') ?? $ticket->studio_id) == $studio->id ? 'selected' : '' }}>
                                                {{ $studio->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('studio_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city_id" class="form-label">City <span class="text-danger">*</span></label>
                                    <select name="city_id" id="city_id" class="form-select @error('city_id') is-invalid @enderror" required>
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ (old('city_id') ?? $ticket->city_id) == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" id="date" 
                                           class="form-control @error('date') is-invalid @enderror" 
                                           value="{{ old('date') ?? $ticket->date }}" 
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="time" class="form-label">Time <span class="text-danger">*</span></label>
                                    <input type="time" name="time" id="time" 
                                           class="form-control @error('time') is-invalid @enderror" 
                                           value="{{ old('time') ?? $ticket->time }}" required>
                                    @error('time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price') ?? $ticket->price }}" 
                                           min="0" step="1000" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Warning for existing bookings -->
                        @if($ticket->seats->where('status', 'booked')->count() > 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Warning:</strong> This ticket has {{ $ticket->seats->where('status', 'booked')->count() }} booked seats. 
                                Changing the date/time may affect existing bookings.
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Seats Summary -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Current Seats Status</h5>
                </div>
                <div class="card-body">
                    @php
                        $totalSeats = $ticket->seats->count();
                        $bookedSeats = $ticket->seats->where('status', 'booked')->count();
                        $availableSeats = $ticket->seats->where('status', 'available')->count();
                    @endphp

                    <div class="row text-center">
                        <div class="col-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h4>{{ $totalSeats }}</h4>
                                    <small>Total Seats</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h4>{{ $availableSeats }}</h4>
                                    <small>Available</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h4>{{ $bookedSeats }}</h4>
                                    <small>Booked</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($bookedSeats > 0)
                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
