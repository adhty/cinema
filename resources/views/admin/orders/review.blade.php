@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Review Order</h2>

    <div class="row">
        <!-- Ringkasan Order -->
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-dark text-white">
                    Ringkasan Pesanan
                </div>
                <div class="card-body">
                    <p><strong>Bioskop:</strong> {{ $cinema->name }}</p>
                    <p><strong>Film:</strong> {{ $movie->title }}</p>
                    <p><strong>Studio:</strong> {{ $studio->name }}</p>
                    <p><strong>Jadwal:</strong> {{ $schedule->show_time }}</p>
                    <p><strong>Kursi:</strong> 
                        @foreach($seats as $seat)
                            <span class="badge bg-primary">{{ $seat }}</span>
                        @endforeach
                    </p>
                    <p><strong>Harga per Tiket:</strong> Rp{{ number_format($ticket_price,0,',','.') }}</p>
                    <p><strong>Total Bayar:</strong> 
                        <span class="text-success fw-bold">
                            Rp{{ number_format($ticket_price * count($seats),0,',','.') }}
                        </span>
                    </p>
                </div>
            </div>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="cinema_id" value="{{ $cinema->id }}">
                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                <input type="hidden" name="studio_id" value="{{ $studio->id }}">
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                <input type="hidden" name="seats" value="{{ implode(',', $seats) }}">
                <button type="submit" class="btn btn-success w-100">Konfirmasi & Bayar</button>
            </form>
        </div>

        <!-- Preview Ticket -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <img src="{{ asset('images/ticket-preview.jpg') }}" class="card-img-top" alt="Ticket Preview">
                <div class="card-body">
                    <h5 class="card-title">{{ $cinema->name }}</h5>
                    <p class="card-text mb-1"><strong>Film:</strong> {{ $movie->title }}</p>
                    <p class="card-text mb-1"><strong>Studio:</strong> {{ $studio->name }}</p>
                    <p class="card-text mb-1"><strong>Jadwal:</strong> {{ $schedule->show_time }}</p>
                    <p class="card-text mb-1"><strong>Kursi:</strong> {{ implode(', ', $seats) }}</p>
                    <p class="card-text"><strong>Total:</strong> Rp{{ number_format($ticket_price * count($seats),0,',','.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
