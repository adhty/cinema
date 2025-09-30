@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="text-center mb-4">
                <h2>Customer Information</h2>
                <p class="lead">Please fill in your details to complete the booking</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Booking Summary -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🎫 Booking Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>🎬 Movie:</strong> {{ $ticket->movie->title ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>🏢 Cinema:</strong> {{ $ticket->cinema->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>🎭 Studio:</strong> {{ $ticket->studio->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($ticket->date)->format('d M Y') }}</p>
                            <p class="mb-1"><strong>🕐 Time:</strong> {{ $ticket->time }}</p>
                            <p class="mb-1"><strong>🪑 Seats:</strong> 
                                @foreach($seats as $seat)
                                    <span class="badge bg-primary">{{ $seat->number }}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        @php
                            $total = count($seats) * $ticket->price;
                        @endphp
                        <h4 class="text-primary mb-0">💰 Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>

            <!-- Customer Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Customer Details</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('booking.process') }}">
                        @csrf

                        <!-- hidden input for seats -->
                        @foreach($seats as $seat)
                            <input type="hidden" name="seat_ids[]" value="{{ $seat->id }}">
                        @endforeach
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" id="phone" 
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    value="{{ old('phone') }}" required>
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-select">
                                    <option value="">Select</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Birth Date</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ old('birthdate') }}">
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            After confirming, you’ll be redirected to payment page.
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('booking.select-seat', $ticket->id) }}" class="btn btn-secondary">← Back</a>
                            <button type="submit" class="btn btn-success btn-lg">🎫 Confirm Booking</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
