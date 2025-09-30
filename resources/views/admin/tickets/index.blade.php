@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tickets Management</h1>
        <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary">
            + Add New Ticket
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Tickets</h5>
                    <h3 class="card-text">{{ $tickets->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Today's Shows</h5>
                    <h3 class="card-text">{{ $tickets->where('date', today()->format('Y-m-d'))->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">This Week</h5>
                    <h3 class="card-text">{{ $tickets->whereBetween('date', [today(), today()->addWeek()])->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Upcoming</h5>
                    <h3 class="card-text">{{ $tickets->where('date', '>', today()->format('Y-m-d'))->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Tickets List</h5>
        </div>
        <div class="card-body">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
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
                                    <td><strong>{{ $ticket->id }}</strong></td>
                                    <td>{{ $ticket->movie->title ?? 'N/A' }}</td>
                                    <td>{{ $ticket->cinema->name ?? 'N/A' }}</td>
                                    <td>{{ $ticket->studio->name ?? 'N/A' }}</td>
                                    <td>{{ $ticket->city->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $ticket->date >= today() ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $ticket->date ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->time ?? 'N/A' }}</td>
                                    <td><strong>Rp {{ number_format($ticket->price ?? 0, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-info">View</a>                                        <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('admin.tickets.destroy', $ticket->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this ticket?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $tickets->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted mb-3">No tickets found.</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-primary">Create First Ticket</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
