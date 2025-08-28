<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    {{-- Sidebar --}}
    <aside class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
        <h3 class="mb-4">Admin Dashboard</h3>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('cinemas.index') }}" class="nav-link text-white">Cinemas</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('cities.index') }}" class="nav-link text-white">Cities</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('studios.index') }}" class="nav-link text-white">Studio</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('movies.index') }}" class="nav-link text-white">Movies</a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('promos.index') }}" class="nav-link text-white">Promos</a>
            </li>
            
            {{-- Tambah menu lain sesuai kebutuhan --}}
        </ul>
    </aside>

    {{-- Konten Utama --}}
    <main class="flex-grow-1 p-4 bg-light">
        @yield('content')
        
        {{-- Dashboard Content --}}
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
            
            {{-- Promo Navigation Bar --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Promo Management</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('promos.index') }}" class="btn btn-primary w-100">
                                View All Promos
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('promos.index', ['status' => 'active']) }}" class="btn btn-success w-100">
                                Active Promos
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('promos.index', ['status' => 'expired']) }}" class="btn btn-danger w-100">
                                Expired Promos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Cities Section --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cities</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cities as $city)
                                <tr>
                                    <td>{{ $city->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
