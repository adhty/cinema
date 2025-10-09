@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">🎟️ Detail Tiket</h2>

    {{-- Detail Tiket --}}
    <div class="card mb-4">
        <div class="card-body">
            <h4>{{ $ticket->movie->title }}</h4>
            <p><strong>Studio:</strong> {{ $ticket->studio->name }}</p>
            <p><strong>Kota:</strong> {{ $ticket->city->name }}</p>
            <p><strong>Bioskop:</strong> {{ $ticket->cinema->name }}</p>
            <p><strong>Tanggal:</strong> {{ $ticket->date }}</p>
            <p><strong>Jam:</strong> {{ $ticket->time }}</p>
            <p><strong>Harga:</strong> Rp{{ number_format($ticket->price, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Layout Kursi --}}
    <div class="card">
        <div class="card-body text-center">
            <h5 class="mb-3">💺 Layout Kursi</h5>

            <div class="screen mb-3 bg-dark text-white p-2 rounded mx-auto" style="max-width: 300px;">
                LAYAR
            </div>

            <div class="d-flex flex-column align-items-center">
                @php
                    $rows = ['A','B','C']; // bisa diganti sesuai studio
                    $cols = [1,2,3,4,5];
                @endphp

                @foreach ($rows as $row)
                    <div class="d-flex justify-content-center mb-2 flex-wrap">
                        @foreach ($cols as $col)
                            @php
                                $seatNum = $row.$col;
                                $seat = $ticket->seats->where('number', $seatNum)->first();
                            @endphp

                            @if ($seat)
                                @if ($seat->status === 'available')
                                    <form action="{{ route('admin.orders.store') }}" method="POST" class="m-1">
                                        @csrf
                                        <input type="hidden" name="seat_id" value="{{ $seat->id }}">
                                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                        <button type="submit" class="btn seat-btn available">
                                            {{ $seatNum }}
                                        </button>
                                    </form>
                                @else
                                    <button class="btn seat-btn booked m-1" disabled>{{ $seatNum }}</button>
                                @endif
                            @else
                                <button class="btn seat-btn unknown m-1" disabled>?</button>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>

            {{-- Legenda --}}
            <div class="mt-4">
                <span class="badge bg-success me-2">🟩 Tersedia</span>
                <span class="badge bg-secondary me-2">🔳 Sudah Dipesan</span>
            </div>
        </div>
    </div>
</div>

{{-- Styling --}}
<style>
    .seat-btn {
        width: 48px;
        height: 48px;
        font-weight: bold;
        border-radius: 8px;
        transition: transform 0.2s;
    }

    .seat-btn.available {
        background-color: #28a745;
        color: white;
    }

    .seat-btn.available:hover {
        transform: scale(1.1);
        cursor: pointer;
    }

    .seat-btn.booked {
        background-color: #6c757d;
        color: white;
    }

    .seat-btn.unknown {
        background-color: #f8f9fa;
        color: #6c757d;
    }

    @media (max-width: 576px) {
        .seat-btn {
            width: 36px;
            height: 36px;
            font-size: 0.8rem;
        }

        .screen {
            max-width: 200px;
        }
    }
</style>
@endsection
