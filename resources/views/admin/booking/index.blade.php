@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <h1 class="display-4">🎬 Book Your Movie Tickets</h1>
        <p class="lead">Choose your movie and showtime</p>
    </div>

    <!-- Container AJAX -->
    <div id="ticket-list" class="row">
        <div class="text-center py-5">
            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="mt-2">Loading movies...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    loadTickets();
});

function loadTickets() {
    fetch("{{ route('booking.data') }}") // ambil dari route JSON
        .then(res => res.json())
        .then(data => {
            let container = document.getElementById("ticket-list");
            container.innerHTML = "";

            if (Object.keys(data).length === 0) {
                container.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-film fa-4x text-muted"></i>
                        <h3 class="h4 mb-2">No Movies Available</h3>
                        <p class="text-muted">Please check back later for upcoming shows.</p>
                    </div>
                `;
                return;
            }

            for (let movie in data) {
                let tickets = data[movie];
                let html = `
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">🎬 ${movie}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                `;

                tickets.forEach(ticket => {
                    let availableSeats = ticket.seats.filter(s => s.status === "available").length;
                    let totalSeats = ticket.seats.length;

                    html += `
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-primary h-100">
                                <div class="card-body">
                                    <h6 class="card-title">🏢 ${ticket.cinema?.name ?? "N/A"}</h6>
                                    <div class="mb-3">  
                                        <small class="text-muted">🎭 ${ticket.studio?.name ?? "N/A"}</small><br>
                                        <small class="text-muted">🏙️ ${ticket.city?.name ?? "N/A"}</small>
                                    </div>
                                    <div class="mb-3">
                                        <span class="badge bg-primary me-2">📅 ${ticket.date}</span>
                                        <span class="badge bg-success">🕐 ${ticket.time}</span>
                                    </div>
                                    <div class="mb-3">
                                        <h5 class="text-primary">💰 Rp ${Number(ticket.price).toLocaleString("id-ID")}</h5>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">🪑 ${availableSeats}/${totalSeats} seats available</small>
                                        <div class="progress mt-2" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                 style="width: ${(availableSeats / totalSeats) * 100}%">
                                            </div>
                                        </div>
                                    </div>
                                    ${
                                        availableSeats > 0
                                        ? `<button class="btn btn-primary w-100" onclick="selectSeat(${ticket.id})">🎫 Select Seats</button>`
                                        : `<button class="btn btn-secondary w-100" disabled>😞 Sold Out</button>`
                                    }
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += `</div></div></div>`;
                container.innerHTML += html;
            }
        })
        .catch(err => {
            document.getElementById("ticket-list").innerHTML = `
                <div class="alert alert-danger">Failed to load tickets. Please refresh.</div>
            `;
            console.error(err);
        });
}

function selectSeat(ticketId) {
    window.location.href = "/booking/select-seat/" + ticketId;
}
</script>
@endpush
