<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa; /* lebih netral, tidak gelap banget */
            color: #212529;
        }

        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            padding: 20px 15px;
            color: white;
        }

        .sidebar h4 {
            color: #ffc107;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .nav-link {
            color: #e0e0e0;
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
            padding: 8px 12px;
        }

        .nav-link:hover {
            background-color: #ffc107;
            color: #1a1a1a !important;
            transform: translateX(3px);
        }

        .nav-link.active {
            background-color: #ffc107;
            color: #1a1a1a !important;
            font-weight: 600;
        }

        .rotate {
            transform: rotate(180deg);
            transition: 0.25s;
        }

        main {
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin: 15px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row g-0"> {{-- tambahin g-0 biar sidebar & konten nyatu rapat --}}
            
            {{-- Sidebar --}}
            <div class="col-md-2 col-lg-2 sidebar">
                <h4 class="text-center">🎬 Admin Panel</h4>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-house me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.cities.index') }}" class="nav-link {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-city me-2"></i> Cities
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.cinemas.index') }}" class="nav-link {{ request()->routeIs('admin.cinemas.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-building me-2"></i> Cinemas
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.studios.index') }}" class="nav-link {{ request()->routeIs('admin.studios.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-tv me-2"></i> Studios
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.movies.index') }}" class="nav-link {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-clapperboard me-2"></i> Movies
                        </a>
                    </li>
                    <!-- <li class="nav-item mb-2">
                        <a href="{{ route('admin.actors.index') }}" class="nav-link {{ request()->routeIs('admin.actors.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-user-tie me-2"></i> Actors
                        </a>
                    </li> -->
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.promos.index') }}" class="nav-link {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-gift me-2"></i> Promos
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.tickets.index') }}" class="nav-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-ticket me-2"></i> Tickets
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.seats.index') }}" class="nav-link {{ request()->routeIs('admin.seats.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-chair me-2"></i> Seats
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-receipt me-2"></i> Orders
                        </a>
                    </li>

                    {{-- Manajemen User --}}
                    @php
                        $userMenuActive = request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*');
                    @endphp
                    <li class="nav-item mb-2">
                        <a href="#userSubmenu" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center {{ $userMenuActive ? 'active' : '' }}">
                            <span><i class="fa-solid fa-users me-2"></i> Manajemen User</span>
                            <i class="fa-solid fa-chevron-down small {{ $userMenuActive ? 'rotate' : '' }}"></i>
                        </a>
                        <ul class="collapse nav flex-column ms-3 {{ $userMenuActive ? 'show' : '' }}" id="userSubmenu">
                            <li class="nav-item">
                                <a href="#" class="nav-link py-1 {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-key me-2"></i> Roles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link py-1 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-gear me-2"></i> Users
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            {{-- Main Content --}}
            <div class="col-md-10 col-lg-10">
                <main>
                    @yield('content')
                </main>
            </div>

        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
