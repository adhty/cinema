@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 fw-bold text-dark">Dashboard</h1>
    
    {{-- Promo Navigation Bar --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">Promo Management</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.promos.index') }}" class="btn btn-primary w-100">
                        View All Promos
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.promos.index', ['status' => 'active']) }}" class="btn btn-success w-100">
                        Active Promos
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="{{ route('admin.promos.index', ['status' => 'expired']) }}" class="btn btn-danger w-100">
                        Expired Promos
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Cities Section --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 fw-bold text-primary">Cities</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $city)
                        <tr>
                            <td>{{ $city->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center text-muted">No cities found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
