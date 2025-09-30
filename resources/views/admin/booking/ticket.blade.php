@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <h2>🎫 Digital Ticket</h2>
                <p class="lead">Show this ticket at the cinema entrance</p>
            </div>

            <!-- Digital Ticket -->
            <div class="ticket-container">
                <div class="ticket">
                    <!-- Ticket Header -->
                    <div class="ticket-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="mb-0">🎬 CINEMA TICKET</h4>
                                <small class="text-muted">Digital Ticket</small>
                            </div>
                            <div class="col-4 text-end">
                                <div class="qr-code">
                                    <div class="qr-placeholder">
                                        <i class="fas fa-qrcode fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Movie Info -->
                    <div class="ticket-section">
                        <h5 class="section-title">🎬 MOVIE</h5>
                        <h3 class="movie-title">{{ $order->seat->ticket->movie->title ?? 'N/A' }}</h3>
                    </div>

                    <!-- Show Details -->
                    <div class="ticket-section">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="detail-label">📅 DATE</h6>
                                <p class="detail-value">{{ \Carbon\Carbon::parse($order->seat->ticket->date)->format('d M Y') }}</p>
                            </div>
                            <div class="col-6">
                                <h6 class="detail-label">🕐 TIME</h6>
                                <p class="detail-value">{{ $order->seat->ticket->time }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Venue Details -->
                    <div class="ticket-section">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="detail-label">🏢 CINEMA</h6>
                                <p class="detail-value">{{ $order->seat->ticket->cinema->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-6">
                                <h6 class="detail-label">🎭 STUDIO</h6>
                                <p class="detail-value">{{ $order->seat->ticket->studio->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Seat & Price -->
                    <div class="ticket-section">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="detail-label">🪑 SEAT</h6>
                                <p class="detail-value seat-number">{{ $order->seat->number }}</p>
                            </div>
                            <div class="col-6">
                                <h6 class="detail-label">💰 PRICE</h6>
                                <p class="detail-value">Rp {{ number_format($order->seat->ticket->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="ticket-section">
                        <h6 class="detail-label">👤 CUSTOMER</h6>
                        <p class="detail-value">{{ $order->user->name }}</p>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </div>

                    <!-- Ticket Footer -->
                    <div class="ticket-footer">
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">Order ID: #{{ $order->id }}</small>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <small class="text-muted">Please arrive 15 minutes before showtime</small>
                        </div>
                    </div>

                    <!-- Perforated Edge -->
                    <div class="perforation"></div>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center mt-4">
                <button class="btn btn-primary me-2" onclick="window.print()">
                    🖨️ Print Ticket
                </button>
                <button class="btn btn-success me-2" onclick="downloadTicket()">
                    📱 Save to Phone
                </button>
                <a href="{{ route('booking.index') }}" class="btn btn-outline-secondary">
                    🎬 Book Another Movie
                </a>
            </div>

            <!-- Instructions -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6>📋 Instructions:</h6>
                    <ul class="mb-0">
                        <li>Show this digital ticket at the cinema entrance</li>
                        <li>Arrive at least 15 minutes before showtime</li>
                        <li>Bring a valid ID for verification</li>
                        <li>No outside food or drinks allowed</li>
                        <li>Keep this ticket until the end of the show</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function downloadTicket() {
    // Create a canvas to generate ticket image
    html2canvas(document.querySelector('.ticket')).then(canvas => {
        const link = document.createElement('a');
        link.download = 'movie-ticket-{{ $order->id }}.png';
        link.href = canvas.toDataURL();
        link.click();
    });
}

// Add html2canvas library
const script = document.createElement('script');
script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
document.head.appendChild(script);
</script>

<style>
.ticket-container {
    perspective: 1000px;
}

.ticket {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 0;
    color: white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    position: relative;
    overflow: hidden;
    transform-style: preserve-3d;
}

.ticket::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
    pointer-events: none;
}

.ticket-header {
    background: rgba(255,255,255,0.1);
    padding: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.ticket-section {
    padding: 15px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.ticket-footer {
    padding: 15px 20px;
    background: rgba(0,0,0,0.2);
}

.section-title {
    color: rgba(255,255,255,0.8);
    font-size: 0.9em;
    margin-bottom: 5px;
    letter-spacing: 1px;
}

.movie-title {
    font-size: 1.5em;
    font-weight: bold;
    margin-bottom: 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.detail-label {
    color: rgba(255,255,255,0.7);
    font-size: 0.8em;
    margin-bottom: 5px;
    letter-spacing: 0.5px;
}

.detail-value {
    font-weight: bold;
    margin-bottom: 0;
    font-size: 1.1em;
}

.seat-number {
    background: rgba(255,255,255,0.2);
    padding: 5px 10px;
    border-radius: 5px;
    display: inline-block;
    font-size: 1.2em;
}

.qr-code {
    background: white;
    padding: 10px;
    border-radius: 8px;
    color: #333;
}

.qr-placeholder {
    text-align: center;
    color: #666;
}

.perforation {
    height: 20px;
    background: repeating-linear-gradient(
        90deg,
        transparent,
        transparent 5px,
        rgba(255,255,255,0.3) 5px,
        rgba(255,255,255,0.3) 10px
    );
    position: relative;
}

.perforation::before {
    content: '';
    position: absolute;
    top: 50%;
    left: -10px;
    right: -10px;
    height: 2px;
    background: repeating-linear-gradient(
        90deg,
        transparent,
        transparent 8px,
        rgba(255,255,255,0.5) 8px,
        rgba(255,255,255,0.5) 12px
    );
    transform: translateY(-50%);
}

/* Print styles */
@media print {
    body * {
        visibility: hidden;
    }
    .ticket-container, .ticket-container * {
        visibility: visible;
    }
    .ticket-container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .btn, .card {
        display: none !important;
    }
}

/* Mobile responsive */
@media (max-width: 768px) {
    .ticket {
        margin: 0 10px;
    }
    
    .movie-title {
        font-size: 1.2em;
    }
    
    .detail-value {
        font-size: 1em;
    }
}
</style>
@endsection
