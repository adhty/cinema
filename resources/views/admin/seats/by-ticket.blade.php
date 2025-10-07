@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Seats for Ticket #{{ $ticket->id }} - {{ $ticket->movie->title ?? 'N/A' }}</h2>

    <div class="mb-3">
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">← Back to Tickets</a>
    </div>

    <div class="row">
        <!-- Available Seats -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Available Seats ({{ $availableSeats->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($availableSeats->count() > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($availableSeats as $seat)
                                <span class="badge bg-success">{{ $seat->number }}</span>
                            @endforeach
                        </div>
                    @else
                        <p>No available seats.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Booked Seats -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Booked Seats ({{ $bookedSeats->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($bookedSeats->count() > 0)
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Seat</th>
                                    <th>Customer</th>
                                    <th>Payment</th>
                                    <th>Booked At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookedSeats as $seat)
                                    @foreach($seat->orders as $order)
                                        <tr>
                                            <td><span class="badge bg-secondary">{{ $seat->number }}</span></td>
                                            <td>
                                                <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $order->payment === 'paid' ? 'success' : ($order->payment === 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($order->payment) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No booked seats.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
