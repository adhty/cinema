<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Body: Sidebar + Konten -->
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
            <h3 class="mb-4">Menu</h3>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('movies.index') }}" class="nav-link text-white {{ request()->routeIs('movies.*') ? 'active' : '' }}">Movies</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('cities.index') }}" class="nav-link text-white {{ request()->routeIs('cities.*') ? 'active' : '' }}">Cities</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('cinemas.index') }}" class="nav-link text-white {{ request()->routeIs('cinemas.*') ? 'active' : '' }}">Cinemas</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('studios.index') }}" class="nav-link text-white {{ request()->routeIs('studios.*') ? 'active' : '' }}">Studios</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('promos.index') }}" class="nav-link text-white {{ request()->routeIs('promos.*') ? 'active' : '' }}">Promos</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('tickets.index') }}" class="nav-link text-white {{ request()->routeIs('tickets.*') ? 'active' : '' }}">Tickets</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('seats.index') }}" class="nav-link text-white {{ request()->routeIs('seats.*') ? 'active' : '' }}">Seats</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('orders.index') }}" class="nav-link text-white {{ request()->routeIs('orders.*') ? 'active' : '' }}">Orders</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('booking.index') }}" class="nav-link text-white {{ request()->routeIs('booking.*') ? 'active' : '' }}">Book Tickets</a>
                </li>
            </ul>
        </aside>

        <!-- Konten Utama -->
        <main class="flex-grow-1 p-4 bg-light">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
