@extends('layouts.app')

@section('content')
    <h1>Daftar Cinema</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('cinemas.create') }}" class="btn btn-primary">+ Tambah Cinema</a>
    </div>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th style="width:60px;">No</th>
                <th>Nama Cinema</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th style="width:160px;">Info</th>
                <th style="width:210px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cinemas as $cinema)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $cinema->name }}</td>
                    <td>{{ $cinema->address }}</td>
                    <td>{{ $cinema->city ? $cinema->city->name : '-' }}</td>
                    <td>
                        <button type="button"
                                class="btn btn-info btn-sm btn-cinema-info"
                                data-cinema-id="{{ $cinema->id }}">
                            Info Bioskop
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('cinemas.edit', $cinema->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('cinemas.destroy', $cinema->id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus cinema ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data cinema</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @php
        // Siapkan payload ringan untuk JS Modal
        $labels = ['xxi' => 'Cinema XXI', 'premiere' => 'The Premiere', 'imax' => 'IMAX'];
        $payload = [];
        foreach ($cinemas as $c) {
            // Tipe studio unik
            $types = $c->studios->pluck('type')->filter()->unique()->values()->all();

            // Helper min price per kategori
            $minOf = function ($key) use ($c) {
                $vals = $c->studios
                    ->map(fn($s) => optional($s->cinemaPrice)->{$key})
                    ->filter()
                    ->values()
                    ->all();
                return count($vals) ? min($vals) : 0;
            };

            $payload[$c->id] = [
                'id' => $c->id,
                'name' => $c->name,
                'address' => $c->address,
                'city' => optional($c->city)->name,
                // Gunakan placeholder image yang tersedia di public/
                'image' => asset('test-image.jpg'),
                'available_studios' => array_map(fn($t) => [
                    'type' => $t,
                    'label' => $labels[$t] ?? strtoupper((string) $t)
                ], $types),
                'price_summary' => [
                    'friday_price' => $minOf('friday_price'),
                    'weekday_price' => $minOf('weekday_price'),
                    'weekend_price' => $minOf('weekend_price'),
                ],
            ];
        }
    @endphp

    <!-- Modal Detail Cinema -->
    <div class="modal fade" id="cinemaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 14px; overflow: hidden;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" data-cm="title">Detail Bioskop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-0">
                    <img data-cm="image" src="{{ asset('test-image.jpg') }}" alt="Cinema Image" class="img-fluid rounded mb-3" style="object-fit: cover; max-height: 240px; width: 100%;">

                    <div class="p-3 rounded" style="background: #f8f9fa;">
                        <div class="mb-3">
                            <div class="fw-semibold mb-2">Studio tersedia:</div>
                            <div class="d-flex flex-wrap" data-cm="studios">
                                <!-- badges injected by JS -->
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="fw-semibold mb-2">Harga Tiket Masuk</div>
                            <div class="row g-2">
                                <div class="col-sm-4">
                                    <div class="border rounded p-2 h-100">
                                        <div class="text-muted small">Jum'at</div>
                                        <div class="fw-semibold" data-cm="friday">Rp0</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="border rounded p-2 h-100">
                                        <div class="text-muted small">Hari Biasa</div>
                                        <div class="fw-semibold" data-cm="weekday">Rp0</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="border rounded p-2 h-100">
                                        <div class="text-muted small">Akhir Pekan</div>
                                        <div class="fw-semibold" data-cm="weekend">Rp0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="fw-semibold mb-1">Alamat</div>
                            <div class="text-muted">
                                <span class="me-1">📍</span>
                                <span data-cm="address">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script id="cinemasPayload" type="application/json">{!! json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>

    <script>
        // Data bioskop untuk modal (dibangun di server)
        // Ambil payload dari tag JSON agar tidak mengganggu linter JS
        const payloadEl = document.getElementById('cinemasPayload');
        try {
            window.cinemasData = JSON.parse(payloadEl ? payloadEl.textContent : '{}');
        } catch (e) {
            window.cinemasData = {};
        }
        const fallbackImage = "{{ asset('test-image.jpg') }}";

        function formatRupiah(n) {
            const val = Number(n || 0);
            return 'Rp' + val.toLocaleString('id-ID');
        }

        function showCinemaModal(id) {
            const c = window.cinemasData[id];
            if (!c) return;

            const el = document.getElementById('cinemaModal');

            // Set judul dan gambar
            el.querySelector('[data-cm=title]').textContent = c.name || 'Detail Bioskop';
            el.querySelector('[data-cm=image]').src = c.image || fallbackImage;

            // Render studio badges
            const wrap = el.querySelector('[data-cm=studios]');
            wrap.innerHTML = '';
            (c.available_studios || []).forEach(s => {
                const span = document.createElement('span');
                span.className = 'badge rounded-pill bg-light text-dark border me-2 mb-2';
                span.textContent = s.label;
                wrap.appendChild(span);
            });
            if (!wrap.children.length) {
                const span = document.createElement('span');
                span.className = 'text-muted';
                span.textContent = 'Belum ada data studio';
                wrap.appendChild(span);
            }

            // Harga
            const ps = c.price_summary || {};
            el.querySelector('[data-cm=friday]').textContent = formatRupiah(ps.friday_price);
            el.querySelector('[data-cm=weekday]').textContent = formatRupiah(ps.weekday_price);
            el.querySelector('[data-cm=weekend]').textContent = formatRupiah(ps.weekend_price);

            // Alamat
            const addressText = [c.address, c.city].filter(Boolean).join(' — ');
            el.querySelector('[data-cm=address]').textContent = addressText || '-';

            // Tampilkan modal
            const bsModal = bootstrap.Modal.getOrCreateInstance(el);
            bsModal.show();
        }

        // Delegasi klik tombol info bioskop (hindari inline onclick)
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-cinema-info');
            if (!btn) return;
            const id = btn.getAttribute('data-cinema-id');
            showCinemaModal(id);
        });
    </script>
@endsection
