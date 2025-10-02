@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Booking Seats - {{ $ticket->movie->title }}</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST" id="bookingForm">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <input type="hidden" name="movie_id" value="{{ $ticket->movie->id }}">
        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
        <input type="hidden" name="seats" id="selectedSeats">

        <div class="seats-container" style="display: flex; flex-wrap: wrap; width: 300px;">
            @foreach($seats as $seat)
                <div class="seat {{ $seat->status == 'booked' ? 'booked' : 'available' }}" 
                     data-seat="{{ $seat->number }}">
                    {{ $seat->number }}
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">Book Now</button>
    </form>
</div>

<style>
    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        line-height: 40px;
        text-align: center;
        border-radius: 5px;
        cursor: pointer;
        user-select: none;
    }
    .available {
        background-color: #28a745;
        color: white;
    }
    .booked {
        background-color: #dc3545;
        color: white;
        cursor: not-allowed;
    }
    .selected {
        background-color: #ffc107;
        color: black;
    }
</style>

<script>
    const seats = document.querySelectorAll('.seat.available');
    const selectedSeatsInput = document.getElementById('selectedSeats');
    let selectedSeats = [];

    seats.forEach(seat => {
        seat.addEventListener('click', () => {
            const seatNumber = seat.dataset.seat;
            if (selectedSeats.includes(seatNumber)) {
                // unselect
                selectedSeats = selectedSeats.filter(s => s !== seatNumber);
                seat.classList.remove('selected');
            } else {
                // select
                selectedSeats.push(seatNumber);
                seat.classList.add('selected');
            }
            selectedSeatsInput.value = selectedSeats.join(',');
        });
    });

    // Submit form: convert comma string to array
    document.getElementById('bookingForm').addEventListener('submit', function(e){
        const seatsStr = selectedSeatsInput.value;
        const seatsArray = seatsStr ? seatsStr.split(',') : [];
        // buat input hidden multiple untuk laravel
        if(seatsArray.length > 0){
            selectedSeatsInput.remove();
            seatsArray.forEach(s => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'seats[]';
                input.value = s;
                this.appendChild(input);
            });
        }
    });
</script>
@endsection
