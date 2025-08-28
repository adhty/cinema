@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>🪑 Seats Management</h1>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('seats.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="ticket_id" class="form-label">Filter by Ticket</label>
                    <select name="ticket_id" id="ticket_id" class="form-select">
                        <option value="">All Tickets</option>
                        @foreach($tickets as $ticket)
                            <option value="{{ $ticket->id }}" {{ request('ticket_id') == $ticket->id ? 'selected' : '' }}>
                                {{ $ticket->movie->title ?? 'N/A' }} - {{ $ticket->cinema->name ?? 'N/A' }}
                                ({{ $ticket->date }} {{ $ticket->time }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Filter by Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('seats.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Seats</h5>
                    <h3 class="card-text">{{ $seats->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Available</h5>
                    <h3 class="card-text">{{ $seats->where('status', 'available')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Booked</h5>
                    <h3 class="card-text">{{ $seats->where('status', 'booked')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Seats Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Seats List</h5>
        </div>
        <div class="card-body">
            @if($seats->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Seat Number</th>
                                <th>Movie</th>
                                <th>Cinema</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Booked By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($seats as $seat)
                                <tr>
                                    <td><strong>{{ $seat->id }}</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $seat->number }}</span>
                                    </td>
                                    <td>{{ $seat->ticket->movie->title ?? 'N/A' }}</td>
                                    <td>{{ $seat->ticket->cinema->name ?? 'N/A' }}</td>
                                    <td>
                                        <div>{{ $seat->ticket->date ?? 'N/A' }}</div>
                                        <small class="text-muted">{{ $seat->ticket->time ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        @if($seat->status === 'available')
                                            <span class="badge bg-success">Available</span>
                                        @else
                                            <span class="badge bg-danger">Booked</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($seat->order)
                                            <div><strong>{{ $seat->order->user->name ?? 'N/A' }}</strong></div>
                                            <small class="text-muted">{{ $seat->order->user->email ?? 'N/A' }}</small>
                                            <br>
                                            <span class="badge {{ $seat->order->payment === 'paid' ? 'bg-success' : ($seat->order->payment === 'pending' ? 'bg-warning' : 'bg-secondary') }}">
                                                {{ ucfirst($seat->order->payment) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('seats.show', $seat->id) }}" class="btn btn-sm btn-info">View</a>
                                        @if($seat->ticket)
                                            <a href="{{ route('seats.by-ticket', $seat->ticket->id) }}" class="btn btn-sm btn-secondary">View All</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $seats->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted">No seats found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
