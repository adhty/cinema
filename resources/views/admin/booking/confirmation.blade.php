@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Header -->
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class="fas fa-check-circle fa-5x text-success"></i>
                </div>
                <h2>Booking Confirmed!</h2>
                <p class="lead">Your seats have been reserved. Please complete payment to secure your tickets.</p>
            </div>

            <!-- Flash Messages -->
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
                        <!-- Movie -->
                        <div class="col-md-6">
                            <h6>Movie Information</h6>
                            <p class="mb-1"><strong>🎬 Movie:</strong> {{ $order->ticket->movie->title ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>🏢 Cinema:</strong> {{ $order->ticket->cinema->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>🎭 Studio:</strong> {{ $order->ticket->studio->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($order->ticket->date)->format('d M Y') }}</p>
                            <p class="mb-1"><strong>🕐 Time:</strong> {{ $order->ticket->time }}</p>

                            <p class="mb-3"><strong>🪑 Seats:</strong>
                                @foreach($order->seats as $seat)
                                    <span class="badge bg-primary fs-6">{{ $seat->number }}</span>
                                @endforeach
                            </p>
                        </div>

                        <!-- Customer -->
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <p class="mb-1"><strong>👤 Name:</strong> {{ $order->user->name }}</p>
                            <p class="mb-1"><strong>📧 Email:</strong> {{ $order->user->email }}</p>
                            <p class="mb-1"><strong>📱 Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <!-- Order Meta -->
                        <div class="col-md-6">
                            <p class="mb-1"><strong>📋 Order ID:</strong> #{{ $order->id }}</p>
                            <p class="mb-1"><strong>📅 Booking Date:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>

                        <!-- Total -->
                        <div class="col-md-6 text-md-end">
                            @php
                                $total = $order->seats->count() * $order->ticket->price;
                            @endphp
                            <h4 class="text-success mb-1">💰 Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
                            <span class="badge bg-{{ $order->payment === 'paid' ? 'success' : ($order->payment === 'pending' ? 'warning' : 'secondary') }} fs-6">
                                {{ ucfirst($order->payment) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Section -->
            @if($order->payment === 'pending')
                @include('booking.partials._payment_pending', ['order' => $order])
            @elseif($order->payment === 'paid')
                @include('booking.partials._payment_success', ['order' => $order])
            @else
                @include('booking.partials._payment_cancelled')
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
@endsection
