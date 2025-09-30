@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">
        Pilih Kursi untuk 
        <strong>{{ $ticket->movie->title }}</strong> <br>
        {{ $ticket->cinema->name }} - Studio {{ $ticket->studio->name }} <br>
        {{ $ticket->date }} {{ $ticket->time }}
    </h2>

    {{-- Grid kursi --}}
    <div class="seat-grid" 
         style="display: grid; grid-template-columns: repeat(10, 40px); gap: 10px;">
        @foreach ($seats as $seat)
            <div class="seat 
                        {{ $seat->status === 'booked' ? 'booked' : 'available' }}"
                 data-id="{{ $seat->id }}"
                 data-status="{{ $seat->status }}">
                {{ $seat->number }}
            </div>
        @endforeach
    </div>

    {{-- Tombol booking --}}
    <div class="mt-4">
        <button id="bookSeatBtn" class="btn btn-primary" disabled>
            Booking Kursi
        </button>
    </div>
</div>

{{-- Styling kursi --}}
<style>
    .seat {
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 6px;
        cursor: pointer;
        border: 1px solid #ccc;
    }
    .seat.available { background-color: #e2f0d9; }  /* hijau muda */
    .seat.booked { background-color: #f8d7da; cursor: not-allowed; } /* merah */
    .seat.selected { background-color: #cce5ff; } /* biru */
</style>

{{-- Script AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let selectedSeatId = null;

    $(document).ready(function () {
        // Klik kursi
        $('.seat.available').on('click', function () {
            $('.seat').removeClass('selected');
            $(this).addClass('selected');
            selectedSeatId = $(this).data('id');
            $('#bookSeatBtn').prop('disabled', false);
        });

        // Klik tombol booking
        $('#bookSeatBtn').on('click', function () {
            if (!selectedSeatId) return;

            $.ajax({
                url: "{{ route('orders.store') }}", // pastikan route ini ada
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    seat_id: selectedSeatId,
                    user_id: "{{ auth()->id() }}" // kalau udah ada auth
                },
                success: function (response) {
                    alert("Kursi berhasil dipesan!");
                    location.reload();
                },
                error: function () {
                    alert("Gagal booking kursi, coba lagi.");
                }
            });
        });
    });
</script>
@endsection
