<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1c8e1b8a58.js" crossorigin="anonymous"></script>
    <style>
        body {
            overflow-x: hidden;
        }
        aside {
            min-height: 100vh;
        }
        .nav-link.active {
            background-color: #495057;
            border-radius: 8px;
        }
        .navbar-brand span {
            color: #ffc107;
        }
    </style>
</head>
<body>
    {{-- Navbar Atas --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-film me-2"></i> <span>Cinema</span> Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" 
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                            <i class="fa-solid fa-gauge"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link text-white">
                            <i class="fa-solid fa-ticket"></i> Orders
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-circle"></i> {{ Auth::user()->name ?? 'Admin' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Body: Sidebar + Konten --}}
    <div class="d-flex">
        {{-- Sidebar --}}
        <aside class="bg-dark text-white p-3" style="width:250px;">
            <h4 class="mb-4 text-center">Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.movies.index') }}" class="nav-link text-white {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-clapperboard me-2"></i> Movies
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.cinemas.index') }}" class="nav-link text-white {{ request()->routeIs('admin.cinemas.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-building me-2"></i> Cinemas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.cities.index') }}" class="nav-link text-white {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-city me-2"></i> Cities
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.studios.index') }}" class="nav-link text-white {{ request()->routeIs('admin.studios.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-tv me-2"></i> Studios
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.tickets.index') }}" class="nav-link text-white {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-ticket me-2"></i> Tickets
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.seats.index') }}" class="nav-link text-white {{ request()->routeIs('admin.seats.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chair me-2"></i> Seats
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-list me-2"></i> Orders
                    </a>
                </li>

                {{-- 🔹 Tambahan Menu Users --}}
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.users.index') }}" class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users me-2"></i> Manajemen Users
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="#promoSubmenu" data-bs-toggle="collapse" class="nav-link text-white">
                        <i class="fa-solid fa-gift me-2"></i> Promos
                    </a>
                    <ul class="collapse nav flex-column ms-3" id="promoSubmenu">
                        <li class="nav-item">
                            <a href="{{ route('admin.promos.index') }}" class="nav-link text-white">All Promos</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.promos.index', ['status' => 'active']) }}" class="nav-link text-white">Active Promos</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.promos.index', ['status' => 'expired']) }}" class="nav-link text-white">Expired Promos</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </aside>

        {{-- Konten Utama --}}
        <main class="flex-grow-1 p-4 bg-light">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
