@extends('layouts.app')

@section('title', 'Detail Kursi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Detail Kursi</h3>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><strong>Nomor Kursi:</strong> {{ $seat->number }}</li>
            <li class="list-group-item"><strong>Status:</strong> 
                @if($seat->status === 'available')
                    <span class="badge bg-success">Tersedia</span>
                @else
                    <span class="badge bg-danger">Terpesan</span>
                @endif
            </li>
            <li class="list-group-item"><strong>Film:</strong> {{ $seat->ticket->movie->title ?? '-' }}</li>
            <li class="list-group-item"><strong>Bioskop:</strong> {{ $seat->ticket->cinema->name ?? '-' }}</li>
        </ul>
        <div class="mt-3">
            <a href="{{ route('admin.seats.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
