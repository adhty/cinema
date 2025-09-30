@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📋 Orders Management</h1>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 mb-4">
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
        <div class="col-md-4">
            <label for="payment" class="form-label">Filter by Payment</label>
            <select name="payment" id="payment" class="form-select">
                <option value="">All Status</option>
                <option value="pending" {{ request('payment') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('payment') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ request('payment') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3"><div class="card bg-primary text-white"><div class="card-body"><h5>Total Orders</h5><h3>{{ $stats['total'] }}</h3></div></div></div>
        <div class="col-md-3"><div class="card bg-warning text-white"><div class="card-body"><h5>Pending</h5><h3>{{ $stats['pending'] }}</h3></div></div></div>
        <div class="col-md-3"><div class="card bg-success text-white"><div class="card-body"><h5>Paid</h5><h3>{{ $stats['paid'] }}</h3></div></div></div>
        <div class="col-md-3"><div class="card bg-secondary text-white"><div class="card-body"><h5>Cancelled</h5><h3>{{ $stats['cancelled'] }}</h3></div></div></div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-header">Orders List</div>
        <div class="card-body">
            @if($orders->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Seat</th>
                            <th>Payment</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->seat->number ?? 'N/A' }}</td>
                            <td>{{ ucfirst($order->payment) }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @else
                <p class="text-center">No orders found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
