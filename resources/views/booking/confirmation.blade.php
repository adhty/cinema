@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class="fas fa-check-circle fa-5x text-success"></i>
                </div>
                <h2> Booking Confirmed!</h2>
                <p class="lead">Your seat has been reserved. Please complete payment to secure your ticket.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Booking Details -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">🎫 Booking Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Movie Information</h6>
                            <p class="mb-1"><strong>🎬 Movie:</strong> {{ $order->seat->ticket->movie->title ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>🏢 Cinema:</strong> {{ $order->seat->ticket->cinema->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>🎭 Studio:</strong> {{ $order->seat->ticket->studio->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($order->seat->ticket->date)->format('d M Y') }}</p>
                            <p class="mb-1"><strong>🕐 Time:</strong> {{ $order->seat->ticket->time }}</p>
                            <p class="mb-3"><strong>🪑 Seat:</strong> <span class="badge bg-primary fs-6">{{ $order->seat->number }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <p class="mb-1"><strong>👤 Name:</strong> {{ $order->user->name }}</p>
                            <p class="mb-1"><strong>📧 Email:</strong> {{ $order->user->email }}</p>
                            <p class="mb-1"><strong>📱 Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                            @if($order->user->gender)
                                <p class="mb-1"><strong>👫 Gender:</strong> {{ ucfirst($order->user->gender) }}</p>
                            @endif
                            @if($order->user->birthdate)
                                <p class="mb-1"><strong>🎂 Birth Date:</strong> {{ $order->user->birthdate->format('d M Y') }}</p>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>📋 Order ID:</strong> #{{ $order->id }}</p>
                            <p class="mb-1"><strong>📅 Booking Date:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h4 class="text-success mb-1">💰 Total: Rp {{ number_format($order->seat->ticket->price, 0, ',', '.') }}</h4>
                            <span class="badge bg-{{ $order->payment === 'paid' ? 'success' : ($order->payment === 'pending' ? 'warning' : 'secondary') }} fs-6">
                                {{ ucfirst($order->payment) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Section -->
            @if($order->payment === 'pending')
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">💳 Payment Required</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Payment Pending:</strong> Please complete your payment to secure your ticket. 
                            Your seat reservation will expire in 15 minutes if payment is not completed.
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Payment Instructions:</h6>
                                <ol>
                                    <li>Click "Pay Now" button below</li>
                                    <li>Complete payment via your preferred method</li>
                                    <li>Your ticket will be generated automatically</li>
                                    <li>Show your digital ticket at the cinema</li>
                                </ol>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>Payment Amount</h6>
                                        <h3 class="text-primary">Rp {{ number_format($order->seat->ticket->price, 0, ',', '.') }}</h3>
                                        <small class="text-muted">Including all taxes</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <form method="POST" action="{{ route('booking.simulate-payment', $order->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg me-3">
                                    💳 Pay Now
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('booking.cancel', $order->id) }}" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-danger" 
                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    ❌ Cancel Booking
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif($order->payment === 'paid')
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">✅ Payment Completed</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-check-circle fa-3x text-success"></i>
                        </div>
                        <h4>Payment Successful!</h4>
                        <p class="mb-3">Your ticket is ready. Please show this at the cinema entrance.</p>
                        
                        <a href="{{ route('booking.ticket', $order->id) }}" class="btn btn-primary btn-lg">
                            🎫 View Digital Ticket
                        </a>
                    </div>
                </div>
            @else
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">❌ Booking Cancelled</h5>
                    </div>
                    <div class="card-body text-center">
                        <p>This booking has been cancelled. The seat is now available for other customers.</p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="text-center">
                <a href="{{ route('booking.index') }}" class="btn btn-outline-primary">
                    🎬 Book Another Movie
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge {
    font-size: 0.9em;
}

.alert {
    border-radius: 10px;
}

.btn-lg {
    padding: 12px 30px;
    font-size: 1.1em;
}
</style>
@endsection
