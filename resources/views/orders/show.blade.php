@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📋 Order Details #{{ $order->id }}</h2>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">← Back to Orders</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Order Info -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Order ID:</strong></td>
                            <td>{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Customer:</strong></td>
                            <td>
                                <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small><br>
                                @if($order->user->phone)
                                    <small class="text-muted">{{ $order->user->phone }}</small>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Seat:</strong></td>
                            <td><span class="badge bg-secondary fs-6">{{ $order->seat->number ?? 'N/A' }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Payment Status:</strong></td>
                            <td>
                                <span class="badge bg-{{ $order->payment === 'paid' ? 'success' : ($order->payment === 'pending' ? 'warning' : 'secondary') }} fs-6">
                                    {{ ucfirst($order->payment) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Movie & Cinema Info -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Show Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Movie:</strong></td>
                            <td>{{ $order->seat->ticket->movie->title ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cinema:</strong></td>
                            <td>{{ $order->seat->ticket->cinema->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Studio:</strong></td>
                            <td>{{ $order->seat->ticket->studio->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Date:</strong></td>
                            <td>{{ $order->seat->ticket->date ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Time:</strong></td>
                            <td>{{ $order->seat->ticket->time ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Price:</strong></td>
                            <td><strong>Rp {{ number_format($order->seat->ticket->price ?? 0, 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>
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
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Payment Status</h6>
                            <form method="POST" action="{{ route('orders.update-payment', $order->id) }}" class="d-inline">
                                @csrf
                                @method('PUT')
                                <div class="input-group">
                                    <select name="payment" class="form-select">
                                        <option value="pending" {{ $order->payment === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ $order->payment === 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="cancelled" {{ $order->payment === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h6>Other Actions</h6>
                            <div class="btn-group" role="group">
                                <a href="{{ route('seats.show', $order->seat->id) }}" class="btn btn-info">View Seat</a>
                                @if($order->seat->ticket)
                                    <a href="{{ route('seats.by-ticket', $order->seat->ticket->id) }}" class="btn btn-secondary">View All Seats</a>
                                @endif
                                @if($order->payment !== 'paid')
                                    <form method="POST" action="{{ route('orders.cancel', $order->id) }}" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning"
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                            Cancel Order
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
