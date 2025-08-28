@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🎬 Seats for {{ $ticket->movie->title ?? 'Movie' }}</h2>
        <a href="{{ route('seats.index') }}" class="btn btn-secondary">← Back to All Seats</a>
    </div>

    <!-- Ticket Info -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Show Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Movie:</strong> {{ $ticket->movie->title ?? 'N/A' }}</p>
                    <p><strong>Cinema:</strong> {{ $ticket->cinema->name ?? 'N/A' }}</p>
                    <p><strong>Studio:</strong> {{ $ticket->studio->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Date:</strong> {{ $ticket->date ?? 'N/A' }}</p>
                    <p><strong>Time:</strong> {{ $ticket->time ?? 'N/A' }}</p>
                    <p><strong>Price:</strong> Rp {{ number_format($ticket->price ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Seats</h5>
                    <h3>{{ $seats->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h5>Available</h5>
                    <h3>{{ $availableSeats->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h5>Booked</h5>
                    <h3>{{ $bookedSeats->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Seat Map -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Seat Map</h5>
        </div>
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="bg-dark text-white p-2 rounded" style="display: inline-block;">
                    🎬 SCREEN
                </div>
            </div>

            <div class="seat-map">
                @php
                    $seatsByRow = $seats->groupBy(function($seat) {
                        return substr($seat->number, 0, 1); // Group by first letter (A, B, C, etc.)
                    });
                @endphp

                @foreach($seatsByRow as $row => $rowSeats)
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <strong>{{ $row }}</strong>
                        </div>
                        <div class="col-11">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($rowSeats->sortBy('number') as $seat)
                                    <div class="seat-item" data-seat-id="{{ $seat->id }}">
                                        @if($seat->status === 'available')
                                            <button class="btn btn-outline-success btn-sm seat-btn" 
                                                    title="Available - {{ $seat->number }}"
                                                    onclick="showSeatDetails({{ $seat->id }})">
                                                {{ $seat->number }}
                                            </button>
                                        @else
                                            <button class="btn btn-danger btn-sm seat-btn" 
                                                    title="Booked by {{ $seat->order->user->name ?? 'Unknown' }} - {{ $seat->number }}"
                                                    onclick="showSeatDetails({{ $seat->id }})">
                                                {{ $seat->number }}
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Legend -->
            <div class="mt-4">
                <h6>Legend:</h6>
                <div class="d-flex gap-3">
                    <div><button class="btn btn-outline-success btn-sm" disabled>Available</button></div>
                    <div><button class="btn btn-danger btn-sm" disabled>Booked</button></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed List -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Detailed Seat List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Seat</th>
                            <th>Status</th>
                            <th>Customer</th>
                            <th>Payment</th>
                            <th>Booked At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seats->sortBy('number') as $seat)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $seat->number }}</span></td>
                                <td>
                                    @if($seat->status === 'available')
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Booked</span>
                                    @endif
                                </td>
                                <td>
                                    @if($seat->order)
                                        <strong>{{ $seat->order->user->name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $seat->order->user->email ?? 'N/A' }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($seat->order)
                                        <span class="badge bg-{{ $seat->order->payment === 'paid' ? 'success' : ($seat->order->payment === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($seat->order->payment) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($seat->order)
                                        {{ $seat->order->created_at->format('d M Y H:i') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('seats.show', $seat->id) }}" class="btn btn-sm btn-info">View</a>
                                    @if($seat->order)
                                        <a href="{{ route('orders.show', $seat->order->id) }}" class="btn btn-sm btn-primary">Order</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function showSeatDetails(seatId) {
    window.location.href = `/seats/${seatId}`;
}
</script>

<style>
.seat-map {
    max-width: 800px;
    margin: 0 auto;
}

.seat-btn {
    width: 50px;
    height: 40px;
    font-size: 12px;
    font-weight: bold;
}

.seat-btn:disabled {
    opacity: 0.6;
}
</style>
@endsection
