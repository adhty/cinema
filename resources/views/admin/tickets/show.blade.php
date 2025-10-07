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
        <div class="card-body">
            <h5 class="mb-3">💺 Layout Kursi</h5>

            <div class="d-flex flex-column align-items-center">
                <div class="screen mb-3 bg-dark text-white text-center p-2 rounded w-50">
                    LAYAR
                </div>

                {{-- Kursi Grid --}}
                <div class="seat-grid">
                    @php
                        $rows = ['A','B','C'];
                        $cols = [1,2,3,4,5];
                    @endphp

                    @foreach ($rows as $row)
                        <div class="d-flex justify-content-center mb-2">
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
                                            <button type="submit" class="btn btn-success btn-sm seat-btn">
                                                {{ $seatNum }}
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm seat-btn m-1" disabled>
                                            {{ $seatNum }}
                                        </button>
                                    @endif
                                @else
                                    <button class="btn btn-light btn-sm seat-btn m-1" disabled>?</button>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 text-muted small">
                <p>🟩 = Tersedia &nbsp;&nbsp; 🔳 = Sudah Dipesan</p>
            </div>
        </div>
    </div>
</div>

{{-- Styling kecil --}}
<style>
    .seat-grid {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .seat-btn {
        width: 48px;
        height: 48px;
        font-weight: bold;
    }
</style>
@endsection