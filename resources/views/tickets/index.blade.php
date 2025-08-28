@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🎫 Tickets Management</h2>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">+ Add New Ticket</a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Total Tickets</h5>
                    <h3>{{ $tickets->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Today's Shows</h5>
                    <h3>{{ $tickets->where('date', today()->format('Y-m-d'))->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>This Week</h5>
                    <h3>{{ $tickets->whereBetween('date', [today(), today()->addWeek()])->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>Upcoming</h5>
                    <h3>{{ $tickets->where('date', '>', today()->format('Y-m-d'))->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tickets List</h5>
        </div>
        <div class="card-body">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Movie</th>
                                <th>Cinema</th>
                                <th>Studio</th>
                                <th>City</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>
                                        <strong>{{ $ticket->movie->title ?? 'N/A' }}</strong>
                                    </td>
                                    <td>{{ $ticket->cinema->name ?? 'N/A' }}</td>
                                    <td>{{ $ticket->studio->name ?? 'N/A' }}</td>
                                    <td>{{ $ticket->city->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->date >= today() ? 'success' : 'secondary' }}">
                                            {{ $ticket->date ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->time ?? 'N/A' }}</td>
                                    <td>
                                        <strong>Rp {{ number_format($ticket->price ?? 0, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('seats.by-ticket', $ticket->id) }}" class="btn btn-sm btn-secondary">Seats</a>
                                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form method="POST" action="{{ route('tickets.destroy', $ticket->id) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this ticket?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $tickets->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted">No tickets found.</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">Create First Ticket</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
