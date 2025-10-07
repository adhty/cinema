@extends('layouts.admin')

@section('title', 'Detail Kursi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Detail Kursi</h3>
    </div>
    <div class="card-body">
        <ul class="list-group">
            {{-- Nomor Kursi --}}
            <li class="list-group-item">
                <strong>Nomor Kursi:</strong> {{ $seat->number }}
            </li>

            {{-- Status Kursi --}}
            <li class="list-group-item">
                <strong>Status:</strong> 
                @if($seat->status === 'available')
                    <span class="badge bg-success">Tersedia</span>
                @else
                    <span class="badge bg-danger">Terpesan</span>
                @endif
            </li>

            {{-- Film --}}
            <li class="list-group-item">
                <strong>Film:</strong> {{ $seat->ticket->movie->title ?? '-' }}
            </li>

            {{-- Cinema --}}
            <li class="list-group-item">
                <strong>Bioskop:</strong> {{ $seat->ticket->cinema->name ?? '-' }}
            </li>

            {{-- Studio --}}
            <li class="list-group-item">
                <strong>Studio:</strong> {{ $seat->ticket->studio->name ?? '-' }}
            </li>
        </ul>

        {{-- Orders yang booking seat ini --}}
        @if($seat->orders->count())
            <h5 class="mt-4">Data Pemesan Kursi</h5>
            <ul class="list-group">
                @foreach($seat->orders as $order)
                    <li class="list-group-item">
                        <strong>User:</strong> {{ $order->user->name ?? 'Unknown' }} <br>
                        <strong>Payment:</strong> {{ $order->payment ?? '-' }}
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mt-3">
            <a href="{{ route('admin.seats.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
