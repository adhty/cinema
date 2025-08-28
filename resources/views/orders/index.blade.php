@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📋 Orders Management</h2>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('orders.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="user_id" class="form-label">Filter by User</label>
                    <select name="user_id" id="user_id" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="payment" class="form-label">Filter by Payment</label>
                    <select name="payment" id="payment" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('payment') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="cancelled" {{ request('payment') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Total Orders</h5>
                    <h3>{{ $orders->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>Pending</h5>
                    <h3>{{ $orders->where('payment', 'pending')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Paid</h5>
                    <h3>{{ $orders->where('payment', 'paid')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h5>Cancelled</h5>
                    <h3>{{ $orders->where('payment', 'cancelled')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Orders List</h5>
        </div>
        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Movie</th>
                                <th>Cinema</th>
                                <th>Seat</th>
                                <th>Date & Time</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $order->seat->ticket->movie->title ?? 'N/A' }}</td>
                                    <td>{{ $order->seat->ticket->cinema->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $order->seat->number ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        {{ $order->seat->ticket->date ?? 'N/A' }}<br>
                                        <small class="text-muted">{{ $order->seat->ticket->time ?? 'N/A' }}</small>
                                    </td>
                                    <td>Rp {{ number_format($order->seat->ticket->price ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->payment === 'paid' ? 'success' : ($order->payment === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($order->payment) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">View</a>
                                        @if($order->payment === 'pending')
                                            <form method="POST" action="{{ route('orders.cancel', $order->id) }}" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-warning"
                                                        onclick="return confirm('Are you sure you want to cancel this order?')">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted">No orders found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
