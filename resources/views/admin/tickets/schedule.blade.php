@section('scripts')
<script>
async function loadSchedule() {
    const cinemaId = document.getElementById('cinema_id').value;
    const date = document.getElementById('date').value;

    const container = document.getElementById('schedule-results');
    container.innerHTML = `<div class="text-center my-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>`;

    try {
        const url = `/api/schedule/${cinemaId}/${date}`;
        const response = await fetch(url);
        const data = await response.json();

        container.innerHTML = '';

        if (!data || Object.keys(data).length === 0) {
            container.innerHTML = `<div class="alert alert-warning">Tidak ada jadwal untuk tanggal ini.</div>`;
            return;
        }

        for (const [movieId, tickets] of Object.entries(data)) {
            const movie = tickets[0].movie;

            let html = `
                <div class="card mb-4">
                    <div class="card-body">
                        <h4>${movie.title}</h4>
                        <p><small>Durasi: ${movie.duration ?? '-'} menit</small></p>
                        <div class="d-flex flex-wrap gap-2 mt-2">
            `;

            for (const ticket of tickets) {
                const time = new Date('1970-01-01T' + ticket.time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                html += `<a href="/tickets/${ticket.id}" class="btn btn-outline-primary btn-sm">${time}</a>`;
            }

            html += `</div></div></div>`;
            container.innerHTML += html;
        }
    } catch (err) {
        container.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat memuat jadwal.</div>`;
        console.error(err);
    }
}

document.getElementById('cinema_id').addEventListener('change', loadSchedule);
document.getElementById('date').addEventListener('change', loadSchedule);

// Load pertama kali
loadSchedule();
</script>
@endsection
