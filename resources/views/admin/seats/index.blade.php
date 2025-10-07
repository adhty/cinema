@extends('layouts.admin')

@section('content')
<h2>Pilih Kursi untuk Ticket #{{ $ticketId }}</h2>

<div>
    <label>Filter Ticket:</label>
    <select onchange="location = this.value">
        @foreach($tickets as $ticket)
            <option value="{{ route('admin.seats.index', ['ticket_id' => $ticket->id]) }}"
                {{ $ticket->id == $ticketId ? 'selected' : '' }}>
                {{ $ticket->movie->title ?? 'N/A' }} | {{ $ticket->date }} {{ $ticket->time }}
            </option>
        @endforeach
    </select>
</div>

<p>Total harga: Rp <span id="totalPrice">0</span></p>

<div id="seatContainer" style="display:grid; grid-template-columns:repeat(10,40px); gap:5px; margin-top:20px;">
    @foreach($seats as $seat)
        <div class="seat {{ $seat->status }}" 
             data-id="{{ $seat->id }}" 
             data-price="{{ $seat->ticket->price ?? 50000 }}">
            {{ $seat->row }}{{ $seat->number }}
        </div>
    @endforeach
</div>

<button id="bookBtn">Booking Selected Seats</button>

<style>
.seat {
    width: 40px;
    height: 40px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    font-weight: bold;
    color: white;
}
.available { background: green; }
.booked { background: red; cursor: not-allowed; }
.selected { background: yellow; color: black; }
</style>

<script>
// --- Ambil data user dan CSRF dari server (Blade) ---
const userId = parseInt("{{ auth()->id() }}") || 0;
const csrfToken = "{{ csrf_token() }}"; 

// --- Inisialisasi variabel ---
const seatContainer = document.getElementById('seatContainer');
let selectedSeats = [];
let totalPrice = 0;

// --- Fungsi update total harga ---
function updateTotalPrice() {
    totalPrice = selectedSeats.reduce((sum, seatId) => {
        const seatEl = document.querySelector(`.seat[data-id='${seatId}']`);
        return sum + parseInt(seatEl.dataset.price);
    }, 0);
    document.getElementById('totalPrice').textContent = totalPrice.toLocaleString();
}

// --- Klik kursi ---
seatContainer.addEventListener('click', e => {
    const seat = e.target;
    if (!seat.classList.contains('seat') || seat.classList.contains('booked')) return;

    seat.classList.toggle('selected');
    const seatId = seat.dataset.id;

    if (selectedSeats.includes(seatId)) {
        selectedSeats = selectedSeats.filter(id => id != seatId);
    } else {
        selectedSeats.push(seatId);
    }

    updateTotalPrice();
});

// --- Tombol Booking ---
document.getElementById('bookBtn').addEventListener('click', async () => {
    if (!selectedSeats.length) return alert('Pilih minimal 1 kursi');

    try {
        const response = await fetch('/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                user_id: userId,
                seat_ids: selectedSeats // kirim array kursi sekaligus
            })
        });

        const data = await response.json();

        if (data.success) {
            // Tandai kursi sudah dibooking
            selectedSeats.forEach(seatId => {
                document.querySelector(`.seat[data-id='${seatId}']`)
                    .classList.replace('selected', 'booked');
            });
            alert('Kursi berhasil dibooking!');
        } else {
            alert(data.message || 'Gagal booking kursi.');
        }
    } catch (error) {
        console.error('Error booking:', error);
        alert('Terjadi kesalahan pada server.');
    }

    // Reset pilihan
    selectedSeats = [];
    updateTotalPrice();
});
</script>
@endsection
