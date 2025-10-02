@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Tambah Kursi</h2>
    <form action="{{ route('admin.seats.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="ticket_id" class="form-label">Ticket</label>
            <select name="ticket_id" id="ticket_id" class="form-control" required>
                <option value="">-- Pilih Ticket --</option>
                @foreach($tickets as $ticket)
                    <option value="{{ $ticket->id }}">
                        {{ $ticket->movie->title }} | {{ $ticket->studio->name }} | {{ $ticket->date }} {{ $ticket->time }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="number" class="form-label">Nomor Kursi</label>
            <input type="text" name="number" id="number" class="form-control" placeholder="misal A1, B2" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="available">Available</option>
                <option value="booked">Booked</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.seats.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
