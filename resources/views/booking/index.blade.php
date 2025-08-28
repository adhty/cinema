@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <h1 class="display-4"> Book Your Movie Tickets</h1>
        <p class="lead">Choose your movie and showtime</p>
    </div>

    @if($tickets->count() > 0)
        @foreach($tickets as $movieTitle => $movieTickets)
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">🎬 {{ $movieTitle }}</h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @foreach($movieTickets as $ticket)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-primary h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            🏢 {{ $ticket->cinema->name ?? 'N/A' }}
                                        </h6>
                                        <div class="mb-3">
                                            <small class="text-muted">🎭 {{ $ticket->studio->name ?? 'N/A' }}</small><br>
                                            <small class="text-muted">🏙️ {{ $ticket->city->name ?? 'N/A' }}</small>
                                        </div>

                                        <div class="mb-3">
                                            <span class="badge bg-primary me-2">
                                                📅 {{ \Carbon\Carbon::parse($ticket->date)->format('d M Y') }}
                                            </span>
                                            <span class="badge bg-success">
                                                🕐 {{ $ticket->time }}
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <h5 class="text-primary">
                                                💰 Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                            </h5>
                                        </div>

                                        @php
                                            $availableSeats = $ticket->seats ? $ticket->seats->where('status', 'available')->count() : 0;
                                            $totalSeats = $ticket->seats ? $ticket->seats->count() : 0;
                                        @endphp

                                        <div class="mb-3">
                                            <small class="text-muted">
                                                🪑 {{ $availableSeats }}/{{ $totalSeats }} seats available
                                            </small>
                                            @if($totalSeats > 0)
                                                <div class="progress mt-2" style="height: 8px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                         style="width: {{ ($availableSeats / $totalSeats) * 100 }}%">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        @if($totalSeats > 0 && $availableSeats > 0)
                                            <a href="{{ route('booking.select-seat', $ticket->id) }}"
                                               class="btn btn-primary w-100">
                                                🎫 Select Seats
                                            </a>
                                        @elseif($totalSeats > 0)
                                            <button class="btn btn-secondary w-100" disabled>
                                                😞 Sold Out
                                            </button>
                                        @else
                                            <button class="btn btn-warning w-100" disabled>
                                                ⚠️ No Seats Available
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
                <i class="fas fa-film fa-4x text-muted"></i>
            </div>
            <h3 class="h4 mb-2">No Movies Available</h3>
            <p class="text-muted">Please check back later for upcoming shows.</p>
        </div>
    @endif
</div>
@endsection
