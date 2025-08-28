@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🪑 Seat Details</h2>
        <a href="{{ route('seats.index') }}" class="btn btn-secondary">← Back to Seats</a>
    </div>

    <div class="row">
        <!-- Seat Info -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Seat Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Seat ID:</strong></td>
                            <td>{{ $seat->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Seat Number:</strong></td>
                            <td><span class="badge bg-secondary fs-6">{{ $seat->number }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($seat->status === 'available')
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Booked</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $seat->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ticket Info -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ticket Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Movie:</strong></td>
                            <td>{{ $seat->ticket->movie->title ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cinema:</strong></td>
                            <td>{{ $seat->ticket->cinema->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Studio:</strong></td>
                            <td>{{ $seat->ticket->studio->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Date:</strong></td>
                            <td>{{ $seat->ticket->date ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Time:</strong></td>
                            <td>{{ $seat->ticket->time ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Price:</strong></td>
                            <td>Rp {{ number_format($seat->ticket->price ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Info (if booked) -->
    @if($seat->order)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Order ID:</strong></td>
                                        <td>{{ $seat->order->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Customer Name:</strong></td>
                                        <td>{{ $seat->order->user->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $seat->order->user->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td>{{ $seat->order->user->phone ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Payment Status:</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $seat->order->payment === 'paid' ? 'success' : ($seat->order->payment === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($seat->order->payment) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Booked At:</strong></td>
                                        <td>{{ $seat->order->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Actions:</strong></td>
                                        <td>
                                            <a href="{{ route('orders.show', $seat->order->id) }}" class="btn btn-sm btn-primary">View Order</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('seats.by-ticket', $seat->ticket->id) }}" class="btn btn-info">
                        View All Seats for This Show
                    </a>
                    @if($seat->ticket)
                        <a href="{{ route('tickets.show', $seat->ticket->id) }}" class="btn btn-secondary">
                            View Ticket Details
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
