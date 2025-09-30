@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">
        Booking Seat - {{ $ticket->movie->title }} <br>
        <small>{{ $ticket->cinema->name }} - {{ $ticket->studio->name }} | {{ $ticket->date }} {{ $ticket->time }}</small>
    </h2>

    <div id="seat-map" class="d-flex flex-column gap-2">
        @foreach ($seats as $row => $rowSeats)
            <div class="d-flex gap-2">
                <span class="fw-bold">{{ $row }}</span>
                @foreach ($rowSeats as $seat)
                    <button 
                        class="seat btn 
                               {{ $seat->isAvailable() ? 'btn-outline-primary' : 'btn-danger disabled' }}"
                        data-id="{{ $seat->id }}"
                        {{ !$seat->isAvailable() ? 'disabled' : '' }}
                    >
                        {{ $seat->number }}
                    </button>
                @endforeach
            </div>
        @endforeach
    </div>

    <hr>

    <h4>Selected Seats</h4>
    <ul id="selected-seats" class="list-group mb-3"></ul>

    <h5>Total: Rp <span id="total-price">0</span></h5>

    <button id="proceed-btn" class="btn btn-success mt-2" disabled>Proceed to Payment</button>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    let selectedSeats = {};
    let ticketPrice = {{ $ticket->price }};

    // Klik kursi
    document.querySelectorAll(".seat").forEach(btn => {
        btn.addEventListener("click", function () {
            let seatId = this.dataset.id;
            let isSelected = this.classList.contains("btn-success");

            if (isSelected) {
                // Unselect
                fetch("{{ route('booking.unselectSeat') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ seat_id: seatId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove("btn-success");
                        this.classList.add("btn-outline-primary");
                        delete selectedSeats[seatId];
                        renderSummary();
                    }
                });

            } else {
                // Select
                fetch("{{ route('booking.selectSeat') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ seat_id: seatId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove("btn-outline-primary");
                        this.classList.add("btn-success");
                        selectedSeats[data.seat_id] = data.seat_number;
                        renderSummary();
                    } else {
                        alert(data.message);
                    }
                });
            }
        });
    });

    // Tampilkan summary kursi & total harga
    function renderSummary() {
        let list = document.getElementById("selected-seats");
        list.innerHTML = "";
        let total = 0;

        for (let id in selectedSeats) {
            let li = document.createElement("li");
            li.classList.add("list-group-item");
            li.innerText = selectedSeats[id];
            list.appendChild(li);
            total += ticketPrice;
        }

        document.getElementById("total-price").innerText = total.toLocaleString();
        document.getElementById("proceed-btn").disabled = Object.keys(selectedSeats).length === 0;
    }

    // Konfirmasi booking
    document.getElementById("proceed-btn").addEventListener("click", function () {
        let seatIds = Object.keys(selectedSeats);

        fetch("{{ route('booking.confirm') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ seat_ids: seatIds })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect_url;
            } else {
                alert(data.message);
            }
        });
    });
});
</script>
@endsection
