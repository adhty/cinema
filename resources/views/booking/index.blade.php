@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1>🎬 Book Your Movie Tickets</h1>
        <p class="lead">Choose your movie and showtime</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($tickets->count() > 0)
        @foreach($tickets as $movieTitle => $movieTickets)
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">🎬 {{ $movieTitle }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($movieTickets as $ticket)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 border-primary">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            🏢 {{ $ticket->cinema->name ?? 'N/A' }}
                                        </h6>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                🎭 {{ $ticket->studio->name ?? 'N/A' }}<br>
                                                🏙️ {{ $ticket->city->name ?? 'N/A' }}
                                            </small>
                                        </p>
                                        
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-primary fs-6">
                                                    📅 {{ \Carbon\Carbon::parse($ticket->date)->format('d M Y') }}
                                                </span>
                                                <span class="badge bg-success fs-6">
                                                    🕐 {{ $ticket->time }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <h5 class="text-primary">
                                                💰 Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                            </h5>
                                        </div>

                                        @php
                                            $availableSeats = $ticket->seats->where('status', 'available')->count();
                                            $totalSeats = $ticket->seats->count();
                                        @endphp

                                        <div class="mb-3">
                                            <small class="text-muted">
                                                🪑 {{ $availableSeats }}/{{ $totalSeats }} seats available
                                            </small>
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar bg-success" 
                                                     style="width: {{ $totalSeats > 0 ? ($availableSeats / $totalSeats) * 100 : 0 }}%">
                                                </div>
                                            </div>
                                        </div>

                                        @if($availableSeats > 0)
                                            <a href="{{ route('booking.select-seat', $ticket->id) }}" 
                                               class="btn btn-primary w-100">
                                                🎫 Select Seats
                                            </a>
                                        @else
                                            <button class="btn btn-secondary w-100" disabled>
                                                😞 Sold Out
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-film fa-5x text-muted"></i>
            </div>
            <h3 class="text-muted">No Movies Available</h3>
            <p class="text-muted">Please check back later for upcoming shows.</p>
        </div>
    @endif
</div>

<style>
.card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.progress {
    border-radius: 10px;
}

.badge {
    font-size: 0.8em !important;
}
</style>
@endsection
