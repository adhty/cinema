@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <h2>🪑 Select Your Seat</h2>
        <p class="lead">{{ $ticket->movie->title ?? 'Movie' }}</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Movie Info -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>🎬 {{ $ticket->movie->title ?? 'N/A' }}</h5>
                    <p class="mb-1">🏢 {{ $ticket->cinema->name ?? 'N/A' }}</p>
                    <p class="mb-1">🎭 {{ $ticket->studio->name ?? 'N/A' }}</p>
                    <p class="mb-0">🏙️ {{ $ticket->city->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>📅 {{ \Carbon\Carbon::parse($ticket->date)->format('d M Y') }}</h5>
                    <h5>🕐 {{ $ticket->time }}</h5>
                    <h4 class="text-primary">💰 Rp {{ number_format($ticket->price, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Screen -->
    <div class="text-center mb-4">
        <div class="screen">
            🎬 SCREEN
        </div>
    </div>

    <!-- Seat Map -->
    <div class="seat-map-container">
        @foreach($seats as $row => $rowSeats)
            <div class="seat-row mb-3">
                <div class="row align-items-center">
                    <div class="col-1 text-center">
                        <strong class="row-label">{{ $row }}</strong>
                    </div>
                    <div class="col-11">
                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            @foreach($rowSeats->sortBy('number') as $seat)
                                @if($seat->isAvailable())
                                    <button class="seat-btn available" 
                                            onclick="selectSeat({{ $seat->id }}, '{{ $seat->number }}', {{ $ticket->price }})"
                                            data-seat-id="{{ $seat->id }}"
                                            data-seat-number="{{ $seat->number }}">
                                        {{ $seat->number }}
                                    </button>
                                @else
                                    <button class="seat-btn booked" disabled 
                                            title="Booked by {{ $seat->order->user->name ?? 'Unknown' }}">
                                        {{ $seat->number }}
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Legend -->
    <div class="legend mb-4">
        <div class="row justify-content-center">
            <div class="col-auto">
                <button class="seat-btn available" disabled></button>
                <small>Available</small>
            </div>
            <div class="col-auto">
                <button class="seat-btn selected" disabled></button>
                <small>Selected</small>
            </div>
            <div class="col-auto">
                <button class="seat-btn booked" disabled></button>
                <small>Booked</small>
            </div>
        </div>
    </div>

    <!-- Selection Summary -->
    <div class="card" id="selection-summary" style="display: none;">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-1">Selected Seat: <span id="selected-seat-number"></span></h5>
                    <p class="mb-0">Price: <span id="selected-price"></span></p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn btn-success btn-lg" id="proceed-btn" onclick="proceedToBooking()">
                        Proceed to Booking →
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="{{ route('booking.index') }}" class="btn btn-secondary">
            ← Back to Movies
        </a>
    </div>
</div>

<script>
let selectedSeatId = null;
let selectedSeatNumber = null;
let selectedPrice = 0;

function selectSeat(seatId, seatNumber, price) {
    // Remove previous selection
    document.querySelectorAll('.seat-btn.selected').forEach(btn => {
        btn.classList.remove('selected');
        btn.classList.add('available');
    });
    
    // Add selection to clicked seat
    const seatBtn = document.querySelector(`[data-seat-id="${seatId}"]`);
    seatBtn.classList.remove('available');
    seatBtn.classList.add('selected');
    
    // Update selection data
    selectedSeatId = seatId;
    selectedSeatNumber = seatNumber;
    selectedPrice = price;
    
    // Update summary
    document.getElementById('selected-seat-number').textContent = seatNumber;
    document.getElementById('selected-price').textContent = 'Rp ' + price.toLocaleString('id-ID');
    document.getElementById('selection-summary').style.display = 'block';
}

function proceedToBooking() {
    if (selectedSeatId) {
        window.location.href = `{{ url('/booking/customer-form') }}/${selectedSeatId}`;
    }
}
</script>

<style>
.screen {
    background: linear-gradient(to bottom, #333, #666);
    color: white;
    padding: 15px 50px;
    border-radius: 50px;
    display: inline-block;
    font-weight: bold;
    margin-bottom: 30px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

.seat-map-container {
    max-width: 800px;
    margin: 0 auto;
}

.row-label {
    font-size: 1.2em;
    color: #666;
}

.seat-btn {
    width: 45px;
    height: 40px;
    border: 2px solid;
    border-radius: 8px;
    font-size: 12px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s;
}

.seat-btn.available {
    background-color: #e8f5e8;
    border-color: #28a745;
    color: #28a745;
}

.seat-btn.available:hover {
    background-color: #28a745;
    color: white;
    transform: scale(1.1);
}

.seat-btn.selected {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    transform: scale(1.1);
}

.seat-btn.booked {
    background-color: #f8d7da;
    border-color: #dc3545;
    color: #dc3545;
    cursor: not-allowed;
}

.legend {
    text-align: center;
}

.legend .col-auto {
    margin: 0 15px;
}

.legend .seat-btn {
    width: 30px;
    height: 25px;
    margin-right: 5px;
    font-size: 10px;
}

#selection-summary {
    position: sticky;
    bottom: 20px;
    z-index: 1000;
    box-shadow: 0 -4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection
