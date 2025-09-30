@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Jadwal Tayang (AJAX)</h1>

    <div class="row g-3 mb-4">
        <div class="col-md-5">
            <label for="cinema_id" class="form-label">Pilih Bioskop</label>
            <select id="cinema_id" class="form-select">
                @foreach($cinemas as $cinema)
                    <option value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-5">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" id="date" class="form-control" value="{{ now()->toDateString() }}">
        </div>
    </div>

    {{-- Tempat jadwal tayang --}}
    <div id="schedule-results">
        <p class="text-muted">Silakan pilih bioskop dan tanggal.</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
async function loadSchedule() {
    const cinemaId = document.getElementById('cinema_id').value;
    const date = document.getElementById('date').value;

    const url = `/api/schedule/${cinemaId}/${date}`;
    const response = await fetch(url);
    const data = await response.json();

    const container = document.getElementById('schedule-results');
    container.innerHTML = '';

    if (Object.keys(data).length === 0) {
        container.innerHTML = `<div class="alert alert-warning">Tidak ada jadwal untuk tanggal ini.</div>`;
        return;
    }

    // Loop film
    for (const [movieId, tickets] of Object.entries(data)) {
        const movie = tickets[0].movie;

        let html = `
            <div class="card mb-4">
                <div class="card-body">
                    <h4>${movie.title}</h4>
                    <p><small>Durasi: ${movie.duration ?? '-'} menit</small></p>
                    <div class="d-flex flex-wrap gap-2">
        `;

        // Loop jam tayang
        for (const ticket of tickets) {
            const time = new Date('1970-01-01T' + ticket.time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            html += `<a href="/tickets/${ticket.id}" class="btn btn-outline-primary btn-sm">${time}</a>`;
        }

        html += `</div></div></div>`;
        container.innerHTML += html;
    }
}

// Event listener
document.getElementById('cinema_id').addEventListener('change', loadSchedule);
document.getElementById('date').addEventListener('change', loadSchedule);

// Load pertama kali
loadSchedule();
</script>
@endsection
