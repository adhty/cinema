<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* Layout */
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        .main {
            display: flex;
            flex: 1;
            min-height: 0; /* allows children to size properly when sticky */
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #343a40;
            color: #fff;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            align-self: flex-start;
            min-height: calc(100vh - 56px); /* account for navbar height */
            padding-bottom: 1rem;
        }
        .sidebar h4 {
            padding: 16px 20px;
            text-align: left;
            margin: 0;
            background: #212529;
            font-size: 1.1rem;
        }
        .sidebar .nav-link {
            color: #fff;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: .375rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #495057;
            color: #fff;
        }

        /* Content */
        .content {
            flex-grow: 1;
            padding: 20px;
            background: #f8f9fa;
            min-width: 0; /* prevent overflow with long content */
        }

        /* Responsive: hide static sidebar on small screens (use offcanvas) */
        @media (max-width: 991.98px) {
            .sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar Atas -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('movies.index') }}">Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cities.index') }}">Cities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cinemas.index') }}">Cinemas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('studios.index') }}">Studios</a>
                    </li>
                </ul>
            </div> -->
        </div>
    </nav>
    <!-- Mobile Offcanvas Sidebar -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('movies.*') ? 'active' : '' }}" href="{{ route('movies.index') }}">Movies</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('cities.*') ? 'active' : '' }}" href="{{ route('cities.index') }}">Cities</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('cinemas.*') ? 'active' : '' }}" href="{{ route('cinemas.index') }}">Cinemas</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('studios.*') ? 'active' : '' }}" href="{{ route('studios.index') }}">Studios</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('promos.*') ? 'active' : '' }}" href="{{ route('promos.index') }}">Promos</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}" href="{{ route('tickets.index') }}">Tickets</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('seats.*') ? 'active' : '' }}" href="{{ route('seats.index') }}">Seats</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('booking.*') ? 'active' : '' }}" href="{{ route('booking.index') }}">🎫 Book Tickets</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar + Konten -->
    <div class="main">
        <!-- Sidebar -->
        <div class="sidebar d-none d-lg-block">
            <h4>Menu</h4>
            <ul class="nav nav-pills flex-column p-3">
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('movies.*') ? 'active' : '' }}" href="{{ route('movies.index') }}">Movies</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('cities.*') ? 'active' : '' }}" href="{{ route('cities.index') }}">Cities</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('cinemas.*') ? 'active' : '' }}" href="{{ route('cinemas.index') }}">Cinemas</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('studios.*') ? 'active' : '' }}" href="{{ route('studios.index') }}">Studios</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('promos.*') ? 'active' : '' }}" href="{{ route('promos.index') }}">Promos</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}" href="{{ route('tickets.index') }}">Tickets</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('seats.*') ? 'active' : '' }}" href="{{ route('seats.index') }}">Seats</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('booking.*') ? 'active' : '' }}" href="{{ route('booking.index') }}">🎫 Book Tickets</a>
                </li>
                {{-- Tambah menu lain sesuai kebutuhan --}}
            </ul>
        </div>

        <!-- Konten Utama -->
        <div class="content">
            <div class="mb-3">
                <button type="button" id="globalBackBtn" class="btn btn-secondary">&larr; Back</button>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            var btn = document.getElementById('globalBackBtn');
            if (!btn) return;
            btn.addEventListener('click', function () {
                try {
                    var ref = document.referrer;
                    var sameOrigin = ref && new URL(ref).origin === window.location.origin;
                    if (sameOrigin && window.history.length > 1) {
                        window.history.back();
                        return;
                    }
                } catch (e) {}
                var path = window.location.pathname.replace(/^\/+/, '');
                var first = path.split('/')[0] || '';
                var fallback = '/' + first;
                if (!first) {
                    // default fallback to home/dashboard if no segment
                    fallback = '/';
                }
                window.location.assign(fallback);
            });
        })();
    </script>
</body>
</html>
