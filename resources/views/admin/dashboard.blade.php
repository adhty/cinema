@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark mb-0">Dashboard</h1>
        <span class="text-muted">Welcome back, {{ Auth::user()->name ?? 'Admin' }} 👋</span>
    </div>

    {{-- Promo Management --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pb-0">
            <h5 class="fw-semibold text-primary mb-3">Promo Management</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="{{ route('admin.promos.index') }}" class="btn btn-outline-primary w-100 py-2">
                        <i class="fa-solid fa-list me-2"></i>View All Promos
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('admin.promos.index', ['status' => 'active']) }}" class="btn btn-outline-success w-100 py-2">
                        <i class="fa-solid fa-check me-2"></i>Active Promos
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('admin.promos.index', ['status' => 'expired']) }}" class="btn btn-outline-danger w-100 py-2">
                        <i class="fa-solid fa-clock me-2"></i>Expired Promos
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Cities Section --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
            <h5 class="fw-semibold text-primary mb-3">Cities</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $city)
                            <tr>
                                <td>{{ $city->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center text-muted py-4">No cities found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
