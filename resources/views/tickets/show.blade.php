@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🎫 Ticket Details #{{ $ticket->id }}</h2>
        <div>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">← Back to Tickets</a>
            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>

    <div class="row">
        <!-- Ticket Info -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ticket Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Ticket ID:</strong></td>
                            <td>{{ $ticket->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Movie:</strong></td>
                            <td><strong>{{ $ticket->movie->title ?? 'N/A' }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Cinema:</strong></td>
                            <td>{{ $ticket->cinema->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Studio:</strong></td>
                            <td>{{ $ticket->studio->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>City:</strong></td>
                            <td>{{ $ticket->city->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Date:</strong></td>
                            <td>
                                <span class="badge bg-{{ $ticket->date >= today() ? 'success' : 'secondary' }} fs-6">
                                    {{ $ticket->date ?? 'N/A' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Time:</strong></td>
                            <td>{{ $ticket->time ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Price:</strong></td>
                            <td><strong>Rp {{ number_format($ticket->price ?? 0, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Seats Summary -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Seats Summary</h5>
                </div>
                <div class="card-body">
                    @php
                        $seats = $ticket->seats;
                        $totalSeats = $seats->count();
                        $availableSeats = $seats->where('status', 'available')->count();
                        $bookedSeats = $seats->where('status', 'booked')->count();
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

                    <div class="mt-3">
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" 
                                 style="width: {{ $totalSeats > 0 ? ($bookedSeats / $totalSeats) * 100 : 0 }}%">
                                {{ $totalSeats > 0 ? round(($bookedSeats / $totalSeats) * 100) : 0 }}% Booked
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <a href="{{ route('seats.by-ticket', $ticket->id) }}" class="btn btn-primary">
                            🪑 View Seat Map
                        </a>
                        <a href="{{ route('seats.index', ['ticket_id' => $ticket->id]) }}" class="btn btn-info">
                            📋 View Seats List
                        </a>
                        @if($ticket->movie)
                            <a href="{{ route('movies.show', $ticket->movie->id) }}" class="btn btn-secondary">
                                🎬 View Movie Details
                            </a>
                        @endif
                        @if($ticket->cinema)
                            <a href="{{ route('cinemas.show', $ticket->cinema->id) }}" class="btn btn-secondary">
                                🏢 View Cinema Details
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    @if($ticket->seats->where('status', 'booked')->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Orders</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Seat</th>
                                        <th>Customer</th>
                                        <th>Payment</th>
                                        <th>Booked At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ticket->seats->where('status', 'booked')->take(10) as $seat)
                                        @if($seat->order)
                                            <tr>
                                                <td><span class="badge bg-secondary">{{ $seat->number }}</span></td>
                                                <td>
                                                    <strong>{{ $seat->order->user->name ?? 'N/A' }}</strong><br>
                                                    <small class="text-muted">{{ $seat->order->user->email ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $seat->order->payment === 'paid' ? 'success' : ($seat->order->payment === 'pending' ? 'warning' : 'secondary') }}">
                                                        {{ ucfirst($seat->order->payment) }}
                                                    </span>
                                                </td>
                                                <td>{{ $seat->order->created_at->format('d M Y H:i') }}</td>
                                                <td>
                                                    <a href="{{ route('orders.show', $seat->order->id) }}" class="btn btn-sm btn-info">View</a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
