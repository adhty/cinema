@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-2xl p-8 mt-10">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-purple-700">
            Pilih Kursi untuk Ticket #{{ $ticketId }}
        </h2>
        <div>
            <label for="ticketFilter" class="text-sm font-semibold text-gray-600 mr-2">Filter Ticket:</label>
            <select id="ticketFilter" onchange="location = this.value"
                class="border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 px-3 py-2">
                @foreach($tickets as $ticket)
                    <option value="{{ route('admin.seats.index', ['ticket_id' => $ticket->id]) }}"
                        {{ $ticket->id == $ticketId ? 'selected' : '' }}>
                        🎥 {{ $ticket->movie->title ?? 'N/A' }} — {{ $ticket->date }} {{ $ticket->time }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Total harga --}}
    <div class="text-lg font-semibold text-gray-700 mb-4">
        Total harga: <span class="text-purple-700 font-bold">Rp <span id="totalPrice">0</span></span>
    </div>

    {{-- Seat container --}}
    <div class="border-t border-gray-200 pt-6">
        <div id="seatContainer"
            class="grid grid-cols-10 gap-2 justify-center text-sm font-medium select-none">
            @foreach($seats as $seat)
                <div class="seat {{ $seat->status }} rounded-lg w-10 h-10 flex items-center justify-center transition duration-200"
                     data-id="{{ $seat->id }}"
                     data-price="{{ $seat->ticket->price ?? 50000 }}">
                    {{ $seat->row }}{{ $seat->number }}
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-center">
            <div class="flex items-center space-x-4 text-sm text-gray-600">
                <div class="flex items-center"><div class="w-4 h-4 bg-green-500 rounded mr-1"></div> Tersedia</div>
                <div class="flex items-center"><div class="w-4 h-4 bg-yellow-400 rounded mr-1"></div> Dipilih</div>
                <div class="flex items-center"><div class="w-4 h-4 bg-red-500 rounded mr-1"></div> Sudah Dipesan</div>
            </div>
        </div>
    </div>

    {{-- Button Booking --}}
    <div class="mt-8 text-center">
        <button id="bookBtn"
            class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-6 py-3 rounded-xl shadow-md transition duration-200">
            Booking Kursi Terpilih
        </button>
    </div>
</div>

{{-- Custom seat styles --}}
<style>
.seat {
    cursor: pointer;
    color: white;
}
.available { background: #22c55e; } /* green-500 */
.booked { background: #ef4444; cursor: not-allowed; opacity: 0.7; } /* red-500 */
.selected { background: #facc15; color: #000; } /* yellow-400 */
.seat:hover:not(.booked):not(.selected) {
    background: #16a34a; /* green-600 */
    transform: scale(1.05);
}
</style>

{{-- Seat Logic --}}
<script>
const userId = parseInt("{{ auth()->id() }}") || 0;
const csrfToken = "{{ csrf_token() }}";
const seatContainer = document.getElementById('seatContainer');
let selectedSeats = [];
let totalPrice = 0;

function updateTotalPrice() {
    totalPrice = selectedSeats.reduce((sum, seatId) => {
        const seatEl = document.querySelector(`.seat[data-id='${seatId}']`);
        return sum + parseInt(seatEl.dataset.price);
    }, 0);
    document.getElementById('totalPrice').textContent = totalPrice.toLocaleString();
}

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
                seat_ids: selectedSeats
            })
        });

        const data = await response.json();

        if (data.success) {
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

    selectedSeats = [];
    updateTotalPrice();
});
</script>
@endsection
